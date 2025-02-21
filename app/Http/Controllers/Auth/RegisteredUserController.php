<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\EmailOtp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('ragister');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            // 'password' => ['required', 'confirmed',Password::defaults()],
        ]);

        $otp =  rand(100000, 999999);
        $user = EmailOtp::updateOrCreate(['email' => $request->email], [
            'name' => $request->name,
            'email' => $request->email,
            'otp' => $otp,
            'expired_at' => Carbon::now()->addMinute(5)
        ]);

        $request->session()->put('register_name', $request->name);
        $request->session()->put('register_email', $request->email);
        $request->session()->put('register_password', Hash::make($request->password));


        Mail::to($request->email)->queue(new WelcomeMail($otp));

        return redirect()->route('verify.otp');
    }


    public function verifyOtp()
    {
        return view('email_otp_verify');
    }

    public function verifyOtpStore(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $name = $request->session()->get('register_name');
        $email = $request->session()->get('register_email');
        $password = $request->session()->get('register_password');


        $emailOtp = EmailOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->where('expired_at', '>=', Carbon::now())
            ->first();

        if (!$emailOtp) {
            return redirect()->back()->withInput()->with(['message' => 'Invalid OTP!']);
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $emailOtp->delete();

        $request->session()->forget('register_name');
        $request->session()->forget('register_email');
        $request->session()->forget('register_password');


        Auth::login($user);
        
        return redirect('home');
    }
}