<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    protected $table = "users";
    protected $guarded = array('id', 'password');
    protected $timestamp = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['username', 'nama', 'alamat', 'email', 'password'];
    public static function beginTransaction()
    {
        self::getConnectionResolver()->connection()->beginTransaction();
    }

    public static function commit()
    {
        self::getConnectionResolver()->connection()->commit();
    }

    public static function rollBack()
    {
        self::getConnectionResolver()->connection()->rollBack();
    }
}
