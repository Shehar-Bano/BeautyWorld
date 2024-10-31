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
        'type',
        'duration',
    ];
    public function dealService()
    {
        return $this->hasMany(DealService::class);
    }

}
