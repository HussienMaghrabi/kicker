<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectRequest extends Model
{
    public function developer() {
        return $this->belongsTo('App\Developer');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }
}
