<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Imports\ServiceImport;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        $categories=ServiceCategory::select('id','name')->get();
        return view('services.index', compact('services','categories'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=ServiceCategory::select('id','name')->get();
        return view('services.create', compact('categories'));
      
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddServiceRequest $request)
    {
        Service::create($request->validated());
        return redirect()->route('services.index')->with('success', 'Service created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request,$id)
    {
        $service = Service::find($id);
      
            $service->update($request->validated());
            return redirect()->route('services.index')->with('success', 'Service updated successfully');

        
    }
    public function import(Request $request){
        Excel::import(new ServiceImport($request->file('file')), $request->file('file'));
        return redirect()->back()->with('success', 'Services imported successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
        
    }
}
