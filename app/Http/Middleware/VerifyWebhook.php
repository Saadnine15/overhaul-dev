<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 9/20/2016
 * Time: 9:56 PM
 */

namespace App\Http\Middleware;

use Closure;

class VerifyWebhook
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
        $hmac_header = $request->header('X-Shopify-Hmac-Sha256');
        $webhook_data = $this->_readWebhook();
        $app_shared_secret = config('shopify.app_secrete');
        $calculated_hmac = base64_encode(hash_hmac('sha256', $webhook_data, $app_shared_secret, true));
        if ($hmac_header == $calculated_hmac) {
            $request->merge( ['webhook_data' => json_decode($webhook_data, true)] );
            return $next($request);
        } else{
            die('HMAC not varified!');
        }
    }

    private function _readWebhook(){
        $webhookContent = "";

        $webhook = fopen('php://input' , 'rb');
        while (!feof($webhook)) {
            $webhookContent .= fread($webhook, 4096);
        }
        fclose($webhook);
        return $webhookContent;
    }
}