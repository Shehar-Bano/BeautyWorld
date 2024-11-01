<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealService extends Model
{
    protected $table = 'deal_services';
    protected $fillable = ['deal_id', 'service_id'];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
