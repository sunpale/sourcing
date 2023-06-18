<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('auth.permission',compact('permissions'));
    }

    public function store(Request $request)
    {
        Permission::create($request->only(['name','guard_name']));
        return redirect()->route('auth.permission.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Permission $permission){
        return response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->only(['name','guard_name']));
        return redirect()->route('auth.permission.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('auth.permission.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
