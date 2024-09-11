<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index()
    {
        $user=User::all();
        return $user;
    }
    public function store(Request $request)
    {
        $user=User::create([
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
        $user=User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully!'], 201);
    }
}
