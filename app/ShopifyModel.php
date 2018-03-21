<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 10/26/2016
 * Time: 4:29 AM
 */

namespace App;

use saudslm\ShopifyAppHelper\ShopifyAppHepler;
use Log;

class ShopifyModel
{

    protected static $shop;
    protected static $api_key;
    protected static $access_token;
    protected static $private_app;

    /**
     * The shopify entity associated with the model.
     *
     * @var string
     */
    protected $shopify_entity;

    /**
     * The shopify entity associated with the model.
     *
     * @var string
     */
    private static $shopify_entity_to_uri_mapping = [
        "product"   =>      "/admin/products/#{id}.json",
        "variant"   =>      ""
    ];

    public function __construct($shop = '', $access_token = '')
    {
        //static::$shop = $shop;
        //static::$access_token = $access_token;
    }

    public static function initStore($shop, $api_key, $access_token, $private_app = false){
        static::$shop = $shop;
        static::$api_key = $api_key;
        static::$access_token = $access_token;
        static::$private_app = $private_app;
    }

    protected static function _shopifyApi(){
        $store_name = static::$shop;
        $oauth_access_token = static::$access_token;
        $api_key = static::$api_key;

        $shopify_app_helper = new ShopifyAppHepler($store_name, $api_key);
        $shopify = $shopify_app_helper->client( $store_name, $oauth_access_token, $api_key, static::$private_app );
        return $shopify;
    }

    protected static function get($uri, $params = []){
        return self::http_request($uri, $params);
    }

    protected static function post($uri, $params = []){
        return self::http_request($uri, $params, "POST");
    }

    protected static function put($uri, $params = []){
        return self::http_request($uri, $params, "PUT");
    }

    protected static function delete($uri){
        return self::http_request($uri, [], "DELETE");
    }

    private static function http_request($uri, $params = [], $http_verb = "GET"){
        $shopify_api = self::_shopifyApi();

        try{
            return $shopify_api($http_verb, $uri, $params);
        } catch (\Exception $e){
            Log::error("HTTP REQUEST ERROR:: uri: $uri, $http_verb", $params);
            return false;
        }
    }

    private static function get_uri( $entity_id = "" ){
        $instance = new static;
        if( is_null($entity_id) || empty($entity_id) ){
            return str_replace("/#{id}", "", self::$shopify_entity_to_uri_mapping[$instance->shopify_entity]);
        }
        return str_replace("#{id}", $entity_id, self::$shopify_entity_to_uri_mapping[$instance->shopify_entity]);
    }

    /* ----------------------------------------------------------------------------------------
    |
    |   CRUD OPERATIONS
    |
    | ----------------------------------------------------------------------------------------- */

    public static function all( $params = [] ){
        $uri = self::get_uri();
        return self::get($uri, $params);
    }

    public static function find( $entity_id, $params = [] ){
        $uri = self::get_uri($entity_id);
        return self::get($uri, $params);
    }

    public static function findByHandle( $handle, $params = [] ){
        $params['handle'] = $handle;
        $products = static::all($params);
        if( $products && !empty( $products ) && is_array($products) ){
            return $products[0];
        }
        return false;
    }
    public static function getVariant( $entity_id, $params = [] ){
        $uri = "/variant.json?id=".$entity_id;
        return self::get($uri, $params);
    }

    public static function count( $params = [] ){
        $uri = self::get_uri();
        $count_uri = str_replace(".json", "/count.json", $uri);
        return self::get($count_uri, $params);
    }

    public static function save( $params = [], $request_uri = "" ){
        $entity = [];
        $instance = new static;
        $entity_name = $instance->shopify_entity;
        if( isset($params[$entity_name]) ){
            $params = $params[$entity_name];
        }

        if( isset($params['id']) && !empty($params['id']) ){
            $uri = $request_uri != "" ? $request_uri : self::get_uri($params['id']);
            $entity = self::put($uri, [$entity_name => $params]);

        } else{
            $uri = $request_uri != "" ? $request_uri : self::get_uri();
            $entity = self::post($uri, [$entity_name => $params]);
        }
        return $entity;
    }

    public static function remove( $entity_id ){
        $uri = self::get_uri($entity_id);
        return self::delete($uri, []);
    }
}