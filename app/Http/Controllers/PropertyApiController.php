<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyApiController extends Controller
{
    public function getProperty(Property $property)
    {
        $data = [
            'id' => $property->id,
            'name' => $property->name,
            'description' => $property->description,
            'date_acquired' => $property->date_acquired->format('Y-m-d')
        ];

        return response()->json($data);
        // dd($property);
    }
}
