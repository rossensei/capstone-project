<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyApiController extends Controller
{
    public function getProperty(Property $property)
    {
        return response()->json($property);
    }
}
