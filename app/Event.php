<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function images()
    {
        return $this->hasMany('App\EventImage');
    }
}
