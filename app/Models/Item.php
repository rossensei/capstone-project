<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'qty',
        'unit_id',
        'size',
        'expiry_date',
    ];

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function usages()
    {
        return $this->hasMany('App\Models\Usage');
    }

    // public function allocations()
    // {
    //     return $this->belongsToMany('App\Models\Allocation');
    // }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_item')
            ->withPivot(['qty', 'status', 'signature', 'date']);
    }
}
