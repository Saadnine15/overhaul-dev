<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 6/27/2016
 * Time: 11:19 AM
 */

namespace App\Http\Controllers;
use App\Jobs\ProductsExportAndImport;
use Request;
use App\StoreSettings;
use App\Product;
use App\ShopifyApiThrottle;


class APIController extends ShopifyApiBaseController {


    public function postSaveChildStoreSettings(){
        $child_store = Request::all();
        $master_store = StoreSettings::where('store_name', session()->get('shop'))->first();
        $master_store->client_store_url = $child_store['Url'];
        $master_store->client_store_api_key = $child_store['ApiKey'];
        $master_store->client_store_password = $child_store['Password'];
        $master_store->save();
        return $master_store;
    }

    public function getChildStoreSettings(){
        $master_store = StoreSettings::where('store_name', session()->get('shop'))->first();
        return [
            'Url'       =>      $master_store->client_store_url,
            'ApiKey'       =>      $master_store->client_store_api_key,
            'Password'       =>      $master_store->client_store_password
        ];
    }

    public function postImportProducts(){
        $shop_settings = StoreSettings::where('store_name', session()->get('shop'))->first();
        $job = new ProductsExportAndImport($shop_settings, Request::all());
        $this->dispatch($job);

        /*Product::initStore(session()->get('shop'), config('shopify.api_key'), session()->get('oauth_access_token'));
        $p = Product::find(347558491);

        Product::initStore( $shop_settings->client_store_url, $shop_settings->client_store_api_key, $shop_settings->client_store_password, true);

        $wait = [];

        unset($p['id']);
        $DESC = $p['body_html'];
        $p['body_html'] = $this->clean_html_string($DESC);

        $x = Product::save($p);


        return ["p" => $x['body_html']];//['products' => $p['body_html'], 'p2' => $x];*/
    }

    private function _import($shop_settings){
        Product::initStore(session()->get('shop'), config('shopify.api_key'), session()->get('oauth_access_token'));
        $ps = Product::all();
        $y = [];
        Product::initStore( $shop_settings->client_store_url, $shop_settings->client_store_api_key, $shop_settings->client_store_password, true);
        ShopifyApiThrottle::init();
        $wait = [];
        foreach($ps as $index => $p){
            if( $index > 0 ){ $wait[$p['id']] = ShopifyApiThrottle::wait(); }
            $_p = Product::findByHandle($p['handle']);
            $y[$p['id']] = $_p;
            if($_p && is_array($_p) && count($_p)){

            } else{
                unset($p['id']);
                $DESC = $p['body_html'];
                $p['body_html'] = $this->clean_html_string($DESC);//addslashes(trim(preg_replace('/\s+/', ' ', $DESC)));

                $x = Product::save($p);
            }
            ShopifyApiThrottle::init();
        }
    }

    private function clean_html_string($string){
        //$string = preg_replace('/\s*$^\s*/m', " ", $string);
        //$string = preg_replace('/[ \t]+/', ' ', $string);
        //$string = preg_replace('/\s+/', ' ', $string);
        //$string = str_replace('<span class="Apple-converted-space"> </span>', '', $string);
        //$string = addslashes($string);
        //$string = iconv("UTF-8", "ISO-8859-2", $string);
        $string = $this->escapeJsonString(($string));
        return $string;
        //return trim($string, chr(0xC2).chr(0xA0));//utf8_encode($string);
    }

    function escapeJsonString($value) {
        //# list from www.json.org: (\b backspace, \f formfeed)
        $escapers = array("\\", "/", "\"", "\0", "\u", " ", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", " ", "", " ", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }


}