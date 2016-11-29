<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 4/8/2016
 * Time: 5:30 PM
 */

namespace App\Http\Controllers;

use Request;
use saudslm\ShopifyAppHelper\ShopifyAppHepler;
use App\Orders;
use App\StoreSettings;

class ShopifyAppBaseController extends Controller{

    protected $shopify_app_helper;

    protected $store;

    protected $app_settings;

    public function __construct( $store_url = null ){

        if( !is_null($store_url) && !empty($store_url) ){
            $this->store = $store_url;
        } else{
            if( Request::input('shop') ) {
                $this->store = Request::input('shop');
            } else{
                $this->store = session()->get('shop');
            }
        }
        $this->app_settings = new \stdClass();

        $this->app_settings->api_key = config('shopify.api_key');
        $this->app_settings->shared_secret = config('shopify.app_secrete');
        $this->app_settings->permissions = config('shopify.scope');
        $this->app_settings->redirect_url = secure_url('install');

        $this->shopify_app_helper = new ShopifyAppHepler($this->store, $this->app_settings->api_key);
    }

    protected function _shopifyApi(){
        $store_name = $this->store;
        $oauth_access_token = session()->get('oauth_access_token');
        $shopify = $this->shopify_app_helper->client( $store_name, $oauth_access_token, $this->app_settings->api_key );
        return $shopify;
    }
}