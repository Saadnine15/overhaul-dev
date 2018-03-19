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

class Record extends Model{
    use SoftDeletes;
    protected $table = "record";
    protected $fillable = [
        'store_name',
    ];

}