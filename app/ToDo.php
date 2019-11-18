<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    //
    protected $guarded = [] ;

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function lead(){
        return $this->belongsTo('App\Company', 'lead_id');
    }
}
