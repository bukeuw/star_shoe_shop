<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
    	'name',
    	'description',
    	'stock',
    	'unit',
    	'price',
    	'img_name'
    ];

    /**
     * Get the categories that associated with given product.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
    	return $this->belongsToMany('App\Category', 'product_category');
    }
}
