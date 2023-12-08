<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
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

    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot('qty');
    }
}
