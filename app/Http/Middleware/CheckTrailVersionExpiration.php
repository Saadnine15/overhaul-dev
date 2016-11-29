<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 10/19/2016
 * Time: 5:13 AM
 */

namespace App\Http\Middleware;

use Closure;
use App\StoreSettings;
use App\BillingAPI;

class CheckTrailVersionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $store_settings = StoreSettings::where('store_name', session()->get('shop'))->first();
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
            $billing_api = new BillingAPI();
            $the_charge = $billing_api->get_application_charge( $store_settings->app_charge_id );
            if ($the_charge['status'] == 'active'){
                session()->put('app_charge_active', true);
                $paid = true;
            }
        }

        session()->put('app_charge_active', $paid);
        session()->put('trail_period', $trail);

        if( $trail == false && $paid == false ) {
            return response()
                ->view('trail-ended',[
                    'shop' => session()->get('shop'),
                    'api_key' => config('shopify.api_key')
                ]);
        }
        return $next($request);
    }
}