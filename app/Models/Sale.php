<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'date_sold',
        'qty',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
