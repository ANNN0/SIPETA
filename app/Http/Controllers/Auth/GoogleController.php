<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth page
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists with this email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // If user exists but doesn't have google_id, update it
                if (empty($user->google_id)) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                ]);
            }

            // Get current guest cart content before login
            $guestCartItems = Cart::instance('cart')->content();

            // Login the user
            Auth::login($user, true);

            // Regenerate session for security
            session()->regenerate();

            // Handle cart merging
            try {
                Cart::instance('cart')->restore($user->email);

                foreach ($guestCartItems as $item) {
                    Cart::instance('cart')->add(
                        $item->id,
                        $item->name,
                        $item->qty,
                        $item->price,
                        $item->options->all()
                    )->associate('App\Models\Product');
                }

                Cart::instance('cart')->store($user->email);
            } catch (\Exception $e) {
                Log::warning('Cart merge failed during Google login: ' . $e->getMessage());
            }

            // Redirect based on user type
            if ($user->utype === 'ADM') {
                return redirect('/admin');
            }

            return redirect('/');
        } catch (\Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Login dengan Google gagal: ' . $e->getMessage());
        }
    }
}
