<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResaleUnit extends Model
{
    protected $fillable = ['image'];

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'unit_facilities', 'unit_id');
    }
    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }

    public function location() {
      return $this->belongsTo('App\Location', 'location');
    }
    public function project() {
        return $this->hasOne('App\Project','id','project_id');
    }
}
