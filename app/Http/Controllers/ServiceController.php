<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
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
        if($request->hasFile('image')){
            $image = $request->file('image')->store('images/services','public');
            $request->merge(['image' => $image]);
        }
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
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
