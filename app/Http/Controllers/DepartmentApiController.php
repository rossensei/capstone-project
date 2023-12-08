<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentApiController extends Controller
{
    public function getDepartment(Department $department)
    {
        return response()->json($department);
        // dd($department);
    }
}
