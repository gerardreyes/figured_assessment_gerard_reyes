<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Inventory();
        $inventories = Inventory::all();
        $availableUnits = Inventory::available()->get();
        $quantityOnHand = $model->getQuantityOnHand($availableUnits);
        return view('index', compact('inventories', 'quantityOnHand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
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
            'type' => 'required',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);
        $validatedData['balance'] = $validatedData['quantity'];
        $validatedData['transaction_date'] = Carbon::now();
        $show = Inventory::create($validatedData);
        return redirect('/inventories')->with('success', 'Inventory is successfully saved.');
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
        $inventory = Inventory::findOrFail($id);
        return view('edit', compact('inventory'));
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
        // A good practice is a slim controller and fat model. But it seems overkill to create Service and Repository for this simple application.
        $validatedData = $request->validate([
            'type' => 'required',
            'quantity' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);
        Inventory::whereId($id)->update($validatedData);
        return redirect('/inventories')->with('success', 'Inventory is successfully updated.');
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
