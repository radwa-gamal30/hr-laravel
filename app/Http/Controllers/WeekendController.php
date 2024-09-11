<?php

namespace App\Http\Controllers;
use App\Models\weekend;

use Illuminate\Http\Request;

class WeekendController extends Controller
{
    public function index(){

    }
    public function show(Request $request){
     
      
    }
     public function store(Request $request){
        $weekend= $request->validate([
            'name'=>'required|string|max:255'
        ]);
   
        weekend::create($request->all());
        return response()->json([
            'message' => 'Weekend added successfully',
            'data'=>$weekend],
            201);
    }
}
