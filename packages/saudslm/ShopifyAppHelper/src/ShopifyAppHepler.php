<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 4/8/2016
 * Time: 3:51 PM
 */

namespace saudslm\ShopifyAppHelper;


class ShopifyAppHepler
{
    private $shop;

    private $api_key;

    private $shared_secrete;

    public function __construct($shop, $api_key){
        $this->shop = $shop;
        $this->api_key = $api_key;
    }

    /**
     * This method will return app installation url
     *
     * @param $shop
     * @param $api_key
     * @return string
     */
    public function installUrl($shop, $api_key) {
        return "http://$shop/admin/api/auth?api_key=$api_key";
    }

    /**
     * This method will check is the request is older than a day to check the validity
     *
     * @param $query_params
     * @param $shared_secret
     * @return bool
     */
    public function isValidRequest($query_params, $shared_secret) {
        $seconds_in_a_day = 24 * 60 * 60;
        $older_than_a_day = $query_params['timestamp'] < (time() - $seconds_in_a_day);
        if ($older_than_a_day) return false;

        return $this->isHmacValid($query_params, $shared_secret);
    }

    private function isHmacValid($query_params, $shared_secret){
        //hash( 'sha256', $string );
        //$signature = $query_params['signature'];
        $hmac = $query_params['hmac'];
        //unset($query_params['signature']);
        unset($query_params['hmac']);
        foreach ($query_params as $key=>$val) $params[] = "$key=$val";

        return (hash_hmac('sha256', implode('&', $params), $shared_secret) === $hmac);
    }

    /**
     * This method will be used when the app is being installed for the first time to get certain permissions for the app
     *
     * @param $shop
     * @param $api_key
     * @param array $scope
     * @param string $redirect_uri
     * @return string
     */
    public function permissionUrl($shop, $api_key, $scope=array(), $redirect_uri='') {
        $scope = empty($scope) ? '' : '&scope='.implode(',', $scope);
        $redirect_uri = empty($redirect_uri) ? '' : '&redirect_uri='.urlencode($redirect_uri);
        return "https://$shop/admin/oauth/authorize?client_id=$api_key$scope$redirect_uri";
    }

    /**
     * This method will return access_token
     *
     * @param $shop
     * @param $api_key
     * @param $shared_secret
     * @param $code
     * @return mixed
     */
    public function oauthAccessToken($shop, $api_key, $shared_secret, $code) {
        return $this->_api('POST', "https://$shop/admin/oauth/access_token", NULL, array('client_id'=>$api_key, 'client_secret'=>$shared_secret, 'code'=>$code));
    }

    /**
     * @param $shop
     * @param $shops_token
     * @param $api_key
     * @param $shared_secret
     * @param bool $private_app
     * @return \Closure
     */
    public function client($shop, $shops_token, $api_key, $private_app=false)
    {
        $password = $shops_token;
        $baseurl = $private_app ? $this->_private_app_base_url($shop, $api_key, $password) : "https://$shop/";
        return function ($method, $path, $params=array(), &$response_headers=array()) use ($baseurl, $shops_token)
        {
            $url = $baseurl.ltrim($path, '/');
            $query = in_array($method, array('GET','DELETE')) ? $params : array();
            $payload = in_array($method, array('POST','PUT')) ? stripslashes(json_encode($params)) : array();
            $request_headers = array();
            array_push($request_headers, "X-Shopify-Access-Token: $shops_token");
            if (in_array($method, array('POST','PUT'))) array_push($request_headers, "Content-Type: application/json; charset=utf-8");
            return $this->_api($method, $url, $query, $payload, $request_headers, $response_headers);
        };
    }

    /**
     * @param $shop
     * @param $api_key
     * @param $password
     * @return string
     */
    private function _private_app_base_url($shop, $api_key, $password) {
        return "https://$api_key:$password@$shop/";
    }

    /**
     * @param $method
     * @param $url
     * @param string $query
     * @param string $payload
     * @param array $request_headers
     * @param array $response_headers
     * @return array|mixed
     * @throws ApiException
     * @throws CurlException
     */
    private function _api($method, $url, $query='', $payload='', $request_headers=array(), &$response_headers=array()) {
        try
        {
            $response = $this->wcurl($method, $url, $query, $payload, $request_headers, $response_headers);
        }
        catch(WcurlException $e)
        {
            throw new CurlException($e->getMessage(), $e->getCode());
        }
        $response = json_decode($response, true);
        if (isset($response['errors']) or ($response_headers['http_status_code'] >= 400)) {
            $errors = isset($response['errors']) ? $response['errors'] : "Unexpected Error";
            throw new ApiException($errors, $response_headers['http_status_code'], $url);
        }
            //throw new ApiException(compact('method', 'path', 'params', 'response_headers', 'response', 'shops_myshopify_domain', 'shops_token'));
        return (is_array($response) and !empty($response)) ? array_shift($response) : $response;
    }

