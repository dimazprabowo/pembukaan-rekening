<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi plural
    protected $table = 'role';
    
    // Kolom yang dapat diisi
    protected $fillable = ['role_name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}


