<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable=[
        'customer_name',
        'customer_phone',
        'customer_email',
        'total_payment',
        'date'
    ];
}
