<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $users = User::latest('created_at')->get();
        $earning = Dashboard::getEarning();
        $sales = Dashboard::getSales();
        $auth = auth()->user();
        $orders = Dashboard::getRecentOrder();
        $ordersMember = $orders->where('user_id', '=', $auth->id);

        if ($auth->is_admin) {
            $listnavitem = Dashboard::getNav();
            return view('dashboard.admin.index', [
                'title' => 'Dashboard',
                'listnav' => $listnavitem,
                'orders' => $orders,
                'users' => $users,
                'earning' => $earning,
                'sales' => $sales,
                'auth' => $auth,
            ]);
        } else {
            $listnavitem = Dashboard::getNavUser();
            $tickets = Dashboard::getSales()->where('user_id', '=', $auth->id);
            return view('dashboard.member.index', [
                'title' => 'Dashboard Member',
                'listnav' => $listnavitem,
                'auth' => $auth,
                'orders' => $ordersMember,
                'tickets' => $tickets,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
