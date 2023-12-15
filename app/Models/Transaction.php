<?php

namespace App\Models;

use App\Models\Personnel;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'personnel_id',
        'date_time',
        'remarks',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
