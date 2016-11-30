<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 6/27/2016
 * Time: 11:19 AM
 */

namespace App\Http\Controllers;

use App\Jobs\ProductsUpdater;
use Request;
use App\Models\ProductVariant as ProductVariantModel;


class APIController extends ShopifyApiBaseController {

    public function postUpdateProductVariants(){

        $header_options = Request::input('header_options');
        $csv_data = Request::input('csv_content');

        $variant_sku_array = $this->getVariantsArrayFromCSVData($header_options, $csv_data);
        if($variant_sku_array){
            $product_variants = ProductVariantModel::whereIn('sku', $variant_sku_array)->get();
            $variants_array = [];
            foreach($product_variants as $variant){
                $variants_array[$variant->sku] = [
                    'variant_id'    =>      $variant->variant_id,
                    'product_id'    =>      $variant->product_id
                ];
            }

            $key_mapping_array = $this->getKeyMapping($header_options);

            $shopify_request_param_arr = [];
            foreach($csv_data as $key => $row){
                $arr = [];
                foreach ($key_mapping_array as $csv_key => $shopify_key){
                    if(isset($row[$csv_key])){
                        $arr[$shopify_key] = $row[$csv_key];
                        if($shopify_key == "sku"){
                            //if( isset($variants_array[$arr[$shopify_key]]) ){
                                $arr[$shopify_key] = ltrim($arr[$shopify_key], "'");
                                $arr["id"] = $variants_array[$arr[$shopify_key]]['variant_id'];
                            //}
                        }
                    }
                }
                $shopify_request_param_arr[] = $arr;
            }

            $store_settings = StoreSettings::where('store_name', session()->get('shop'))->first();
            $job = new ProductsUpdater($store_settings);
            $this->dispatch($job);

            return $shopify_request_param_arr;
        }
    }

    public function getVariantsArrayFromCSVData($header_options, $csv_data){
        $variant_sku_mapped_to = "";
        foreach($header_options as $option){
            if($option['key'] == 'variant_sku' && $option['mapped_to'] != ""){
                $variant_sku_mapped_to = $option['mapped_to'];
                break;
            }
        }
        if($variant_sku_mapped_to != "")
            return array_column($csv_data, $variant_sku_mapped_to);
        else
            return false;
    }

    public function getKeyMapping($header_options){
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