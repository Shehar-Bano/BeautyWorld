<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    protected $fillable=[
        'service_id',
        'cart_id',
        'deal_id'
    ];

    protected $guarded = [];
    public function service()
{
    return $this->belongsTo(Service::class, 'service_id');
}
public function deal()
{
    return $this->belongsTo(Deal::class);
}
}
