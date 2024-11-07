<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $table = 'deals';
    protected $fillable = [
        'name',
        'description',
        'dis_price',
        'duration',
    ];
    public function dealService()
    {
        return $this->hasMany(DealService::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'deal_services', 'deal_id', 'service_id');
    }


}
