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
}
