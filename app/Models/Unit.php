<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_name',
        'abbreviation',
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
