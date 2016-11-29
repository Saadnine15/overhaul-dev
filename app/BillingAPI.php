<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 10/15/2016
 * Time: 4:12 AM
 */

namespace App;


class BillingAPI extends ShopifyModel{

    public function __construct($shop, $access_token) {
        parent::__construct($shop, $access_token);
    }

    /**
     * Create a new application recharge
     * @param $redirect_url
     */
    public function create_application_charge($redirect_url){
        $uri = '/admin/recurring_application_charges.json';
        $params = [
            "recurring_application_charge" => [
                "name" => "Extra Fields Monthly Charge",
                "price" => config('shopify.price'),
                "return_url" => $redirect_url,
                "terms" => "$" . config('shopify.price') .  " per month",
                "test"  => 'true'
            ]
        ];
        $shopify_api = $this->_shopifyApi();
        $the_charge = $shopify_api('POST', $uri, $params);
        return $the_charge;
    }

    /**
     * Activate a successfully created application charge
     * @param $charge_id
     * @return mixed
     */
    public function activate_application_charge($charge_id){
        $uri = "/admin/recurring_application_charges/" . $charge_id . "/activate.json";
        $shopify_api = $this->_shopifyApi();
        $the_charge = $shopify_api('POST', $uri, []);
        return $the_charge;
    }

    /**
     * Get application charge by charge id
     * @param $charge_id
     * @return mixed
     */
    public function get_application_charge($charge_id){
        $uri = "/admin/recurring_application_charges/" . $charge_id . ".json";
        $shopify_api = $this->_shopifyApi();
        $the_charge = $shopify_api('GET', $uri, []);
        return $the_charge;
    }

    /**
     * Cancel and application charge
     * @param $charge_id
     */
    public function cancel_application_charge($charge_id){
        $uri = "/admin/recurring_application_charges/" . $charge_id . ".json";
        $shopify_api = $this->_shopifyApi();
        $shopify_api('DELETE', $uri, []);
    }
}