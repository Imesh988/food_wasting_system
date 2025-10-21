<?php

namespace App\Http\Controllers;

use App\Helpers\Gs1Parser;
use Illuminate\Http\Request;
use App\Models\Item;


class BarcodeController extends Controller
{
    //
    public function scan(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string'
        ]);

        $barcode = $request->input('barcode');

        $parsed = Gs1Parser::parse($barcode);
        $identifier = $parsed['gtin'] ?? $barcode;

        $item = Item::firstOrNew(['barcode' => $identifier]);
        $item->barcode = $identifier;


        // if($parsed['expiry']) $item->expiry_date = $parsed['expiry'];
        // if($parsed['batch']) $item->batch = $parsed['batch'];

        // if($request->filled('manual_expiry')) $item->expiry_date = $request->input('manual_expiry');
        // $item->save();

        if(!empty($parsed['expiry'])){
            $item->expiry_date = $parsed['expiry'];
           
        }elseif (!empty($request->input('manual_expiry'))) {
            $item->expiry_date = $request->input('manual_expiry');
        }else{
            $item->expiry_date = now()->addMonth()->format('Y-m-d');
        }

        if(!empty($parsed['batch'])){
            $item->batch = $parsed['batch'];            
        }

        $item->save();

        return response()->json([
            'ok'=>true,
            'item'=>$item,
            'parsed'=>[
                'expiry' => $item->expiry_date,
                'batch' => $item->batch
            ]
        ]);

    }
}
