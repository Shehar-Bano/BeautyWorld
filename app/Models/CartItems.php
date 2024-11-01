<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    protected $fillable=[
        'service_id',
        'cart_id'
    ];
    public function service()
{
    return $this->belongsTo(Service::class, 'service_id');
}
}
