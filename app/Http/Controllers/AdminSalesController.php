<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dashboard;

class AdminSalesController extends Controller
{
    //
     public function index()
    {
        $listnavitem = Dashboard::getNav();
        $auth = auth()->user();
        $settlement = 'settlement';
        $capture = 'capture';
        $sales = Order::with('payment')->whereHas('payment', function ($q) use ($settlement, $capture) {
            $q->where('transaction_status', '=', $settlement)->orWhere('transaction_status', '=', $capture);;
        })->paginate(6);

        return view('dashboard.admin.sales.index', [
            'title' => 'Dashboard',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'sales' => $sales,
        ]);
    }

      public function show($id)
    {
        $listnavitem = Dashboard::getNav();
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
