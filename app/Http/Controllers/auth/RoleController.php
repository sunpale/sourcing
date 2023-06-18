<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('auth.role',compact('roles'));
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->only(['name','guard_name']));
        return redirect()->route('auth.role.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Role $role)
    {
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->only(['name','guard_name']));
        return redirect()->route('auth.role.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('auth.role.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
