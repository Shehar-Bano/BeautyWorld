<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=ServiceCategory::get();
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
        ServiceCategory::create($validated);
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
            ServiceCategory::find($id)->update($validated);
            return redirect()->back()->with('success','Category updated successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category=ServiceCategory::find($id);
        $category->delete();
        return redirect()->back()->with('success','Category deleted successfully');
    }
}
