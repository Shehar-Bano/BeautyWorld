<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
    protected $fillable=[
            'name' ,
            'description',
            'price' , // Validate price as numeric and not negative
            'category_id'
    ];
    public function expenceCategory()
    {
        return $this->belongsTo(ExpenceCategory::class, 'category_id');
    }

}
