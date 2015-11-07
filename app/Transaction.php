<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	$fillable = ['user_id', 'payment_method', 'total_pay', 'confirmed'];
	$dates = ['created_at'];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

    public function details()
    {
    	return $this->hasMany('App\TransactionDetail');
    }
}
