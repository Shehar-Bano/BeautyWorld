<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenceCategory extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
    ];
    public function expences()
    {
        return $this->hasMany(Expence::class);
    }
}
