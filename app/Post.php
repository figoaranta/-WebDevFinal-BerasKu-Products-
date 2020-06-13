<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
		'userId',
    	'productId',
    	'postTitle',
    	'postDescription',
    	'price',
    	'countSold',
    	'sold',
    	'input',
    ];
}
