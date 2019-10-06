<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class request_type extends Model
{
    protected $table = "request_type";
    protected $fillable = ['name'];

    static  function getAll()
    {
        return request_type::all();
    }
}
