<?php

namespace App\Http\Controllers;

use Validator;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return Role::getAllRoles();
    }
    public function store(Request $request)
    {
        $stored = Role::create($request->all());
    }
    public function edit($id)
    {
        return Role::getSingleRole($id);
    }
    public function update(Request $request,$id)
    {
        return Role::updateSingleRote($request,$id);
    }
    public function destroy($id)
    {
        $deleteRole = Role::find($id)->delete();
        return 'Deleted';
    }
    public function GetAllrolesApi($id)
    {
        return Role::where('id',$id)->first();
    }
}
