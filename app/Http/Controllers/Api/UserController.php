<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers()
    {
        return response()->json([
            'users' => User::all(),
        ], 200);
    }
}
