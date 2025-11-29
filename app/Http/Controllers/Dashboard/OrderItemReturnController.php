<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\StatusOrderItemReturnEnum;
use App\Helpers\OrderItemReturnHelper;
use App\Models\OrderItemReturn;
use Illuminate\Http\Request;

class OrderItemReturnController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->setClass('orderItemReturns');
    }
    public function index()
    {
        $relations = OrderItemReturnHelper::getRelationsInIndex();
        $orderItemReturns = OrderItemReturn::with($relations)->paginate($this->perPage);
        $transactionsStatuses = collect(StatusOrderItemReturnEnum::cases())
            ->mapWithKeys(fn($status) => [$status->value => $status->label()])
            ->toArray();
        return view('admin.orderItemReturns.index', compact('orderItemReturns', 'transactionsStatuses'));
    }

   
    public function show(string $id)
    {
        $data = OrderItemReturnHelper::getRelationsInSinglePage();
        $orderItemReturn = OrderItemReturn::with($data)->findOrFail($id);
        return view('admin.orderItemReturns.show', compact('orderItemReturn'));
    }

}
