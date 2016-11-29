<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\StoreSettings;

use App\Product;
use App\ShopifyApiThrottle;
use Request;

class ProductsImporter extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $store_settings;
    protected $request;

    /**
     * ProductsExportAndImport constructor.
     *
     * Create a new job instance.
     *
     * @param StoreSettings $store_settings
     */
    public function __construct(StoreSettings $store_settings, $request)
    {
        $this->store_settings = $store_settings;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*********** Export Products From Master Store ************/
        $master_store_products = $this->exportProducts();

        /*********** Import Products In Child Store ************/
        $this->importProductsInDatabase($master_store_products);
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        // Called when the job is failing...
    }


    /**
     * Export All Products From Master Store
     *
     * @return array
     */
    private function exportProducts(){
        Product::initStore($this->store_settings->store_name, config('shopify.api_key'), $this->store_settings->access_token);
        $products_count = Product::count();
        $products_per_page = 250;
        $number_of_pages = ceil($products_count/$products_per_page);
        $all_products = [];
        $products = [];
        //to init start time
        ShopifyApiThrottle::init();
        for( $page = 1; $page <= $number_of_pages; $page++ ){
            //wait for some time so it doesn't reach throttle point
            if( $page > 1 ){ ShopifyApiThrottle::wait(); }

            $products = Product::all([
                'limit' => $products_per_page,
                'page'  => $page
            ]);
            if($products)
                $all_products = array_merge($all_products, $products);
            //to re-init start time
            ShopifyApiThrottle::init();
        }
        return $all_products;
    }

    private function import($products){
        $new_products = [];

        $already_existing_product_ids = array_column($products, 'id');
        $already_existing_product = Product::whereIn('product_id', $already_existing_product_ids)->;

        $now = \Carbon\Carbon::now()->toDateTimeString();
        foreach( $products as $index => $product ){
            $new_products[] = [
                'product_id'    =>  $product['id'],
                'handle'        =>  $product['handle'],
                'created_at'    =>  $now,
                'updated_at'    =>  $now
            ];
        }
        Product::insert($new_products);
    }

    private function importProductsInDatabase($products){
        Product::initStore( $this->store_settings->client_store_url, $this->store_settings->client_store_api_key, $this->store_settings->client_store_password, true);
        $import_settings = $this->request;
        $skip_flag = false;
        //to init start time
        ShopifyApiThrottle::init();
        foreach( $products as $index => $product ){
            $skip_flag = false;
            //wait for some time so it doesn't reach throttle point
            if( $index > 0 ){ ShopifyApiThrottle::wait(); }

            //if product needs to be made hidden
            if(isset($import_settings['hidden']) && $import_settings['hidden'] == 'yes'){
                $product['published_at'] = null;
            }

            $already_existed_product = Product::findByHandle($product['handle']);
            if($already_existed_product){
                if(isset($import_settings['overwriteProducts']) && $import_settings['overwriteProducts'] == 'yes'){
                    $product['id'] = $already_existed_product['id'];
                } else{
                    $skip_flag = true;
                }
            } else{
                unset($product['id']);
            }

            if( !$skip_flag ){
                $DESC = $product['body_html'];
                $product['body_html'] = $this->clean_html_string($DESC);
                Product::save($product);
            }

            //to re-init start time
            ShopifyApiThrottle::init();
        }
    }

    private function clean_html_string($string){
        $string = $this->escapeJsonString(($string));
        return $string;
    }

    function escapeJsonString($value) {
        //# list from www.json.org: (\b backspace, \f formfeed)
        $escapers = array("\\", "/", "\"", "\0", "\u", " ", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", " ", "", " ", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }
}
