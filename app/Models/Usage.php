<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'used_at',
        'quantity_used',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
