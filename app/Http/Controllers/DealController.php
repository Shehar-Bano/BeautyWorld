<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\DealService;
use App\Services\DealServicePakage;

class DealController extends Controller
{
    protected $deal;
    public function __construct(DealServicePakage $deal)
    {
        $this->deal = $deal;
    }
    public function index()
    {
      $deals =  $this->deal->getDeals();
        return view('deal.index',compact('deals'));
    }
    public function create()
    {
       $services  = $this->deal->createDeal();
        return view('deal.create',compact('services'));
    }
    public function store(Request $request)
    {
          // Validate the request data
          $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'dis_price' => 'required',
            'type' => 'required',
            'services' => 'required|array',
            'duration' => 'nullable|string' // Optional field for duration
        ]);

        // Call the service to handle business logic
       $this->deal->storeDeal($validatedData);

        return redirect('/deal')->with('success','successfully added deal');
    }
    public function edit($id)
    {
        $deal = $this->deal->editDeal($id);
        $services = Service::all();
        return view('deal.edit', compact('deal','services'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'dis_price' => 'required',
            'type' => 'required',
            'services' => 'required|array',
            'duration' => 'nullable|string' // Optional field for duration
        ]);

        // Call the service to handle business logic
        $this->deal->updateDeal($validatedData, $id);

        return redirect('/deal')->with('success', 'successfully updated deal');
    }
    public function destroy($id)
    {
        $this->deal->deleteDeal($id);
        return redirect('/deal')->with('success', 'successfully deleted deal');
    }


}
