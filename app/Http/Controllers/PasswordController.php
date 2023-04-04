<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordController extends Controller
{
    //
      public function index()
    {
        $auth = auth()->user();

        if ($auth->is_admin) {
            $listnavitem = Dashboard::getNav();
            return view('dashboard.admin.password.index', [
                'title' => 'Change Password',
                'listnav' => $listnavitem,
                'auth' => $auth,
            ]);
        } else {
            $listnavitem = Dashboard::getNavUser();
            return view('dashboard.member.password.index', [
                'title' => 'Change Password',
                'listnav' => $listnavitem,
                'auth' => $auth,
            ]);
        }
    }


     public function update(Request $request, $id)
    {

        if (password_verify($request->oldpassword, auth()->user()->password)) {
            if ($request->newpassword == $request->repassword) {
                User::find(auth()->user()->id)->update(['password' => Hash::make($request->newpassword)]);
                return back()->with('messege', 'Password has been updated!');
            } else {
                return back()->with('messege', 'Confirm password invalid');
            }
        } else {
            return back()->with('messege', 'Password Invalid');
        }
    }



}
