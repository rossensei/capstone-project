<?php

namespace App\Models;

use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'name',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
