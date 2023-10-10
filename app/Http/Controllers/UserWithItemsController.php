<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserItemResource;

class UserWithItemsController extends Controller
{
    public function index()
    {
        $users = User::has('items')->with('items')->get();

        // dd($users);

        $data = UserItemResource::collection($users);

        return $data;
    }
}
