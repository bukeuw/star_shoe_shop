<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';

    protected $fillable = [
    	'full_name',
    	'address',
    	'province',
    	'city',
    	'postal_code',
    	'phone_number'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
