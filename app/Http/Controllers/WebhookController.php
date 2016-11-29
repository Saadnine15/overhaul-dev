<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 9/20/2016
 * Time: 10:12 PM
 */

namespace App\Http\Controllers;

use App\StoreSettings;
use App\BillingAPI;
use App\Orders;
use Request;
use App\Models\Product as ProductModel;


class WebhookController extends ShopifyAppBaseController{

    public function __construct(){
        $shop_name = Request::header('X-Shopify-Shop-Domain');
        if( !session()->has('oauth_access_token') ){
            $store_settings = StoreSettings::withTrashed()->where('store_name', $shop_name)->first();
            if($store_settings){
                session()->put('oauth_access_token', $store_settings->access_token);
            }
        }
        parent::__construct( $shop_name );
    }

    public function postAddedNewProduct(){
        $webhook_content = Request::input('webhook_data');

        $product = new ProductModel();
        $product->product_id = $webhook_content['id'];
        $product->handle = $webhook_content['handle'];
    }

    public function postAddedNewCustomer(){
        /*$webhook_content = Request::input('webhook_data');

        $customer_id = $webhook_content['id'];
        $customer_email = $webhook_content['email'];
        $total_spent = $webhook_content['total_spent'];
        $customer_tags = $webhook_content['tags'];

        $store = StoreSettings::where('store_name', $this->store)->first();
        $store->webhook = "1- New Customer#" . $customer_id;
        $store->save();

        //$this->createCustomerSpendingsMetafield($customer_id, $total_spent);
        $this->updateCustomerTag($customer_id, $total_spent, $customer_tags);*/

    }

    public function postAddedNewOrder(){
        /*$webhook_content = Request::input('webhook_data');
        $customer_id = $webhook_content['customer']['id'];
        $customer_email = $webhook_content['customer']['email'];
        $customer_tags = $webhook_content['customer']['tags'];

        $store = StoreSettings::where('store_name', $this->store)->first();
        $store->webhook = "1- Order # " . $webhook_content['id'];
        $store->save();

        $this->updateCustomerLevelTags($customer_id, $customer_email, $customer_tags);*/
    }





    public function appUninstall(){
        $store = StoreSettings::where('store_name', $this->store)->first();

        /*
        //Remove Webhooks
        $webhook_content = Request::input('webhook_data');
        $webhook_id = $webhook_content['id'];
        $shopify = $this->_shopifyApi();
        $w = $shopify('DELETE', '/admin/webhooks/' . $webhook_id . '.json'); */

        //Delete store info from database(soft delete)
        if( $store ){
            /*if( $store->app_charge_id && !empty($store->app_charge_id) ){
                $billing_api = new BillingAPI();
                $billing_api->cancel_application_charge( $store->app_charge_id );
                $store->app_charge_id = "";
                $store->save();
            }*/

            $store->delete();
            session()->flush();
        }
    }
}