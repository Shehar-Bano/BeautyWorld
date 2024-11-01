<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return view('role-&-permission.role.index',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('role-&-permission.role.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
        ]);

        // Create a new permission
        Role::create(['name' => $request->name]);

        // Redirect back to permission list with success message
        return redirect()->back()->with('success', 'Role created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return view('role-&-permission.role.edit',compact('role'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id . '|max:255',
        ]);

        // Find the permission and update it
        $permission = Role::findOrFail($id);
        $permission->update(['name' => $request->name]);

        // Redirect back to permission list with success message
        return redirect()->back()->with('success', 'Role Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Role::findOrFail($id);
        $permission->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');

    }
    public function goToPage(Request $request)
    {
        $user = Auth::user();

        $roles = Role::all();
        $users = User::all();
        $permissions = Permission::all();
        return view('role-&-permission.roleToPermission.index',compact('roles','users','user','permissions'));

    }
   
}
