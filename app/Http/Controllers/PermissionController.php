<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('role-&-permission.permission',compact('permissions'));
    }
    public function create()
    {
        return view('role-&-permission.create-permission');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|unique:permissions,name|max:255',
            ]);
            // Create a new permission
            Permission::create(['name' => $request->name]);
            // Redirect back to permission list with success message
            return redirect()->back()->with('success', 'Permission created successfully');
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('role-&-permission.update-permission',compact('permission'));


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
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);

        // Redirect back to permission list with success message
        return redirect()->back()->with('success', 'Permission updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully');

    }
}
