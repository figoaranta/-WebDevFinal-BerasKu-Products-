<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productImage extends Model
{
    public $table = 'ProductImages';
    protected $fillable = [
    	'productId',
    	'productImage'
    ];
}
