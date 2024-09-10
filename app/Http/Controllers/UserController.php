<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator=validator::make($request->all(),[
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user_register',
            'username' => 'required|string|max:255|unique:user_register',
            'password' => 'required|string|min:8|confirmed',
            'group_id' => 'required|exists:groups,id',
        ]);
        // if($validator->fails())
        // {
        //     return response()->json
        // }
        // Validate the incoming request

        // Create the user
        $user = User::create([
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'username' => $request->input('username'),
            'group_id' => $request->input('group_id'),
        ]);

        // Return a JSON response
        return response()->json(['message' => 'User added successfully!', 'user' => $user], 201);
    }
}
