<?php

namespace App\Http\Controllers;

use App\Services\TextLkService;
use Illuminate\Http\Request;

class ExpirySmsController extends Controller
{
    //
    protected $textlk;

    public function __construct(TextLkService $textlk)
    {
        $this->textlk = $textlk;
    }

    // UI එක
    public function index()
    {
        return view('sms_form');
    }

    // SMS යැවීම
    public function send(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:500',
        ]);

        $phone = trim($validated['phone']);
        $message = trim($validated['message']);

        // normalize phone number
        if (preg_match('/^0/', $phone)) {
            $phone = '94' . substr($phone, 1);
        }

        try {
            $response = $this->textlk->sendSms($phone, $message);

            if (($response['status'] ?? 500) === 200) {
                return redirect()->back()->with('success', '✅ SMS sent successfully!');
            } else {
                return redirect()->back()->with('error', '❌ Failed to send SMS. ' . json_encode($response['body']));
            }

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
