<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Models\User;


class SettingController extends Controller
{
    //
       public function index()
    {
        $auth = auth()->user();
        if ($auth->is_admin) {
            $listnavitem = Dashboard::getNav();
            return view('dashboard.admin.setting.index', [
                'title' => 'Setting',
                'listnav' => $listnavitem,
                'auth' => $auth,
            ]);
        } else {
            $listnavitem = Dashboard::getNavUser();
            return view('dashboard.member.setting.index', [
                'title' => 'Setting',
                'listnav' => $listnavitem,
                'auth' => $auth,

            ]);
        }
    }

     public function update(Request $request, $id)
    {
        $user = User::where('id', '=', $id)->first();
        $data = $request->validate([
            'name' => 'required|max:255',
            'username' => ($request->username == $user->username) ?  'required|min:3|max:255' : 'required|min:3|max:255|unique:users',
            'email' => ($request->email == $user->email) ?  'required|email' : 'required|email|unique:users',
            'address' => 'nullable|max:255',
            'no_telphone' => 'nullable|max:255',
        ]);
        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('img', ['disk' => 'img']);
        }

        User::where('id', '=', $id)->update($data);

        return back()->with('messege', 'Profile has been updated!');
    }

    
}
