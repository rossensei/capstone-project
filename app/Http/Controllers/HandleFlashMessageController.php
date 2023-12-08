<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandleFlashMessageController extends Controller
{
    public function forget() {
        session()->forget(['error', 'success']);
    }
}
