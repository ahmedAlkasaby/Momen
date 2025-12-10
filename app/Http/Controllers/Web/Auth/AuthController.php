<?php

namespace App\Http\Controllers\Web\Auth;

use mail;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\SignupRequest;
use App\Notifications\SendOtpMail;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendOtpNotification;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function check_register(SignupRequest $request)
    {
        $otp = (new Otp())->generate($request->email, 'numeric', 4, 10);
        Log::info('OTP:', ['otp' => $otp, 'email' => $request->email]);
        session([
            'signup_data' => [
                'name_first' => $request->name_first,
                'name_last' => $request->name_last,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]
        ]);
        Notification::route('mail', $request->email)
            ->notify((new SendOtpMail($otp->token))->delay(now()->addMinutes(1)));

        return response()->json([
            'status' => 200,
            'message' => 'OTP sent successfully'
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }
        $data = session('signup_data');
        if (!$data) {
            return response()->json([
                'error' => 'Session expired. Please try again.',
                'status' => 400
            ], 400);
        }
        $email = session('signup_data')['email'];
        $otp = (new Otp())->validate($email, $request->code);
        Log::info('OTP:', [$otp->message]);

        if (!$otp->status) {
            return response()->json([
                'error' => $otp->message,
                'status' => 400
            ], 400);
        }
        $data['email_verified_at'] = now();
        $user = User::create($data);
        auth()->login($user);
        Log::info('OTP Email:', [$email]);
        Log::info('OTP Code:', [$request->code]);
        session()->forget('signup_data');
        return response()->json([
            'status' => 200,
            'message' => 'User registered successfully',
            'redirect_url' => url('/')
        ]);
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => __('auth.invalid_credentials'),
                'status' => 400
            ], 400);
        }

        if (!$user->active) {
            return response()->json([
                'error' => __('auth.account_not_active'),
            ], 400);
        }
        auth()->login($user);
        return response()->json([
            'status' => 200,
            'message' => 'User registered successfully',
            'redirect_url' => url('/')
        ]);
    }
    public function resendOtp(Request $request)
    {
        $data = session('signup_data');
        if (!$data) return response()->json(['error' => 'Session expired'], 400);

        $otp = (new Otp())->generate($data['email'], 'numeric', 4, 10);
        Notification::route('mail', $data['email'])
            ->notify((new SendOtpMail($otp->token))->delay(now()->addMinutes(1)));

        return response()->json(['status' => 200, 'message' => 'OTP resent successfully']);
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('web.home.index');
    }
}
