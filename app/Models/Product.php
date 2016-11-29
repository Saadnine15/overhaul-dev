<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Product extends Model {

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';
}