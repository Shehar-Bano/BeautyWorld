<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'name',
    ];

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
