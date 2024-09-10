<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // public function store(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'fullname' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:user_register',
    //         'username' => 'required|string|max:255|unique:user_register',
    //         'password' => 'required|string|min:8|confirmed',
    //         'group_id' => 'required|exists:groups,id',
    //     ]);

    //     // Create the user
    //     $user = User::create([
    //         'fullname' => $request->input('fullname'),
    //         'email' => $request->input('email'),
    //         'password' => bcrypt($request->input('password')),
    //         'username' => $request->input('username'),
    //         'group_id' => $request->input('group_id'),
    //     ]);

    //     // Return a JSON response
    //     return response()->json(['message' => 'User added successfully!', 'user' => $user], 201);
    // }
}
