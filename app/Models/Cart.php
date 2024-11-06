<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=[
       
        'seat_number'
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
