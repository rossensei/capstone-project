<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;

class PersonnelApiController extends Controller
{
    public function getPersonnel(Personnel $personnel)
    {
        $data = [
            'id' => $personnel->id,
            'name' => $personnel->name,
            'office_id' => $personnel->office_id,
        ];

        return response()->json($data);
    }
}
