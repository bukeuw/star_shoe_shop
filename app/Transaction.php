<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $fillable = ['user_id', 'payment_method', 'total_pay', 'confirmed'];
	protected $dates = ['created_at'];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

    public function details()
    {
    	return $this->hasMany('App\TransactionDetail');
    }
}
