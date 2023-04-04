<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Order;
use Illuminate\Http\Request;

class MemberOrders extends Controller
{
    //
      public function index()
    {
        $listnavitem = Dashboard::getNavUser();
        $auth = auth()->user();
        $orders = Dashboard::getRecentOrder();
        $ordersMember = Order::with('user', 'payment')->where('user_id', '=', auth()->user()->id)->latest('created_at')->paginate(6);

        return view('dashboard.member.order.index', [
            'title' => 'Orders',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'orders' => $ordersMember,
        ]);
    }

    public function show($id)
    {
        $listnavitem = Dashboard::getNavUser();
        $auth = auth()->user();
        $details = Dashboard::getRecentOrder()->where('order_id', '=', $id)->first();

        $ppn = ($details->total_price / 100) * 11;
        $price = floor($details->total_price - $ppn);

        return view('dashboard.admin.sales.show', [
            'title' => 'Details Order',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'detail' => $details,
            'ppn' => $ppn,
            'price' => $price
        ]);
    }



}
