<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;

class AssetManagerController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);

        $venues = $user->venues;

        // dd($venues);

        return inertia('UserVenue/Index', [
            'venues' => $venues,
        ]);

    }
}
