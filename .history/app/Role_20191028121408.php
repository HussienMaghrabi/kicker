<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user()
    {
        return  $this->belongsTo('App\User', 'user_id');
    }

    // New Role Model 
    // protected $table = "roles";
    // protected $fillable = ['name'];
    // static function getAllRoles()
    // {
    //     return Role::paginate(100);
    // }
    // static function getSingleRole($id){
    //     return  Role::find($id);
    // }
    // static function updateSingleRote($request,$id)
    // {
    //     $update = Role::find($id);
    //     $update->name = $request->name;
    //     $update->update();

    //     return response()->json('up to date',200);
    // }
    // public function user()
    // {
    //     return  $this->belongsTo('App\User', 'user_id');
    // }

}
