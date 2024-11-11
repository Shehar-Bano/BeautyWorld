<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
  public function order()
  {
    return $this->belongsTo(Orders::class,'order_id');
  }
  public function service()
  {
    return $this->belongsTo(Service::class, 'service_id');
  }
  public function user()
  {
    return $this->belongsTo(User::class, 'employee_id');
  }
}
