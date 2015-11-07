<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    $table = 'payment_detail';
    $fillable = ['bank', 'account_number', 'account_name', 'transaction_id'];
}
