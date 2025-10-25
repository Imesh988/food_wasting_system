<?php

namespace App\Http\Controllers;

use App\Console\Commands\CheckFoodExpiry;
use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\ExpiryNotification;
use App\Models\Food;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index(Request $request){

        $this->checkExpiry();

    }
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

        public function checkExpiry()
{
    $today = Carbon::today()->toDateString();

    // Only foods expiring today
    $todayExpiredFoods = Food::whereDate('expiry_date', $today)->get();

    if ($todayExpiredFoods->isNotEmpty()) {
        \Mail::to('imeshramanayaka988@gmail.com')
             ->send(new ExpiryNotification($todayExpiredFoods));

        echo('✅ Expire notification sent for ' . $todayExpiredFoods->count() . ' food items.');
        \Log::info('Expire notification sent for ' . $todayExpiredFoods->count() . ' food items.');
    } else {
        echo('🎉 No food expired today.');
        \Log::info('No food expired today.');
    }

    echo('⏱ Scheduler ran at ' . now());
    \Log::info('Scheduler ran at ' . now());
}

}
