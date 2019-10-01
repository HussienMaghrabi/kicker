<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hrSettings extends Model
{
    protected $table = "hr_new_settings";

    public function getAll(){
        dd('new from model');
    }
}
