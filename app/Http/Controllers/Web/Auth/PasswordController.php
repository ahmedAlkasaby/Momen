<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\TypeUserCodeEnum;
use App\Services\UserCodeService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ForgetPasswordNotification;

class PasswordController extends Controller
{
    protected $userCodeService;

    public function __construct(UserCodeService $userCodeService)
    {
        $this->userCodeService = $userCodeService;
    }

    public function forgetPassword(Request $request)
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

        $user = User::where('email', $request->email)->first();

        $otp = $this->userCodeService->generate($request->email, TypeUserCodeEnum::ResetPassword, 4, 10);

        $user->notify(new ForgetPasswordNotification($otp));

        session()->put('reset_email', $request->email);

        return response()->json([
            'status' => 200,
            'message' => __('auth.send_code_successfully')
        ]);
    }

    public function confirmOtp(Request $request)
    {
        $email = session()->get('reset_email');
        if (!$email) {
            return response()->json([
                'error' => __('auth.session_expired'),
                'status' => 400
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        Log::info($request->all());
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $otp = $this->userCodeService->validate($email, $request->code, TypeUserCodeEnum::ResetPassword);

        if ($otp->status) {
            return response()->json([
                'status' => 200,
                'message' => __('auth.otp_verified_successfully')
            ]);
        } else {
            return response()->json([
                'error' => $otp->message,
                'status' => 400
            ], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $email = session()->get('reset_email');
        if (!$email) {
            return response()->json([
                'error' => __('auth.session_expired'),
                'status' => 400
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
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
            'password' => $request->password
        ]);

        session()->forget('reset_email');

        return response()->json([
            'status' => 200,
            'message' => __('passwords.reset_password_successfully')
        ], 200);
    }
}
