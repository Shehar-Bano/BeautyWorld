<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenceCategory;

class ExpenceCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=ExpenceCategory::get();
        return view('services.category.index',compact('categories'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name'=>'required',
        ]);
        ExpenceCategory::create($validated);
        return redirect()->back()->with('success','Category created successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validated=$request->validate([
            'name'=>'required',
            ]);
            ExpenceCategory::find($id)->update($validated);
            return redirect()->back()->with('success','Category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category=ExpenceCategory::find($id);
        $category->delete();
        return redirect()->back()->with('success','Category deleted successfully');
    }
}
