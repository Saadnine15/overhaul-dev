<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 11/4/2016
 * Time: 12:39 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopifyBaseModel extends Model {


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';
}