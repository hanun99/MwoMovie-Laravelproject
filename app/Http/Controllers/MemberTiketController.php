<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Movie;
use App\Models\Order;
use App\Models\Seat;
use Illuminate\Http\Request;

class MemberTiketController extends Controller
{
    //
     public function index()
    {
        $listnavitem = Dashboard::getNavUser();
        $auth = auth()->user();
        $settlement = 'settlement';
        $capture = 'capture';
        $tiket = Order::with('payment:order_id,transaction_status,gross_amount')->whereHas('payment', function ($q) use ($settlement, $capture) {
            $q->where('transaction_status', '=', $settlement)->orWhere('transaction_status', '=', $capture);
        })->where('user_id', '=', $auth->id)->paginate(6);


        return view('dashboard.member.tiket.index', [
            'title' => 'Dashboard',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'tiket' => $tiket,
        ]);
    }

 public function show($id)
    {
        $auth = auth()->user();
        $orders = Dashboard::getRecentOrder();
        $tiket = $orders->where('order_id', '=', $id)->first();
        $movie = Movie::getDetails($tiket->id_movie);
        $listnavitem = Dashboard::getNavUser();
        return view('dashboard.member.tiket.show', [
            'title' => 'Ticket',
            'listnav' => $listnavitem,
            'auth' => $auth,
            'tiket' => $tiket,
            'movie' => $movie,
        ]);
    }

}
