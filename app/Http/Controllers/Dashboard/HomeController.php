<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Enums\StatusOrderEnum;
use App\Http\Controllers\Dashboard\MainController;

class HomeController extends MainController
{
    public function __construct()
    {
        parent::__construct();
        $this->setClass('home');
    }
    public function index()
    {
        // $orders = Order::with('orderItems')->get();
        // $users = User::get();
        // $products = Product::all();
        // $doneOrders = Order::where('status', 'delivered')->with('orderItems')->get();
        // $newProducts = Product::where('new', 1)->take(10)->get();
        // $totalProfit = 0;
        // foreach ($doneOrders as $order) {
        //     $totalProfit += $order->orderTotal();
        // };
        // $monthlyProfits = $this->getMonthlyOrders();
        // $colors = [
        //     'primary',
        //     'info',
        //     'success',
        //     'secondary',
        //     'danger',
        //     'warning',
        // ];
        // $months=[
        //     __("site.january"),
        //     __("site.february"),
        //     __("site.march"),
        //     __("site.april"),
        //     __("site.may"), 
        //     __("site.june"),
        //     __("site.july"),            
        //     __("site.august"),
        //     __("site.september"),
        //     __("site.october"),
        //     __("site.november"),
        //     __("site.december"),
        // ];
        return view('admin.home.index');
    }
    
    public function getMonthlyOrders()
    {
        $doneOrders = Order::where('status', StatusOrderEnum::Delivered)->with('orderItems')->get();
        $monthlyProfits = array_fill(1, 12, 0);

        foreach ($doneOrders as $order) {
            $month = (int) Carbon::parse($order->created_at)->format('n'); 
            $monthlyProfits[$month] += $order->orderTotal();
        }

        return array_values($monthlyProfits);
    }
}
