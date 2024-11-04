<?php

namespace App\Http\Controllers;

use App\Models\Expence;
use App\Models\ExpenceCategory;
use Illuminate\Http\Request;

class ExpenceController extends Controller
{
    public function index()
    {
        return view('expence.index');
    }
    public function create()
    {
        $expence_categories = ExpenceCategory::all();
        return view('expence.create',compact('expence_categories'));
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'price' => 'required',
            'date' => 'required',
        ]);
        Expence::create($data);

        return redirect()->route('expences.index')->with('success','expences added successfully');
    }
    public function edit()
    {
        return view('expence.edit');
    }
    public function update()
    {
        return view('expence.update');
    }
    public function destroy()
    {
        return view('expence.destroy');
    }
}
