<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\StatusOrderEnum;
use App\Helpers\StatusOrderHelper;
use App\Http\Controllers\Controller;
use App\Models\Addition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\DeliveryTime;
use App\Models\Order;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Region;
use App\Models\Review;
use App\Models\Service;
use App\Models\Size;
use App\Models\Slider;
use App\Models\Unit;
use App\Models\User;
use App\Traits\Toggle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    use Toggle;
    public function userActive(User $user)
    {
        return $this->active($user);
    }

    public function serviceActive(Service $service)
    {
        return $this->active($service);
    }

    public function sizeActive(Size $size)
    {
        return $this->active($size);
    }

    public function brandActive(Brand $brand)
    {
        return $this->active($brand);
    }

    public function unitActive(Unit $unit)
    {
        return $this->active($unit);
    }

    public function additionActive(Addition $addition)
    {
        return $this->active($addition);
    }

    public function categoryActive(Category $category)
    {
        return $this->active($category);
    }

    public function cityActive(City $city)
    {
        return $this->active($city);
    }

    public function regionActive(Region $region)
    {
        return $this->active($region);
    }

    public function deliveryTimeActive(DeliveryTime $delivery_time)
    {
        return $this->active($delivery_time);
    }

    public function pageActive(Page $page)
    {
        return $this->active($page);
    }

    public function paymentActive(Payment $payment)
    {
        return $this->active($payment);
    }

    public function sliderActive(Slider $slider)
    {
        return $this->active($slider);
    }

    public function couponActive(Coupon $coupon)
    {
        return $this->active($coupon);
    }

    public function productActive(Product $product)
    {
        return $this->active($product);
    }

    public function reviewActive(Review $review)
    {
        return $this->active($review);
    }
    public function cancel(string $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'canceled';

        $availableTransitions = collect(StatusOrderHelper::getAvailableTransitions($order->status))
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
        $order->save();
        return response()->json([
            'success' => true,
            "transitions" => $availableTransitions,
            "current" => $order->status
        ]);
    }

    public function changeStatus(Request $request, Order $order)
    {
        $newStatus = StatusOrderEnum::from($request->status);

        $order->status = $newStatus;
        $order->save();


        $availableTransitions = collect(StatusOrderHelper::getAvailableTransitions($newStatus))
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();


        return response()->json([
            'success' => true,
            'message' => 'Status updated.',
            'transitions' => $availableTransitions,
            'current' => $newStatus->value
        ]);
    }
    public function seen(Contact $contact)
    {
        $contact->seen = true;
        $contact->save();
        return response()->json([
            'success' => true,
            'seen' => $contact->seen,
        ]);
    }
    public function finish(Coupon $coupon)
    {
        $coupon->update([
            'finish' => !($coupon->finish),
        ]);
        return response()->json([
            'success' => true,
            'finish' => $coupon->finish,
        ]);
    }
    public function feature(Product $product)
    {
        $product->update([
            'feature' => ! ($product->feature),
        ]);
        return response()->json([
            'success' => true,
            'active' => $product->feature,
        ]);
    }

    public function returned(Product $product)
    {
        $product->update([
            'returned' => ! ($product->returned),
        ]);
        return response()->json([
            'success' => true,
            'active' => $product->returned,
        ]);
    }

    public function destroySession($id)
    {
        DB::table('sessions')->where('id', $id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Session deleted successfully'
        ]);
    }
}