    /**
     * @param $response_headers
     * @return mixed
     */
    public function callsMade($response_headers) {
        return $this->_shop_api_call_limit_param(0, $response_headers);
    }

    /**
     * @param $response_headers
     * @return mixed
     */
    public function callLimit($response_headers) {
        return $this->_shop_api_call_limit_param(1, $response_headers);
    }

    /**
     * @param $response_headers
     * @return mixed
     */
    public function callsLeft($response_headers) {
        return $this->callLimit($response_headers) - $this->callsMade($response_headers);
    }

    /**
     * @param $index
     * @param $response_headers
     * @return int
     */
    private function _shop_api_call_limit_param($index, $response_headers) {
        $params = explode('/', $response_headers['http_x_shopify_shop_api_call_limit']);
        return (int) $params[$index];
    }

    /**
     * @param $shops_token
     * @param $shared_secret
     * @param bool $private_app
     * @return string
     */
    private function legacyTokenToOauthToken($shops_token, $shared_secret, $private_app=false) {
        return $private_app ? $shared_secret : md5($shared_secret.$shops_token);
    }

    /**
     * @param $shop
     * @param $api_key
     * @param $password
     * @return string
     */
    public function legacyBaseurl($shop, $api_key, $password) {
        return "https://$api_key:$password@$shop/";
    }


    /************************ CURL **************************************/
    function wcurl($method, $url, $query='', $payload='', $request_headers=array(), &$response_headers=array(), $curl_opts=array())
    {
        $ch = curl_init( $this->wcurl_request_uri($url, $query) );
        $this->wcurl_setopts($ch, $method, $payload, $request_headers, $curl_opts);
        $response = curl_exec($ch);
        $curl_info = curl_getinfo($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($errno) die($errno . "- " . $error);
        $header_size = $curl_info["header_size"];
        $msg_header = substr($response, 0, $header_size);
        $msg_body = substr($response, $header_size);
        $response_headers = $this->wcurl_response_headers($msg_header);
        return $msg_body;
    }
    function wcurl_request_uri($url, $query)
    {
        if (empty($query)) return $url;
        if (is_array($query)) return "$url?".http_build_query($query);
        else return "$url?$query";
    }
    function wcurl_setopts($ch, $method, $payload, $request_headers, $curl_opts)
    {
        $default_curl_opts = array
        (
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_USERAGENT => 'wcurl',
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT => 30,
        );
        if ('GET' == $method)
        {
            $default_curl_opts[CURLOPT_HTTPGET] = true;
        }
        else
        {
            $default_curl_opts[CURLOPT_CUSTOMREQUEST] = $method;
            // Disable cURL's default 100-continue expectation
            if ('POST' == $method) array_push($request_headers, 'Expect:');
            if (!empty($payload))
            {
                if (is_array($payload))
                {
                    $payload = http_build_query($payload);
                    array_push($request_headers, 'Content-Type: application/x-www-form-urlencoded; charset=utf-8');
                }
                $default_curl_opts[CURLOPT_POSTFIELDS] = $payload;
            }
        }
        if (!empty($request_headers)) $default_curl_opts[CURLOPT_HTTPHEADER] = $request_headers;
        $overriden_opts = $curl_opts + $default_curl_opts;
        foreach ($overriden_opts as $curl_opt=>$value) curl_setopt($ch, $curl_opt, $value);
    }
    function wcurl_response_headers($msg_header)
    {
        $multiple_headers = preg_split("/\r\n\r\n|\n\n|\r\r/", trim($msg_header));
        $last_response_header_lines = array_pop($multiple_headers);
        $response_headers = array();
        $header_lines = preg_split("/\r\n|\n|\r/", $last_response_header_lines);
        list(, $response_headers['http_status_code'], $response_headers['http_status_message']) = explode(' ', trim(array_shift($header_lines)), 3);
        foreach ($header_lines as $header_line)
        {
            list($name, $value) = explode(':', $header_line, 2);
            $response_headers[strtolower($name)] = trim($value);
        }
        return $response_headers;
    }
}

class CurlException extends \Exception {
    function __construct($message, $code){

    }
}
class ApiException extends \Exception
{
    //throw new ApiException(compact('method', 'path', 'params', 'response_headers', 'response', 'shops_myshopify_domain', 'shops_token'));
    function __construct($message, $code, $request, $response=array(), Exception $previous=null)
    {
        /*$response_body_json = isset($response['body']) ? $response['body'] : '';
        $response = json_decode($response_body_json, true);
        $response_error = isset($response['errors']) ? ' '.var_export($response['errors'], true) : '';
        $this->message = $message.$response_error;*/
        //parent::__construct($this->message, $code, $request, $response, $previous);
    }
}