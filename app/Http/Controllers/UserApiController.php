<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends Controller
{
    public function getUsers() {
        $data = User::orderBy('name')->select('id', 'name')->get();

        return response()->json($data);
    }

    public function loadUsersWithNoOffice()
    {
        $data = User::whereDoesntHave('office')->select('id', 'name')->get();

        return response()->json($data);
    }
}
