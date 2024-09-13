<?php

namespace App\Http\Controllers;

use App\Models\user_register;
use Hash;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index()
    {
        $user=user_register::all();
        return $user;
    }
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'fullname' => 'required|min:5',
            'email' => 'required|email|unique:user_register,email',
            'username'=>'required|unique:user_register,username',
            'password'=>'required|min:8|unique:user_register,password',
        ], [
            'fullname.required' => "Name is Required",
            'fullname.min' => "Name must be at least 5 characters",
            'email.required' => 'Email is Required',
            'email.email' => 'Email is Invalid',
            'email.unique' => 'This Email already exists',
            'username.required' => 'Username is Required',
            'username.unique' => 'This Username already exists',
            'password.required' => 'Password is Required',
            'password.min' => 'Password must be at least 8',
            'password.unique' => 'This Password already exists',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
        $user=user_register::create([
            'fullname' => $request['fullname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'username' => $request['username'],
            'group_id' => $request['group_id'],
        ]);
        return response()->json(['message' => 'User added successfully!'], 201);
    }
    public function destroy($id)
    {
        $user=user_register::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully!'], 201);
    }
}
