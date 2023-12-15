<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class FindPropertyController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->search;

        $query = Property::query();

        $query->with('office');

        if($search) {
            $query->where('tag_no', 'LIKE', "%{$search}%");
        }

        $properties = $query->paginate(10)
            ->onEachSide(0)
            ->withQueryString()
            ->through(fn($property) => [
                'id' => $property->id,
                'name' => $property->name,
                'description' => $property->description,
                'tag_no' => $property->tag_no,
                'date_acquired' => $property->date_acquired,
                'status' => $property->status,
                'office' => $property->office->office_name,
            ]);
            
        return inertia('SearchPage', [
            'properties' => $properties,
            'filters' => $request->only(['search'])
        ]);
    }


}
