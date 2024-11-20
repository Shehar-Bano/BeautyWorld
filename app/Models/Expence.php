<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expence extends Model
{
    use HasFactory;
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
