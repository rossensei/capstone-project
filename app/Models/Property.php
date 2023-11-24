<?php

namespace App\Models;

use DB;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $casts = [
        'date_acquired' => 'date',
    ];

    protected $fillable = [
        'department_id',
        'name',
        'description',
        'tag_no',
        'date_acquired',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            $property->tag_no = self::generateTagNumber();
        });
    }

    public static function generateTagNumber()
    {
        $lastTagNumber = self::latest('id')->value('tag_no'); //retrieves the latest record from the database

        if(!$lastTagNumber) {
            $newTagNumber = date('ym') . '00001';

            return $newTagNumber;
        }

        substr($lastTagNumber, 0, 4); //removes the first four digits of the tag number

        $remainingNumbers = intval(substr($lastTagNumber, 4, 5)) + 1; //converts the remaining numbers to integer and increments it

        $newTagNumber = date('ym') . sprintf('%05d', $remainingNumbers);

        return $newTagNumber;
    }
}
