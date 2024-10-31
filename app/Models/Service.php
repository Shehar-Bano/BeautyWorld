<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable=[
        'name' ,
            'description',
            'image', // Validate image type and size
            'price' , // Validate price as numeric and not negative
            'duration' , // Validate time format
            'status',
            'category_id'
    ];
    public function deal()
    {
        return $this->hasMany(Deal::class);
    }
    public function dealService()
    {
        return $this->hasMany(DealService::class, 'deal_service_id');
    }
}
