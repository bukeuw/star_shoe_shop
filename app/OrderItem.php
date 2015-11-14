<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
	protected $table = 'order_items';
	protected $fillable = ['order_id', 'product_id', 'qty', 'confirmed'];

	public function order()
	{
		return $this->belongsTo('App\Order');
	}

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
