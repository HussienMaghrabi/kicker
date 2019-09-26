<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract_Sections extends Model
{
    protected $table = 'contract_sections';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = true;
    protected $fillable = ['title','en_description','ar_description','user_id','proposed_company_id'];

}
