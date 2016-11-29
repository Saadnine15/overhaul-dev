<?php
/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 11/5/2016
 * Time: 8:54 AM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class JobsFailed extends Model {


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'failed_jobs';
}