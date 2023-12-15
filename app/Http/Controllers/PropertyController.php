<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search;
        $query = Property::with('venue:id,venue_name');

        if($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('tag_no', 'LIKE', "%{$search}%")
                ->orWhere('brand', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }

        $properties = $query->paginate(10)->onEachSide(0)
                        ->withQueryString();

        return inertia('Property/Index', [
            'properties' => $properties,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => ['required'],
            'name' => ['required', 'string'],
            'tag_no' => ['required', 'string', 'unique:properties'],
            'status' => ['required', 'string'],
        ]);

        Property::create($request->all());

        return back()->with('success', 'Property has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {

        // dd($property);
        $request->validate([
            'venue_id' => ['required'],
            'name' => ['required', 'string'],
            'tag_no' => ['required', 'string', Rule::unique(Property::class)->ignore($property->id)],
            'status' => ['required', 'string'],
        ]);

        $property->update($request->all());

        return back()->with('success', 'Property details has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // dd($property);

        $property->delete();

        return back()->with('success', 'Property has been deleted.');
    }
}
