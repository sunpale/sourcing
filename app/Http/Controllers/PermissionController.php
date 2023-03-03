<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('auth.permission',compact('permissions'));
    }

    public function store(PermissionRequest $request){
        Permission::create($request->only(['name','guard_name']));
        return redirect()->route('permission.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function destroy(Permission $permission){
        Permission::destroy($permission->id);
        return redirect()->route('permission.index')->with('success',config('constants.SUCCESS_DELETE'));
    }

    public function edit(Permission $permission){
        return response()->json($permission);
    }

    public function update(PermissionRequest $request,Permission $permission){
        Permission::where('id',$permission->id)->update($request->only(['name','guard_name']));
        return redirect()->route('permission.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }
}
