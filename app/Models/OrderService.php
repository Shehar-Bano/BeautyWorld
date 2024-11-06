<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
  public function order()
  {
    return $this->belongsTo(Orders::class,'order_id');
  }
}
