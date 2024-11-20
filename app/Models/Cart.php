<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=[
       
        'seat_number'
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
