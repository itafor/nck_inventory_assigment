<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * List all inventories
     *
     * @return \Illuminate\Http\Response
     */
    public function listInventories()
    {
        try {
            $inventories = Inventory::all();
            return response()->json(
                [
                    'message' => 'Inventories successfully fetched',
                    'inventories' => $inventories,
                ], 201
            );

        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function readInventory($inventoryId)
    {
        try {

            $inventory = Inventory::findOrFail($inventoryId);

            return response()->json(
                [
                    'message' => 'Inventory successfully fetched',
                    'inventory' => $inventory,
                ], 201
            );

        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Add an inventory to cart
     * @param Request $request
     *
     * @param mixed $inventoryId
     *
     * @return \Illuminate\Http\Response
     */
    public function addInventoryToCart(Request $request, $inventoryId)
    {
        try {
            $inventory = Inventory::findOrFail($inventoryId);

            if ($inventory && $inventory->quantity <= 0) {
                return response()->json(['error' => 'Inventory out of stock']);
            }

            if (isset($request->quantity) && $inventory->quantity < $request->quantity) {
                return response()->json(['error' => 'We have only ' . $inventory->quantity . ' inventories in stock']);
            }

            $cart = $this->getCart($inventory);

            if (isset($cart)) {

                $cart->quantity += $request->quantity;
                $cart->save();

                $this->updateInventoryQuantity($inventory, $request->quantity);

                return response()->json(
                    [
                        'message' => 'Inventory successfully added to cart',
                        'my_carts' => auth()->user()->carts,
                    ], 201
                );

            }

            $add_to_cart = $this->addToCart($inventory, $request->quantity);

            if ($add_to_cart) {

                $this->updateInventoryQuantity($inventory, $request->quantity);

                return response()->json(
                    [
                        'message' => 'Inventory successfully added to cart',
                        'my_carts' => auth()->user()->carts,
                    ], 201
                );
            }

        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    /**
     * Update the specified inventory in storage
     *
     * @param mixed $inventory The inventory to be updated
     *
     * @param mixed $quantity The given quantity
     *
     * @return [type]
     */
    public function updateInventoryQuantity($inventory, $quantity)
    {
        $inventory->quantity = $inventory->quantity - $quantity;
        $inventory->save();
    }

    /**
     * Add an inventory to cart
     *
     * @param mixed $inventory The inventory to be added
     * @param mixed $quantity The given quantity
     *
     * @return [type]
     */
    public function addToCart($inventory, $quantity)
    {
        return Cart::create(
            [
                "name" => $inventory->name,
                "price" => $inventory->price,
                "quantity" => $quantity,
                "inventory_id" => $inventory->id,
                "user_id" => auth()->user()->id,
            ]
        );
    }

    /**
     * Get a specified user inventory from cart
     *
     * @param mixed $inventory The inventory to fetch from cart
     *
     * @return array
     */
    public function getCart($inventory)
    {
        return Cart::where(
            [
                ['inventory_id', $inventory->id],
                ['user_id', auth()->user()->id],
            ]
        )->first();
    }
}
