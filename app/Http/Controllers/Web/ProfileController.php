<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\ImageHandlerService;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\Api\ChangePasswordRequest;

class ProfileController extends MainController
{
    protected $imageService;
    public function __construct(ImageHandlerService $imageService)
    {
        parent::__construct();
        $this->setClass('home');
        $this->imageService = $imageService;
    }
    public function personalInfo()
    {
        $user = auth()->user();
        return view('web.profile.pages.personal-info', compact('user'));
    }
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->editImage($user->image, $request->file('image'), 'users');
        }

        $user->update($request->all());
        return redirect()->route('profile.index')->with('success', __('site.updated_successfully'));
    }
    public function security()
    {
        return view('web.profile.pages.change-password.index');
    }
    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            if (Hash::check($request->new_password, $user->password)) {
                return back()->with('error', __('api.The old password must not match the new password'));
            } else {
                $user->update([
                    'password' => $request->new_password
                ]);
                return redirect()->route('profile.security')->with('success', __('api.change_password_successfully'));
            }
        } else {
            return back()->with('error', __('api.current_password_not_correct'));
        }
    }
}
