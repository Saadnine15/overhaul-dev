<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\StoreSettings;
use App\Variant;
use App\ShopifyApiThrottle;

class ProductsUpdater extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $store_settings;
    protected $variants_array;

    /**
     * ProductsExportAndImport constructor.
     *
     * Create a new job instance.
     *
     * @param StoreSettings $store_settings
     */
    public function __construct(StoreSettings $store_settings, $variants_array)
    {
        $this->store_settings = $store_settings;
        $this->variants_array = $variants_array;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateVariants();
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        // Called when the job is failing...
    }


    /**
     * Export All Products From Master Store
     *
     * @return array
     */
    private function updateVariants(){
        Variant::initStore($this->store_settings->store_name, config('shopify.api_key'), $this->store_settings->access_token);

        //to init start time
        ShopifyApiThrottle::init();
        $index = 1;
        foreach( $this->variants_array as $variant ){
            //wait for some time so it doesn't reach throttle point
            if( $index > 1 ){ ShopifyApiThrottle::wait(); }

            if(isset($variant['id']) && isset($variant['sku']) && !empty($variant['sku']) && !empty($variant['id'])){

                $variant_id = $variant["id"];
                unset($variant["id"]);
                unset($variant["sku"]);

                Variant::save($variant, "/admin/variants/" . $variant_id . ".json");

            }
            //to re-init start time
            ShopifyApiThrottle::init();
            $index++;
        }
    }
}
