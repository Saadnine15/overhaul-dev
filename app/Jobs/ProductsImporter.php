<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\StoreSettings;

use App\Models\Product as ProductModel;
use App\Models\ProductVariant as ProductVariantModel;

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
    public function __construct(StoreSettings $store_settings)
    {
        $this->store_settings = $store_settings;
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

    private function importProductsInDatabase($products){

        $this->deleteAlreadyExistingVariants();
        //$this->insertProductsInDatabase($products);

    }

    private function deleteAlreadyExistingVariants(){
        $product_ids = ProductModel::where('store_url', $this->store_settings->shop_name)->pluck('product_id', 'id')->toArray();
        //if( !empty($product_ids) ){
            ProductVariantModel::whereIn('product_id', $product_ids)->delete();
        //}
    }

    private function insertProductsInDatabase($products){
        $new_products = [];
        $new_variants = [];
        $product_ids = array_column($products, 'id');
        $already_existing_product_ids = ProductModel::whereIn('product_id', $product_ids)->pluck('product_id', 'handle')->toArray();

        $now = \Carbon\Carbon::now()->toDateTimeString();



        foreach( $products as $index => $product ){

            $id_already_exists = false;
            $handle_already_exists = false;
            if( $already_existing_product_ids && !empty($already_existing_product_ids && is_array($already_existing_product_ids)) ){
                $handle = array_search($product['id'], $already_existing_product_ids);
                $id_already_exists = in_array($product['id'], $already_existing_product_ids);
                $handle_already_exists = $handle && $product['handle'] == $handle;
            }
            if( (!$handle_already_exists && !$id_already_exists) ){
                $new_products[] = [
                    'product_id'    =>  $product['id'],
                    'handle'        =>  $product['handle'],
                    'store_url'        =>  $this->store_settings->store_name,
                    'created_at'    =>  $now,
                    'updated_at'    =>  $now
                ];
            } else {
                //one of Handle or ID already exists in database
                //update handle or id in database
                if($id_already_exists){
                    $product_to_be_updated = ProductModel::where('product_id', $product['id'])->first();
                } elseif($handle_already_exists){
                    $product_to_be_updated = ProductModel::where('handle', $product['handle'])->first();
                }
                $product_to_be_updated->product_id = $product['id'];
                $product_to_be_updated->handle = $product['handle'];
                $product_to_be_updated->save();
            }

            //variants
            if( !empty($product['variants']) ){
                foreach( $product['variants'] as $variant ){
                    $new_variants[] = [
                        'variant_id'        =>  $variant['id'],
                        'product_id'        =>  $product['id'],
                        'sku'               =>  $variant['sku'],
                        'grams'             =>  $variant['grams'],
                        'inventory_qty'     =>  $variant['inventory_quantity'],
                        'weight'            =>  $variant['weight'],
                        'price'             =>  $variant['price'],
                        'compare_at_price'  =>  $variant['compare_at_price']
                    ];
                }
            }
        }

        if( !empty($new_products) )
            ProductModel::insert($new_products);
        if( !empty($new_variants) ){
            ProductVariantModel::insert($new_variants);
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
