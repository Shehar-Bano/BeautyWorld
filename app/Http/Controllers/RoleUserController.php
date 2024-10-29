<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->get();

        return view('role-&-permission.roleToUser.index',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        $users = User::all();
        $roles = Role::all();
        return view('role-&-permission.roleToUser.create', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        if (!$user->hasRole($role->name)) {
            $user->assignRole($role->name);
            return redirect()->back()->with('success', 'Role assigned successfully!');
        }

        return redirect()->back()->with('error', 'User already has this role.');
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('role-&-permission.roleToUser.edit', compact('roles', 'user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $role = Role::findOrFail($request->role_id);

        // Remove all existing roles and assign the new role
        $user->syncRoles([$role->name]);

        return redirect()->back()->with('success', 'Role updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();  // Remove all roles from the user
        return redirect()->back()->with('success', 'Role removed successfully!');
    }
}
