<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Model;

class Book extends Model
{
    protected $table = "books";

    public function scopePopular($query)
    {
        return $query->select('*')->get();
    }
    public function scopeGetBook($query, $id, $params)
    {
        return $query->select($params)->where('book_id', $id)->first();
    }
}
