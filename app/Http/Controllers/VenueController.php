<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->search;

        $query = Venue::with('user:id,name');

        if($search) {
            $query->where('venue_name', 'LIKE', "%{$search}%")
                ->orWhere('building', 'LIKE', "%{$search}%");
        }

        $venues = $query->orderBy('venue_name', 'asc')
            ->paginate(10)
            ->onEachSide(0)
            ->withQueryString();
        // $venues = Venue::with('user')
        //     ->orderBy('venue_name', 'asc')
        //     ->paginate(10);

        return inertia('Venue/Index', [
            'venues' => $venues,
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $attr = $request->validate([
            'user_id' => ['required'],
            'venue_name' => ['required', 'string'],
            'building' => ['required', 'string'],
        ], [
            'user_id.required' => 'You must select a user.'
        ]);

        Venue::create($attr);

        return back()->with('success', 'A new venue has been created.');
    }

    public function update(Request $request, Venue $venue)
    {
        // dd($request->all());
        $attr = $request->validate([
            'user_id' => ['required'],
            'venue_name' => ['required', 'string'],
            'building' => ['required', 'string'],
        ], [
            'user_id.required' => 'You must select a user.'
        ]);

        $venue->update($attr);

        return back()->with('success', 'Venue details has been updated.');
    }

    public function destroy(Venue $venue)
    {
        if($venue->properties()->exists()) {
            return back()->with('error', 'You cannot delete this venue. It may have existing properties.');
        } else {
            $venue->delete();
            
            return back()->with('success', 'Venue successfully removed.');
        }
    }
}
