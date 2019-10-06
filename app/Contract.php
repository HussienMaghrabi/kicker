<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = true;
    // 'section_id'
    protected $fillable = ['_token','contact_id','company_id','proposal_id','date'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }
    
    public function contract_Sections(){
         return $this->hasMany('App\Contract_Sections');
    }
}

