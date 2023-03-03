<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('auth.role',compact('roles'));
    }

    public function store(RoleRequest $request){
        Role::create($request->only(['name','guard_name']));
        return redirect()->route('role.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function destroy(Role $role){
        Role::destroy($role->id);
        return redirect()->route('role.index')->with('success',config('constants.SUCCESS_DELETE'));
    }

    public function edit(Role $role){
        return response()->json($role);
    }

    public function update(RoleRequest $request,Role $role){
        Role::where('id',$role->id)->update($request->only(['name','guard_name']));
        return redirect()->route('role.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }
}
