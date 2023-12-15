<?php

namespace App\Models;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'item_name',
        'brand',
        'color',
        'size',
        'qty_stock',
        'unit_id',
    ];

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function transactionItem()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // public function getTotalQuantity()
    // {
    //     return $this->transactions->sum('pivot.qty');
    // }
}
