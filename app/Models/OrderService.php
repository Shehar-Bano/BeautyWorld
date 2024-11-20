<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderService extends Model
{
    use HasFactory;
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
  public function user()
  {
    return $this->belongsTo(User::class, 'employee_id');
  }
 public function deal()
  {
    return $this->belongsTo(Deal::class, 'deal_id');
  }
}
