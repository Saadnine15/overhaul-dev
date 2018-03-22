<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 6/27/2016
 * Time: 11:19 AM
 */

namespace App\Http\Controllers;

use App\Jobs\ProductsUpdater;
use App\Tracking;
use Request;
use App\StoreSettings;
use App\Models\ProductVariant as ProductVariantModel;


class APIController extends ShopifyApiBaseController {

    public function postUpdateProductVariants(){

        $header_options = Request::input('header_options');
        $csv_data = Request::input('csv_content');
        $store_settings = StoreSettings::where('store_name', session()->get('shop'))->first();

        /*$json_file_name = 'csv_data_' . $store_settings->id . '.json';
        $fp = fopen($json_file_name, 'w');
        fwrite($fp, json_encode([
            'csv_data' => $csv_data,
            'header_options' => $header_options
        ]));
        fclose($fp);*/

        //return Request::all();
        $json = json_encode([
            'csv_data' => $csv_data,
            'header_options' => $header_options
        ]);
        Tracking::create(['store_name'=>$store_settings['store_name']]);


        $job = new ProductsUpdater($store_settings, $json_file_name=null, $json);
        $this->dispatch($job);

    }

}