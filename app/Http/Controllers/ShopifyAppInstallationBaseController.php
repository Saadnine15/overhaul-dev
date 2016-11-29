<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 9/20/2016
 * Time: 10:19 PM
 */

namespace App\Http\Controllers;

use Request;
//Models
use App\StoreSettings;
use App\BillingAPI;
use App\Orders;

class ShopifyAppInstallationBaseController extends ShopifyAppBaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function init(){
        $store_settings = StoreSettings::where('store_name', $this->store)->first();
        if( $store_settings ){
            if($this->shopify_app_helper->isValidRequest(Request::all(), $this->app_settings->shared_secret)){ //check if its a valid request from Shopify
                //save the signature and shop name to the current session
                return $this->_initStoreSession($store_settings);
            } else {
                echo "not a valid request"; die();
            }
        } else{
            $url = $this->_getAppPermissionsUrl();
            return view('redirect', ['url' => $url]);
        }
    }

    public function install(){
        return $this->_addNewStoreSettings();
    }

    private function _getAppPermissionsUrl(){

        //convert the permissions to an array
        $permissions = $this->app_settings->permissions;

        //get the permission url
        $permission_url = $this->shopify_app_helper->permissionUrl(
            $this->store, $this->app_settings->api_key, $permissions
        );
        $permission_url .= '&redirect_uri=' . $this->app_settings->redirect_url ;

        return $permission_url;
    }

    private function _addNewStoreSettings(){

        //get permanent access token
        $access_token = $this->shopify_app_helper->oauthAccessToken(
            $this->store, $this->app_settings->api_key, $this->app_settings->shared_secret, Request::input('code')
        );

        $store_instance = null;
        $store = StoreSettings::withTrashed()->where('store_name', $this->store)->first();
        if( $store ){
            $store->restore();
            $store->access_token = $access_token;
            $store->app_charge_id = "";
            $store->save();
            $store_instance = $store;
        } else{
            //save the shop details to the database
            $new_store = new StoreSettings();
            $new_store->access_token = $access_token;
            $new_store->store_name = $this->store;
            $new_store->save();
            $store_instance = $new_store;
        }

        //save the signature and shop name to the current session
        $response = $this->_initStoreSession($store_instance);

        return $response;
    }

    /**
     * save the signature and shop name to the current session
     *
     */
    private function _initStoreSession($store){
        //session()->put('shopify_signature', Request::input('signature'));
        session()->put('oauth_access_token', $store->access_token);
        session()->put('shop', $store->store_name);

        //echo session()->get('shop') . " --------------"; die();
        return view('redirect', ['url' => secure_url('/admin')]);
    }

    protected function checkTrailVersionAndAppChargeState(){
        $store_settings = StoreSettings::where('store_name', $this->store)->first();
        $trail_ends_on = \Carbon\Carbon::parse( $store_settings->created_at )->addDays( config('shopify.trial_days') );
        $current_date = \Carbon\Carbon::now();

        $trail = false;
        $paid = false;
        //is trial version still applicable
        if( $trail_ends_on->gte( $current_date ) ) {
            session()->put('trail_period', true);
            $trail = true;
        }

        //is application charge active
        if( !empty($store_settings->app_charge_id) && !is_null($store_settings->app_charge_id) ){
            $billing_api = new BillingAPI($this->store, session()->get('oauth_access_token'));
            $the_charge = $billing_api->get_application_charge( $store_settings->app_charge_id );
            if ($the_charge['status'] == 'active'){
                session()->put('app_charge_active', true);
                $paid = true;
            }
        }

        session()->put('app_charge_active', $paid);
        session()->put('trail_period', $trail);
        return $trail || $paid;
    }

}