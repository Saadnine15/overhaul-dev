<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class CheckShopSession
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
        if( session()->has('shop') && $request->input('shop') == session()->get('shop') && session()->has('oauth_access_token') ){
            //some action
        } else if( $request->has('shop') == true && $request->has('timestamp') == true && $request->has('hmac') == true  ){
            App::make('App\Http\Controllers\IndexController')->oauth();
        } else{
            //die('Un Authenticated Request!');
        }
        return $next($request);
    }
}
