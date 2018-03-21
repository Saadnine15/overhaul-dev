<?php
/**
 * Created by PhpStorm.
 * User: saudslm
 * Date: 30/11/2016
 * Time: 11:31 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Update extends Model{
    use SoftDeletes;
    protected $fillable = [
        'old_qty',
        'new_qty',
        'old_price',
        'new_price',
        'old_compare_at_price',
        'new_compare_at_price'

    ];

}