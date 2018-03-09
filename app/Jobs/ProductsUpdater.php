<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\StoreSettings;
use App\Variant;
use App\ShopifyApiThrottle;
use App\Models\ProductVariant as ProductVariantModel;

class ProductsUpdater extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $store_settings;
    protected $variants_array;
    protected $variant_sku_array;
    protected $csv_data;
    protected $key_mapping_array;
    protected $header_options;
    protected $json_file_name;

    /**
     * ProductsExportAndImport constructor.
     *
     * Create a new job instance.
     *
     * @param StoreSettings $store_settings
     * @param $json_file_name
     * @param $header_options
     */
    public function __construct(StoreSettings $store_settings, $json_file_name)
    {
        $this->store_settings = $store_settings;
        $this->json_file_name = $json_file_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $json_file_data = json_decode(file_get_contents($this->json_file_name), true);
        $this->csv_data = $json_file_data['csv_data'];
        $this->header_options = $json_file_data['header_options'];
        $this->getVariantsArrayFromArray();
        $this->updateVariants();
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
    private function updateVariants(){
        Variant::initStore($this->store_settings->store_name, config('shopify.api_key'), $this->store_settings->access_token);

        //to init start time
        ShopifyApiThrottle::init();
        $index = 1;
        foreach( $this->variants_array as $variant ){
            //wait for some time so it doesn't reach throttle point
            if( $index > 1 ){ ShopifyApiThrottle::wait(); }

            if(isset($variant['id']) && isset($variant['sku']) && !empty($variant['sku']) && !empty($variant['id'])){

                $variant_id = $variant["id"];
                //unset($variant["id"]);
                unset($variant["sku"]);

                Variant::save($variant, "/admin/variants/" . $variant_id . ".json");

            }
            //to re-init start time
            ShopifyApiThrottle::init();
            $index++;
        }
    }


    private function getVariantsArrayFromArray() {

        $variant_sku_array = $this->getVariantsArrayFromCSVData($this->header_options, $this->csv_data);
        if($variant_sku_array) {
            $variant_sku_array = array_filter($variant_sku_array);
            $key_mapping_array = $this->getKeyMapping($this->header_options);

            $product_variants = ProductVariantModel::whereIn('sku', $variant_sku_array)->get();

            $variants_array = [];
            foreach($product_variants as $variant){
                $variants_array[$variant->sku] = [
                    'variant_id'    =>      $variant->variant_id,
                    'product_id'    =>      $variant->product_id
                ];
            }

            //return $variants_array;

            $shopify_request_param_arr = [];
            foreach($this->csv_data as $key => $row){
                $arr = [];
                foreach ($key_mapping_array as $csv_key => $shopify_key){
                    if(isset($row[$csv_key]) && !empty($row[$csv_key])){
                        $arr[$shopify_key] = $row[$csv_key];
                        if($shopify_key == "sku"){
                            $arr[$shopify_key] = ltrim($arr[$shopify_key], "'");
                            if( isset($variants_array[$arr[$shopify_key]]) ){
                                $arr["id"] = $variants_array[$arr[$shopify_key]]['variant_id'];
                            }
                        }
                    }
                }
                if( !empty($arr) )
                    $shopify_request_param_arr[] = $arr;
            }
            $this->variants_array = $shopify_request_param_arr;
        }
    }

    private function getVariantsArrayFromCSVData($header_options, $csv_data){
        $variant_sku_mapped_to = "";
        foreach($header_options as $option){
            if($option['key'] == 'variant_sku' && $option['mapped_to'] != ""){
                $variant_sku_mapped_to = $option['mapped_to'];
                break;
            }
        }
        if($variant_sku_mapped_to != ""){
            $variant_array = array_column($csv_data, $variant_sku_mapped_to);
            return array_map(function($val) { return ltrim($val, "'"); }, $variant_array);
        } else{
            return false;
        }
    }

    private function getKeyMapping($header_options){
        $mapping = [];
        foreach($header_options as $option){
            $key = "";
            if($option['mapped_to'] != ""){
                switch($option['key']){
                    case 'variant_sku':
                        $key = "sku";
                        break;
                    case 'variant_price':
                        $key = "price";
                        break;
                    case 'variant_compare_at_price':
                        $key = "compare_at_price";
                        break;
                    case 'variant_inventory_qty':
                        $key = 'inventory_quantity';
                        break;
                }
                $mapping[$option['mapped_to']] = $key;
            }
        }
        return $mapping;
    }
}
