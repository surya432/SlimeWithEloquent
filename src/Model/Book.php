<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Model;

class Book extends Model
{
    protected $table = "books";
    // protected $guarded = [];
    protected $fillable = ['title', 'author', 'sinopsis', 'cover'];
    protected $timestamp = ['created_at', 'updated_at', 'deleted_at'];

    public function Author()
    {
        return $this->belongsTo('\App\Model\Author');
    }
}
