<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable=[];

    public function items()
    {
          return $this->hasMany('App\Item','proposal_id');
    }

}
