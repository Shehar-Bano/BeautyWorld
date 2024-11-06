<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable=[
        'id',
        'name',
    ];

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
