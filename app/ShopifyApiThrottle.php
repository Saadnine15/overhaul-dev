<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 11/5/2016
 * Time: 2:36 AM
 */

namespace App;


class ShopifyApiThrottle
{

    public static $cycle = 0.5;
    public static $start_time;      //date time
    public static $start_time_ms;       //microseconds
    public static $stop_time;       //date time
    public static $stop_time_ms;    //microseconds

    public static function init(){
        self::$start_time = \Carbon\Carbon::now();
        self::$start_time_ms = substr(microtime(), 1, 8);
    }

    public static function wait(){
        $wait_secs = 0;
        self::$stop_time = \Carbon\Carbon::now();
        self::$stop_time_ms = substr(microtime(), 1, 8);
        $difference_in_secs = self::$stop_time->diffInSeconds(self::$start_time);
        $difference_in_msecs = self::$stop_time_ms - self::$start_time_ms;
        $processing_time = (float) ($difference_in_secs . "." . $difference_in_msecs);

        $time_to_wait = (self::$cycle - $processing_time);
        if( $time_to_wait > 0 ){
            usleep( ceil(1000000*$time_to_wait) );
            $wait_secs = $time_to_wait;
        }
        return $wait_secs;
    }
}