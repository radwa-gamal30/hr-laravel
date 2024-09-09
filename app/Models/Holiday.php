<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = ['id','name','holiday_date'];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
