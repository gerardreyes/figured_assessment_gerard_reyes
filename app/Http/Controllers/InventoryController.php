<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    const TYPE_APPLICATION = 'Application'; // It is a good practice to use constants instead of text in the code.

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Inventory();
        $inventories = Inventory::all();
        $availableUnits = Inventory::available()->get(); // Get all inventory that have balance using scope.
        $quantityOnHand = $model->getQuantityOnHand($availableUnits); // Get the total quantity and price based on available units.
        return view('index', compact('inventories', 'quantityOnHand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Ignore this. Just created this for a basic CRUD usage.
        // return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // A good practice is a slim controller and fat model. But it seems overkill to create Service and Repository for this simple application.
        $validatedData = $request->validate([
            'application' => 'required|numeric|min:0',
        ]);

        $availableUnits = Inventory::available()->get();

        $model = new Inventory();
        $model->updateQuantityOnHand($availableUnits, $validatedData['application']); // Updates the balance of inventory based on the number of applications entered.

        // Create an entry in the inventories table for the number of applications entered.
        Inventory::create([
            'transaction_date' => Carbon::now(),
            'type' => self::TYPE_APPLICATION,
            'quantity' => $validatedData['application'],
            'balance' => 0,
            'unit_price' => 0,
        ]);

        return redirect('/inventories')->with('success', 'Inventory is successfully updated.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Ignore this. Just created this for a basic CRUD usage.
        // $inventory = Inventory::findOrFail($id);
        // return view('edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Ignore this. Just created this for a basic CRUD usage.
        // // A good practice is a slim controller and fat model. But it seems overkill to create Service and Repository for this simple application.
        // $validatedData = $request->validate([
        //     'type' => 'required',
        //     'quantity' => 'required|numeric|min:0',
        //     'balance' => 'required|numeric|min:0',
        //     'unit_price' => 'required|numeric|min:0',
        // ]);
        // Inventory::whereId($id)->update($validatedData);
        // return redirect('/inventories')->with('success', 'Inventory is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return redirect('/inventories')->with('success', 'Inventory is successfully deleted.');
    }
}
