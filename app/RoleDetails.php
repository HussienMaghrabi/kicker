<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleDetails extends Model
{
    protected $table = "roleDetails";
    protected $fillable = ['name'];

    static function GetAllWithpaginate()
    {
        return RoleDetails::paginate(100);
    }
    static function getone($id)
    {
        return RoleDetails::find($id);
    }
    static function UpdateDRole($request,$id)
    {
        $update = RoleDetails::find($id);
        $update->name = $request->name;
        $update->update();
        return response()->json('up to date',200);
    }
}
