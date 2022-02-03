<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryRequest;
use App\Models\Inventory;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public $inventory_service;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(InventoryService $inventory_service)
    {
        $this->middleware(['auth:api', 'admin']);
        $this->inventory_service = $inventory_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $inventories = Inventory::all();
            return response()->json(
                [
                    'message' => 'Inventory successfully fetched',
                    'inventories' => $inventories,
                ], 201
            );

        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInventoryRequest $request)
    {
        try {
            $inventory = $this->inventory_service->storeInventory($request->all());

            return response()->json(
                [
                    'message' => 'Inventory successfully created',
                    'inventory' => $inventory,
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
    public function show(Inventory $inventory)
    {
        try {

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @param  int  $id Inventory ID
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['inventoryId'] = $id;

        try {
            $inventory = $this->inventory_service->updateInventory($data);

            return response()->json(
                [
                    'message' => 'Inventory successfully updated',
                    'inventory' => $inventory,
                ], 201
            );

        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);

            $inventory->delete();

            return response()->json(
                [
                    'message' => 'Inventory successfully deleted',
                ], 201
            );

        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
