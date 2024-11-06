<?php

namespace App\Http\Controllers;

use App\Models\Expence;
use App\Models\ExpenceCategory;
use Illuminate\Http\Request;

class ExpenceController extends Controller
{
    public function index()
    {
        $expence_categories = ExpenceCategory::all();
        $expences = Expence::with('expenceCategory')->get();
        return view('expence.index',compact('expences','expence_categories'));
    }
    public function create()
    {
        $expence_categories = ExpenceCategory::all();
        return view('expence.create',compact('expence_categories'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'category_id'=>'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
        Expence::create($data);

        return redirect()->route('expences.index')->with('success','expences added successfully');
    }
    public function edit($id)
    {
        $expence = Expence::find($id);
        $expence_categories = ExpenceCategory::all();
        return view('expence.edit',compact('expence_categories','expence'));
    }
    public function update(Request $request,$id)
    {
        $data = request()->validate([
            'category_id'=>'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);
        Expence::find($id)->update($data);
        return redirect()->route('expences.index')->with('success','expences updated successfully');
    }
    public function destroy($id)
    {
         Expence::find($id)->delete();
       return redirect()->route('expences.index')->with('success', 'expences deleted successfully');
    }
}
