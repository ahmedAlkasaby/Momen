<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ForgetPasswordNotification;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    public function ResetPassword(Request $request)
    {
        $email = session()->get('email');

        if (!$email) {
            return response()->json([
                'error' => 'Session expired, try again',
                'status' => 400
            ], 400);
        }
        $user = User::where('email', $email)->first();
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => __('passwords.must_new_password_not_equal_old_password'),
                'status' => 400
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        session()->forget('email');

        return response()->json([
            'status' => 200,
            'redirect_url' => url('/')
        ], 200);
    }
    public function confirmOtp(Request $request)
    {
        $otp = (new Otp())->validate($request->email, $request->code);
        if ($otp->status == true) {
            return response()->json([
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                'error' => $otp->message,
                'status' => 400
            ], 400);
        }
    }
    public function ForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        session()->put('email', $request->email);

        $user = User::where('email', $request->email)->first();
        $otp = (new Otp())->generate($request->email, 'numeric', 4, 10);
        Log::info('OTP:', [$otp->token]);
        $user->notify(new ForgetPasswordNotification($otp->token));

        return response()->json([
            'status' => 200
        ], 200);
    }
}
