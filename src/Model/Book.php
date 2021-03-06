<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Model;

class Book extends Model
{
    protected $table = "books";
    // protected $guarded = [];
    // protected $connection = 'db';
    protected $hidden = ['deleted_at'];
    protected $fillable = ['title', 'author_id', 'sinopsis', 'cover'];
    protected $timestamp = ['created_at', 'updated_at', 'deleted_at'];
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
    public function author()
    {
        return $this->belongsTo('\App\Model\Author');
    }
    // public function getCreatedAtAttribute($date)
    // {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }

    // public function getDeletedAtAttribute($date)
    // {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }
    // public function getUpdatedAtAttribute($date)
    // {
    //     return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }
}
