<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    protected $fillable=[
        'customer_name',
        'customer_phone',
        'customer_email',
        'total_payment',
        'date'
    ];
    public function orderService()
    {
        return $this->hasMany(OrderService::class,'order_id');
    }
}
