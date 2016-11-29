<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 6/27/2016
 * Time: 11:08 AM
 */

namespace App\Http\Controllers;
use saudslm\ShopifyAppHelper\ShopifyAppHepler;

class ShopifyApiBaseController extends Controller {

    protected function _shopifyApi(){
        $store_name = session()->get('shop');
        $oauth_access_token = session()->get('oauth_access_token');
        $api_key = config('shopify.api_key');
        $shared_secret = config('shopify.app_secrete');

        $shopify_app_helper = new ShopifyAppHepler($store_name, $api_key);
        $shopify = $shopify_app_helper->client( $store_name, $oauth_access_token, $api_key );
        return $shopify;
    }

}