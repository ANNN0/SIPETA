<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if (Auth::user()->utype === 'ADM') {
            return '/admin';
        }
        return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.auth');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // 1. Get current guest cart content
        $guestCartItems = Cart::instance('cart')->content();

        // 2. Restore user's saved cart from database
        // Identifier is typically user's email or ID
        Cart::instance('cart')->restore($user->email);

        // 3. Merge guest items into restored cart
        foreach ($guestCartItems as $item) {
            Cart::instance('cart')->add(
                $item->id,
                $item->name,
                $item->qty,
                $item->price,
                $item->options->all()
            )->associate('App\Models\Product');
        }

        // 4. Store the merged cart back to database
        Cart::instance('cart')->store($user->email);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => $this->redirectTo()
            ]);
        }

        return redirect()->intended($this->redirectTo());
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            // Save current cart status to database before logout
            Cart::instance('cart')->store(Auth::user()->email);
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new \Illuminate\Http\JsonResponse([], 204)
            : redirect('/');
    }
}
