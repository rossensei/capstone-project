<?php

namespace App\Models;

use App\Models\Personnel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_name',
        'date_added',
    ];

    public function personnels()
    {
        return $this->hasMany(Personnel::class);
    }
}
