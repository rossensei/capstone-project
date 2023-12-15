<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Venue;
use App\Models\Property;
use Illuminate\Http\Request;

class VenuePropertyController extends Controller
{
    public function index(Venue $venue)
    {
        // dd($venue);

        $properties = $venue->properties;

        return inertia('Venue/ShowProperties', [
            'venue' => $venue->load('user:id,name'),
            'properties' => $properties
        ]);
    }

    public function moveProperty(Request $request)
    {
        $venue = Venue::find($request->venueId);
        $property = Property::find($request->propertyId);

        if (!$venue || !$property) {
            // Handle the case where one or both records do not exist
            return back()->with('error', 'There was an error processing your request. Please try again.');
        }

        $property->venue()->dissociate();
        $property->venue()->associate($venue);
        $property->date_acquired = Carbon::now()->format('Y-m-d');
        $property->save();

        return back()->with('success', 'Property has been successfully moved to the destined location.');
    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());

        $property = Property::find($request->propertyId);

        if(!$property) {
            return back()->with('error', 'There was an error processing your request. Please try again.');
        }

        $property->status = $request->status;
        $property->save();

        return back()->with('success', 'Property status has been updated.');
    }
}
