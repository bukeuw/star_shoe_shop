<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment_detail';
    protected $fillable = ['bank', 'account_number', 'account_name', 'transaction_id'];
}
