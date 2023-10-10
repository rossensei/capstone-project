<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'tag_no',
        'serial_no',
        'item_name',
        'description',
        'condition',
        'remarks',
        'date_acquired',
    ];

    public function facility()
    {
        return $this->belongsTo('App\Models\Facility');
    }
}
