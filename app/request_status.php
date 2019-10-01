<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class request_status extends Model
{
    protected $table = "request_status";
    protected $fillable = ['name'];

    static function getAll(){
        return request_status::paginate(100);
    }
}
