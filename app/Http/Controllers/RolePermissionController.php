<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{

    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('role-&-permission.roleToPermission.index',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('role-&-permission.roleToPermission.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'permission_id' => 'required',
            'role_id' =>'required|exists:roles,id',
        ]);
        $role = Role::find($request->role_id);
        $permission = Permission::find($request->permission_id);
        if($role->hasPermissionTo($permission) == false)
        {
            $role->givePermissionTo($permission);
            return redirect()->back()->with('success', 'Role assigned successfully!');
        }
        else
        {
            return redirect()->back()->with('error', 'permission already assigned to role');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role,$id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions;
        return view('role-&-permission.roleToPermission.edit', compact('role', 'permissions'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($id);

        // Fetch the permission names using the IDs
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

        $role->update(['name' => $request->name]);
        $role->syncPermissions($permissions); // syncPermissions expects permission names

        return redirect()->back()->with('success', 'Role Updated successfully');
    }



}
