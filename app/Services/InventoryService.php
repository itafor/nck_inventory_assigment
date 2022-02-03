<?php
namespace App\Services;

use App\Models\Inventory;

/**
 *
 */
class InventoryService
{

    /**
     * Create a new inventory
     *
     * @param mixed $data The payload
     *
     * @return \Illuminate\Http\Response
     */
    public function storeInventory($data)
    {
        $inventory = new Inventory();
        $inventory->name = $data['name'];
        $inventory->price = $data['price'];
        $inventory->quantity = $data['quantity'];
        $inventory->user_id = auth()->user()->id;
        $inventory->save();

        return $inventory;
    }

    /**
     * Update the specified inventory
     *
     * @param mixed $data The payload
     *
     * @return \Illuminate\Http\Response
     */
    public function updateInventory($data)
    {
        $inventory = Inventory::findorFail(
            $data['inventoryId']
        );
        $inventory->name = $data['name'];
        $inventory->price = $data['price'];
        $inventory->quantity = $data['quantity'];
        $inventory->save();

        return $inventory;
    }
}
