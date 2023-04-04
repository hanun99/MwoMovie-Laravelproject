<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminOrderController extends Controller
{
    //
      public function index()
    {
        $listnavitem = Dashboard::getNav();
        $auth = auth()->user();
        $orders = Order::with('user', 'payment')->latest('created_at')->paginate(6);

        return view('dashboard.admin.orders.index', [
            'title' => 'Dashboard',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'orders' => $orders,
        ]);
    }


      public function show($id)
    {
        $listnavitem = Dashboard::getNav();
        $auth = auth()->user();
        $details = Dashboard::getRecentOrder()->where('order_id', '=', $id)->first();

        $ppn = ($details->total_price / 100) * 11;
        $price = floor($details->total_price - $ppn);

        return view('dashboard.admin.orders.show', [
            'title' => 'Details Order',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'detail' => $details,
            'ppn' => $ppn,
            'price' => $price
        ]);
    }

     public function destroy($id)
    {
        $order = Order::where('order_id', '=', $id)->first();
        Order::destroy($order->order_id);
        return back()->with('messege', 'Order has been deleted!');
    }

      public function pdf($id)
    {
        $listnavitem = Dashboard::getNav();
        $auth = auth()->user();
        $details = Dashboard::getRecentOrder()->where('order_id', '=', $id)->first();

        $ppn = ($details->total_price / 100) * 11;
        $price = floor($details->total_price - $ppn);

        return view('dashboard.admin.orders.preview', [
            'title' => 'Details Order',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'detail' => $details,
            'ppn' => $ppn,
            'price' => $price
        ]);
    }

    public function downloadPDF($id)
    {
        $listnavitem = Dashboard::getNav();
        $auth = auth()->user();
        $details = Dashboard::getRecentOrder()->where('order_id', '=', $id)->first();

        $ppn = ($details->total_price / 100) * 11;
        $price = floor($details->total_price - $ppn);

        $pdf = Pdf::loadView('dashboard.admin.orders.download', [
            'title' => 'Details Order',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'detail' => $details,
            'ppn' => $ppn,
            'price' => $price
        ]);

        return $pdf->download('invoice.pdf');;
    }


}
