<?php
namespace App\Services;

use App\Models\Inventory;
use Illuminate\Support\Facades\Request;

class InventoryService
{

    public function getAllInventories()
    {
        $inventories = Inventory::all();
        return $inventories;
    }
    public function createInventory( $request )
    {
        $validate = $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'status' => 'required',
        ]);

            return Inventory::create($validate);

    }
    public function getInventoryById($id)
    {
        return Inventory::findOrFail($id);
    }
    public function updateInventory($request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $validate = $request->validate([
            'product_name'=> 'required',
            'price'=>'required',
            'quantity'=>'required',
            'status' => 'required'
            ]);
        $inventory->update($validate);
    }
    public function deleteInventory($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
    }

}
