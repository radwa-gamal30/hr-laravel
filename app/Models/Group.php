<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;
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
