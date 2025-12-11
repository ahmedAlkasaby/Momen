<?php

namespace App\Http\Controllers\Web\Auth;

use mail;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Enums\TypeUserCodeEnum;
use App\Services\UserCodeService;
use App\Notifications\SendOtpMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\SignupRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendOtpNotification;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    private $userCodeService;
    public function __construct(UserCodeService $userCodeService)
    {
        $this->userCodeService = $userCodeService;
    }
    public function check_register(SignupRequest $request)
    {
        $otp = $this->userCodeService->generate($request->email, TypeUserCodeEnum::VerfiyEmail, 4, 10);
        Notification::route('mail', $request->email)
            ->notify((new SendOtpMail($otp))->delay(now()->addMinutes(1)));
        session([
            'signup_data' => [
                'name_first' => $request->name_first,
                'name_last' => $request->name_last,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ]
        ]);
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

        $email = $data['email'];
        $otp = $this->userCodeService->validate($email, $request->code);
        Log::info('OTP:', [$otp->message]);

        if (!$otp->status) {
            return response()->json([
                'error' => $otp->message,
                'status' => 400
            ], 400);
        }

        $user = User::create($data);

        auth()->login($user);
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
        Log::info('User:', [$user]);
        Log::info('password:', [$request->password]);
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
        return redirect()->route('home');
    }
}
