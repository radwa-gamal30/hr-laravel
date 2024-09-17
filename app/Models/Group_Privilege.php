<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Privilege extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'privileges_id','group_id'
     ];
}
