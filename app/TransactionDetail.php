<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
	$table = 'transaction_detail';

	$fillable = ['transaction_id', 'product_id', 'quantity'];

    public function transaction()
    {
    	return $this->belongsTo('App\Transaction');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
