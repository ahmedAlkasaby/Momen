<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ChangeAddressRequest;
use App\Http\Requests\Api\ChangeImageRequest;
use App\Http\Requests\Api\ChangeLangRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\ChangeThemeRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageHandlerService;
use Illuminate\Support\Facades\Hash;


class ProfileController extends MainController
{
    protected $imageHandlerService;
    public function __construct(ImageHandlerService $imageHandlerService){
        parent::__construct();
        $this->imageHandlerService=$imageHandlerService;
    }

  
    public function index()
    {
        $auth=Auth()->guard('api')->user();
        $user=User::find($auth->id);
        return $this->sendData(new UserResource($user));
    }

    public function changeAddress(ChangeAddressRequest $request)
    {
        $data = $request->validated();
        $auth=Auth()->guard('api')->user();
        $address=$auth->addresses()->where('id',$data['address_id'])->first();
        if (!$address) {
            return $this->messageError(__('api.address_not_found'));
        }
        $auth->addresses()->where('active',1)->update(['active'=>0]);
        $address->update([
            'active'=>1,
        ]);

        return $this->messageSuccess(__('api.address_changed'));

    }

    public function changePassword(ChangePasswordRequest $request){

        $user=auth()->guard('api')->user();
        if(Hash::check($request->current_password, $user->password)){
            if(Hash::check($request->new_password,$user->password)){
                return $this->messageError(__('api.The old password must not match the new password'));

            }else{
                $user->update([
                    'password'=>$request->new_password
                ]);
                return $this->messageSuccess(__('api.change_password_successfully'));
            }
        }else{
            return $this->messageError(__('api.current_password_not_correct'));

        }
    }


    public function changeImage(ChangeImageRequest $request){
        $auth=auth()->guard('api')->user();
        $user=User::find($auth->id);
        $imageUrl = $this->imageHandlerService->editImage($request, $user, 'users');
        $user->update([
            'image' => $imageUrl,
        ]);
        return $this->messageSuccess(__('api.image_updated'));
    }

    public function changeAvailable(){
        $auth=auth()->guard('api')->user();
        $auth->update([
            'notify'=>!$auth->notify,
        ]);
        return $this->messageSuccess(__('api.notify_updated'));
    }

    public function update(UpdateProfileRequest $request){
        $auth=auth()->guard('api')->user();
        $auth->update($request->validated());
        return $this->messageSuccess(__('api.profile_updated'));
    }


    public function changeLang(ChangeLangRequest $request){
        $auth=auth()->guard('api')->user();
        $auth->update([
            'lang'=>$request->lang,
        ]);
        return $this->messageSuccess(__('api.lang_updated'));
    }

    public function changeTheme(ChangeThemeRequest $request){
        $auth=auth()->guard('api')->user();
        $auth->update([
            'theme'=>$request->theme,
        ]);
        return $this->messageSuccess(__('api.theme_updated'));
    }

    


}
