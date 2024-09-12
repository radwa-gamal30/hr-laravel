<?php

namespace App\Http\Controllers;
use App\Models\user_register;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function store(Request $request)
    {
        // $validateData=$request->validate([
        //     'fullname' =>['required','string','regex:/^[\pL\s\-]+$/u'],
        //     'email'=>['required','string','email','unique:users_register,email'],
        //     'username'=>['required','min:5','string'],
        //     'password'=>['required','password','min:8']
        // ]);
        $user = user_register::create([
            'fullname' => $request['fullname'],
            'email' => $request['email'],
            'password' =>$request['password'],
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
