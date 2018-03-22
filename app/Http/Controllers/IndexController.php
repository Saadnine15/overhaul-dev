<?php

namespace App\Http\Controllers;

use App\Jobs\Job;
use App\Record;
use App\ShopifyBaseModel;
use App\JobsFailed;
use App\Tracking;
use App\Update;
use Request;
use App\StoreSettings;
use App\BillingAPI;
use App\Orders;
use App\Product;
use App\Models\Product as ProductModel;
use App\Models\ProductVariant as ProductVariantModel;
use Log;
use saudslm\ShopifyAppHelper\ShopifyAppHepler;
use App\ShopifyApiThrottle;


class IndexController extends ShopifyAppInstallationBaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function oauth(){
        return $this->init();
    }

    public function installApp(){

        return $this->install();
    }



    public function admin(){
        $tracking= Tracking::where('store_name',session()->get('shop'))->orderby('created_at', 'desc')->first();

        if(isset($tracking[0])){
            return "job running";
        }
        $firstRecord=Record::where('store_name',session()->get('shop'))->orderby('created_at', 'desc')->first();
        return view('admin', [
            'shop' => session()->get('shop'),
            'api_key' => $this->app_settings->api_key
        ],compact('firstRecord'));
    }

    public function chargeTheStore(){
        /*$billing_api = new BillingAPI(session()->get('shop'), session()->get('oauth_access_token'));
        $the_charge = $billing_api->create_application_charge( secure_url('/activate_charge') );
        return view('redirect', ['url' => $the_charge['confirmation_url']]);*/
    }

    public function activeApplicationChargeForCurrentStore(){
        /*$charge_id = Request::input('charge_id');
        $billing_api = new BillingAPI(session()->get('shop'), session()->get('oauth_access_token'));
        $the_charge = $billing_api->get_application_charge( $charge_id );
        if ($the_charge['status'] == 'accepted'){
            session()->put('app_charge_active', true);
            $store_settings = StoreSettings::where('store_name', session()->get('shop'))->first();
            $store_settings->app_charge_id = $charge_id;
            $store_settings->save();
            $billing_api->activate_application_charge( $store_settings->app_charge_id );
        }else{
            //charge was not accepted
            //additionally you can add other functionality here for pending charges
            //and declined charges

        }
        return redirect('admin');*/
    }

    public function test(){
        return StoreSettings::withTrashed()->get();
    }

    public function __test(){
        //$store_settings = StoreSettings::where('store_name', 'test-shop-368.myshopify.com')->first();
        //Product::initStore('test-shop-368.myshopify.com', config('shopify.api_key'), $store_settings->access_token);
        //$webhook_content = Product::find(8520300749);

        /*$product = new ProductModel();
        $product->product_id = $webhook_content['id'];
        $product->handle = $webhook_content['handle'];
        $product->store_url = $store_settings->store_name;
        $product->save();

        // Variants
        $new_variants = [];
        if( !empty($webhook_content['variants']) ) {
            foreach( $webhook_content['variants'] as $variant ) {
                $new_variants[] = [
                    'variant_id'    =>  $variant['id'],
                    'product_id'    =>  $webhook_content['id'],
                    'sku'           =>  $variant['sku'],
                    'grams'           =>  $variant['grams'],
                    'inventory_qty'           =>  $variant['inventory_quantity'],
                    'weight'           =>  $variant['weight'],
                    'price'           =>  $variant['price'],
                    'compare_at_price'           =>  $variant['compare_at_price']
                ];
            }
            if( !empty($new_variants) ){
                ProductVariantModel::insert($new_variants);
            }
        }*/
        $product_id = 8520300749;//$webhook_content['id'];

        $product_ids = ProductModel::where('store_url', "test-shop-368.myshopify.com")->pluck('product_id', 'id')->toArray();
        //ProductModel::where('store_url', "test-shop-368.myshopify.com")->delete();
        if( !empty($product_ids) ){
            ProductVariantModel::whereIn('product_id', $product_ids)->delete();
        }
    }

    public function deleteStores($store_id, $soft){
        if( $soft != '' ){
            StoreSettings::find($store_id)->delete();
        } else {
            StoreSettings::find($store_id)->forceDelete();
        }
    }

    public function jobs(){
        return ShopifyBaseModel::all();
    }

    public function deleteAllJobs() {
        return ShopifyBaseModel::where('id', '>', 0)->delete();
    }

    public function productsdb(){
        //$result = ProductModel::where('store_url', 'test-shop-368.myshopify.com')->pluck('product_id', 'handle')->toArray();
        $result = ProductModel::all();
        return $result;
    }

    public function variantsdb(){
        $store_url = Request::get('store_url');
        $result = ProductModel::where('store_url', $store_url)->pluck('product_id', 'handle')->toArray();

        $return = ProductVariantModel::whereIn('product_id', $result)->get();
        return $return;
    }

    public function jobsFailed(){
        return JobsFailed::all();
    }

    private function _shopify_api($shop, $token){
        $shopify_app_helper = new ShopifyAppHepler($shop, config('shopify.api_key'));
        $shopify = $shopify_app_helper->client( $shop, $token, config('shopify.api_key') );
        return $shopify;
    }

    private function escapeJsonString($value) {
        //# list from www.json.org: (\b backspace, \f formfeed)
        $escapers = array("\\", "/", "\"", "\0", "\u", " ", "\n", "\r", "\t", "\x08", "\x0c", "u00a0", "rn");
        $replacements = array("\\\\", "\\/", "\\\"", " ", "", " ", "\\n", "\\r", "\\t", "\\f", "\\b", "", "\\r\\n");
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }

    public function getRecords(){
        return Job::all();
        return Record::where('id','>',0)->get();
    }
    public function checkJobStatus(){
        $data=Tracking::truncate();
        return $data;
        if($data){
            return "running";
        }else{
            return "empty";
        }

    }



    public function updates(){
        $store = session()->get('shop');
      $records= Record::where('store_name',$store)->orderBy('id','DESC')->get();

        return view('updates', [
            'shop' => session()->get('shop'),
            'api_key' => $this->app_settings->api_key
        ],compact('records'));
    }
}