<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function attempt(Request $request)
    {
        return User::authenticate($request->all());
    }

    public function check(Request $request)
    {
        return $request->user();
    }
}
