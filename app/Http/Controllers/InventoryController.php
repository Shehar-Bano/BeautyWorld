<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
   public  $inventory;
    public function __construct(InventoryService $service){
     $this->inventory = $service;

    }
    public function index()
    {
        $inventories=$this->inventory->getAllInventories();
        return view('inventory.index',compact('inventories'));
    }
    public function create()
    {
        return view('inventory.create');
    }
    public function store(Request $request)
    {
        $this->inventory->createInventory($request);
        return redirect()->back()->with('success','product added successfully');
    }
    public function edit($id)
    {
        $inventory=$this->inventory->getInventoryById($id);
        return view('inventory.edit', compact('inventory'));
    }
    public function update(Request $request, $id)
    {
        $this->inventory->updateInventory($request, $id);
        return redirect()->back()->with('success', 'product updated successfully');
    }
    public function destroy($id)
    {
        $this->inventory->deleteInventory($id);
        return redirect()->back()->with('success', 'product deleted successfully');
    }
}
