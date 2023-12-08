<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
