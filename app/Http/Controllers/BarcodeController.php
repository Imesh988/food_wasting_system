<?php

namespace App\Http\Controllers;

use App\Helpers\Gs1Parser;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class BarcodeController extends Controller
{
    public function scan(Request $request)
    {
        try {
            $request->validate([
                'barcode' => 'required|string'
            ]);

            $barcode = $request->input('barcode');

            $parsed = Gs1Parser::parse($barcode);

            // Use null coalescing to avoid undefined index
            $identifier = $parsed['gtin'] ?? $barcode;
            $expiry = $parsed['expiry'] ?? null;
            $batch = $parsed['batch'] ?? null;

            $item = Item::firstOrNew(['barcode' => $identifier]);
            $item->barcode = $identifier;
            $item->name = $item->name ?? 'Unknown Product';

            if($expiry) $item->expiry_date = $expiry;
            if($batch) $item->batch = $batch;

            if($request->filled('manual_expiry')) {
                $item->expiry_date = $request->input('manual_expiry');
            }

            $item->save();

            return response()->json([
                'ok' => true,
                'item' => $item,
                'parsed' => $parsed
            ]);

        } catch (\Exception $e) {
            // Log full exception to laravel.log
            Log::error('Barcode scan error: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'ok' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
