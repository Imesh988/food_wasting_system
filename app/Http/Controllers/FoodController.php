<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;

class FoodController extends Controller
{
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

        return redirect()->route('food.create')->with('success', 'food save successfull !!');

    }
}
