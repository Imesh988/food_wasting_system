<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\ExpiryNotification;
use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Send expiry notifications manually (AJAX compatible)
     */
   public function sendExpiryNotifications(Request $request)
{
    try {
        $today = Carbon::today();
        $threeDaysLater = $today->copy()->addDays(3);

        $todayExpiredFoods = Food::whereDate('expiry_date', $today)->get();
        $next3DaysFoods = Food::whereDate('expiry_date', '>', $today)
                               ->whereDate('expiry_date', '<=', $threeDaysLater)
                               ->get();

        if ($todayExpiredFoods->isNotEmpty() || $next3DaysFoods->isNotEmpty()) {
            Mail::to('imeshramanayaka988@gmail.com')
                ->send(new ExpiryNotification($todayExpiredFoods, $next3DaysFoods));

            $message = '✅ Expire notification sent: '
                . $todayExpiredFoods->count() . ' today, '
                . $next3DaysFoods->count() . ' in next 3 days.';

            Log::info($message);
        } else {
            $message = '🎉 No food expiring today or in next 3 days.';
            Log::info($message);
        }

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);

    } catch (\Exception $e) {
        Log::error('Error sending expiry notifications: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

}