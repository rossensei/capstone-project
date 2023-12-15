<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'transaction_id',
        'qty',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
