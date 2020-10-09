<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    protected $table = "users";
    protected $timestamp = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['username', 'nama', 'alamat', 'email', 'password'];
}
