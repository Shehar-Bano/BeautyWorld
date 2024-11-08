<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{

    protected $fillable = [
        'order_id',
        'service_id',
        'employee_id'
       
    ];

  public function order()
  {
    return $this->belongsTo(Orders::class,'order_id');
  }
  public function service()
{
    return $this->belongsTo(Service::class, 'service_id');
}

public function deal()
{
    return $this->belongsTo(Deal::class, 'deal_id');
}


}
