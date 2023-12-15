<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueApiController extends Controller
{
    public function getVenues()
    {
        $data = Venue::with('user:id,name')
            ->get();

        return response()->json($data);
    }

    public function getVenue(Venue $venue)
    {
        $data = $venue;

        return response()->json($data);
    }
}
