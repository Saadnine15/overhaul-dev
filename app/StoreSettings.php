<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 6/26/2016
 * Time: 2:19 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreSettings extends Model {

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_settings';
}