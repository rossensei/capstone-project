<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::with('roles')->pluck('name')->get();

        return inertia('User/Index', [
            'users' => User::with('roles')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('fname', 'like', "%{$search}%")
                        ->orWhere('lname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->get(),
            'filters' => $request->only(['search'])
        ]);
    }

    public function search(Request $request)
    {
        // return inertia('User/Index', [
        //     'users' => User::query()
        //         ->query()
        // ]);
    }
}
