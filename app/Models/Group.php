<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class group extends Model
{
    use HasFactory;
    protected $table='groups';
    protected $fillable = [
       'id', 'name', 'privileges_id'
    ];

    public function privileges()
    {
        return $this->belongsTo(Privilege::class, 'privileges_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
