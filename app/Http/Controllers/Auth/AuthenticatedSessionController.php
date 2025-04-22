<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $password = Hash::make($request->password);
        // $userStatus = User::query()
        // ->where('name', $request->name)
        // ->value('user_status_id');

        $userStatus = User::query()
        ->where('login_name', $request->login_name)
        ->value('user_status_id');

        if ($userStatus == 1) {
            $request->authenticate();

            $request->session()->regenerate();
    
            return redirect()->intended(route('form', absolute: false));
        } else {
            return redirect()->intended(route('login', absolute: false))
            ->with('error', 'Your account is inactive. Please contact support.');;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
