<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 6/27/2016
 * Time: 11:19 AM
 */

namespace App\Http\Controllers;
use Request;
use App\Models\ProductVariant as ProductVariantModel;


class APIController extends ShopifyApiBaseController {

    public function updateProducts(){

        $variant_sku = "";
        $variant = ProductVariantModel::where('sku', $variant_sku)->first();
        $variant->product_id;
        $variant->variant_id;
    }

}