<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $users = User::all();
            return view('Employee.index', compact('users'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('Employee.create', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user =User::find($request->name);
            $user->phone = $request->phone;
            $user->designation = $request->designation;
            $user->joining_date = $request->joining_date;
            $user->salary = $request->salary;
            $user->status = $request->status;
            $user->save();
            return redirect()->back()->with('success', 'User created successfully!');

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('Employee.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'designation' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'salary' => 'required|numeric',
            'status' => 'required|in:available,reserved',
        ]);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->designation = $request->designation;
        $user->joining_date = $request->joining_date;
        $user->salary = $request->salary;
        $user->status = $request->status;
        $user->save();
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
