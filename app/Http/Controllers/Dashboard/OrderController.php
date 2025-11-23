<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\StatusOrderEnum;
use App\Helpers\OrderHelper;
use App\Helpers\StatusOrderHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\MainController;
use App\Models\City;
use App\Models\DeliveryTime;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends MainController
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        parent::__construct();
        $this->setClass('orders');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function index(Request $request)
    {
        $data=OrderHelper::getOrderRelations();
        $deliveryTimes = DeliveryTime::listForSelect('filter');
        $payments = Payment::listForSelect('filter');
        $query = User::typeFilter('delivery');
        $deliverys = User::listForSelect('filter', queryBuilder: $query);
        $cities = City::ListForSelect('filter');
        $regions = Region::ListForSelect('filter');
        $orders = Order::with($data)->paginate($this->perPage);
        $transactionsStatuses = collect(StatusOrderEnum::cases())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
        return view('admin.orders.index', get_defined_vars());
    }




    public function show(string $id)
    {
        $data = OrderHelper::getOrderRelationsInSinglePage();
        $order = Order::with($data)->findOrFail($id);
        $spanClass = OrderHelper::getSpanClassByStatus($order->status);
        $statuses = collect(StatusOrderEnum::cases())
            ->mapWithKeys(fn($status) => [
                $status->value => ['label' => $status->label()]
            ])->toArray();
        $statusTimes = $order->orderStatuses
            ->mapWithKeys(fn($item) => [
                $item->status instanceof StatusOrderEnum 
                    ? $item->status->value 
                    : $item->status 
                    => $item->created_at
            ])->toArray();
        $orderFlow = array_keys($statuses);

        $currentIndex = array_search($order->status->value, $orderFlow);
        if ($order->is_read==0) {
            $order->update(['is_read' => 1, 'read_at' => now()]);
        }
        return view('admin.orders.show', get_defined_vars());
    }
}
