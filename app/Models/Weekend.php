<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weekend extends Model
{
    protected $fillable = ['id','name'];
    use HasFactory;
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
