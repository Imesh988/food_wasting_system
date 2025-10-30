<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;

class FoodController extends Controller
{

    public function index(){
        $food = Food::all();
        return view('food.index', compact('food'));
    }
    //
    public function create()
    {
        $food = Food::first();
        return view('food.create', compact('food'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'owner_phone' => 'required',
            'expiry_date' => 'required',
            'quantity' => 'required',
            'notes' => 'required',
        ]);

        Food::create([
            'name' => $request->name,
            'owner_phone' => $request->owner_phone,
            'expiry_date' => $request->expiry_date,
            'quantity' => $request->quantity,
            'notes' => $request->notes
        ]);

        return redirect()->route('food.index')->with('success', 'food save successfull !!');

    }

    public function edit($id){
        $food = Food::find($id);
        return view('food.edit', compact('food'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'owner_phone' => 'required',
            'expiry_date' => 'required',
            'quantity' => 'required',
            'notes' => 'required',
        ]);
        
        $food = Food::find($id);
        $data = $request->all();

        $food->update($data);

        return redirect()->route('food.index')->with('success', 'food update successfull !!');
    }

    public function destroy($id){
        $food = Food::find($id);
        $food->delete();
        return redirect()->route('food.index')->with('success', 'food delete successfull !!');
    }
}
