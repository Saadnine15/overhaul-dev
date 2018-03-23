<?php

namespace App\Providers;

use App\Tracking;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function ($event) {
            $command = unserialize($event->data['data']['command']);
//            $store_settings = $command->store_settings;
            var_dump($command);
            exit;
//            dd($event);
//            Tracking::create(['store_name',$event]);

//            Tracking::where('store_name',session()->get('shop'))->delete();

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
