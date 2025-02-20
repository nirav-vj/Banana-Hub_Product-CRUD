<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\WelcomeMail;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

use function Laravel\Prompts\error;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function login(): View
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function logincheck(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        try {
            $toemailaddress = $request->email;
            $welcomemail = 'Wlcome to Banana-Hub app';
            $responce = Mail::to($toemailaddress)->queue(new WelcomeMail($welcomemail));
        } catch (Exception $e) {
            error('Unable to send mail'.$e->getMessage());
        }

        return redirect('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}