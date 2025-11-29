<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\StatusOrderEnum;
use App\Enums\StatusOrderItemReturnEnum;
use App\Helpers\StatusOrderHelper;
use App\Helpers\StatusOrderItemReturnHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdateSettingRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\DeliveryTime;
use App\Models\Order;
use App\Models\OrderItemReturn;
use App\Models\OrderStatus;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Region;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Size;
use App\Models\User;
use App\Services\ImageHandlerService;
use App\Traits\ToggleTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{

     protected $imageService;

    public function __construct(ImageHandlerService $imageService)
    {
       
        $this->imageService = $imageService;
    }
    use ToggleTrait;

    public function categoryActive($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        return $this->active($category);
    }
    public function sizeActive($id)
    {
        $size = Size::withTrashed()->findOrFail($id);
        return $this->active($size);
    }
    public function cityActive($id)
    {
        $city = City::withTrashed()->findOrFail($id);
        return $this->active($city);
    }
    public function regionActive($id)
    {
        $region = Region::withTrashed()->findOrFail($id);
        return $this->active($region);
    }
    public function pageActive($id)
    {
        $page = Page::withTrashed()->findOrFail($id);
        return $this->active($page);
    }
    public function contactActive($id)
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        return $this->active($contact);
    }
    public function brandActive($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        return $this->active($brand);
    }
    public function seen(Contact $contact)
    {
        $contact->is_read = true;
        $contact->save();
        return response()->json([
            'success' => true,
            'is_read' => $contact->is_read,
        ]);
    }
    public function productActive($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        return $this->active($product);
    }
    public function feature($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        $product->update([
            'feature' => ! ($product->feature),
        ]);
        return response()->json([
            'success' => true,
            'active' => $product->feature,
        ]);
    }

    public function returned($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->update([
            'is_returned' => ! ($product->is_returned),
        ]);
        // dd($product->is_returned);  
        return response()->json([
            'success' => true,
            'active' => $product->is_returned,
        ]);
    }
    public function special($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->update([
            'is_special' => ! ($product->is_special),
        ]);
        // dd($product->is_returned);  
        return response()->json([
            'success' => true,
            'active' => $product->is_special,
        ]);
    }
    public function reviewActive($id)
    {
        $review = Review::withTrashed()->findOrFail($id);
        return $this->active($review);
    }
    public function userActive($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return $this->active($user);
    }
    public function paymentActive($id)
    {
        $payment = Payment::withTrashed()->findOrFail($id);
        return $this->active($payment);
    }
    public function couponActive($id)
    {
        $coupon = Coupon::withTrashed()->findOrFail($id);
        return $this->active($coupon);
    }
    public function deliveryTimeActive($id)
    {
        $delivery_time = DeliveryTime::withTrashed()->findOrFail($id);
        return $this->active($delivery_time);
    }
   

    public function changeStatus(Request $request, Order $order)
    {
        $newStatus = $request->status;

        $order->status = $request->status;
        $order->save();
       

        $availableTransitions = collect(StatusOrderHelper::getAvailableTransitions($newStatus))
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();


        return response()->json([
            'success' => true,
            'message' => 'Status updated.',
            'transitions' => $availableTransitions,
            'current' => $newStatus
        ]);
    }
    public function changeItemStatus(Request $request, OrderItemReturn $item)
    {
        Log::info('request_status='.$request->status);
        $newStatus = StatusOrderItemReturnEnum::from($request->status);

        $item->update([
           'status'=>$newStatus->value
        ]);
        
        
        $availableTransitions = collect(StatusOrderItemReturnHelper::getAvailableTransitions($newStatus))
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();


        return response()->json([
            'success' => true,
            'message' =>__('site.updated_successfully'),
            'transitions' => $availableTransitions,
            'current' => $newStatus
        ]);
    }

    public function updateSetting(UpdateSettingRequest $request)
    {
        $key = $request->input('key');

        $setting = Setting::where('key', $key)->first();



        $value = $request->input('value');
        $updated = false;

        if ($setting->type === 'file' && $request->hasFile('value')) {

            $file = $request->file('value');
            $oldValue = $setting->value;

            try {
                $filePath = $this->imageService->uploadImage($file, 'Settings');
                $updated = $setting->update(['value' => $filePath]);
                $value = $filePath;

                $this->imageService->deleteImage($oldValue);
            } catch (\Exception $e) {
                Log::error("File upload failed for setting {$key}: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => __('site.image_upload_failed') . " - " . $e->getMessage(),
                ], 500);
            }
        } elseif ($setting->type !== 'file') {
            $updated = $setting->update(['value' => $value]);
        }

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => __('site.updated_successfully'),
                'key' => $key,
                'value' => $value,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('site.something_went_wrong'),
        ], 500);
    }
}
