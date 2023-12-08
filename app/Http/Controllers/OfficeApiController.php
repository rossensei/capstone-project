<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeApiController extends Controller
{
    public function getOffice(Office $office)
    {
        return response()->json($office);
        // dd($department);
    }
}
