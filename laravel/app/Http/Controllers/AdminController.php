<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Input;
use Hash;
use App\User;
use App\Masterpiece;
use App\School;
use App\Hall;
use App\Notification;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function getManageUsers()
    {
    	if(Auth::User()->role != 'staffulty') {
    		return redirect()->back()->with(['message' => 'You have no access to this page', 'status' => 'alert-info', 'dismiss' =>true]);
    	}
    	return view('app.school.admin.manage-users');
    }

    public function getManageUser($username)
    {
    	$user = User::where('username', $username)->first();
    	return view('app.school.admin.manage-user')->with(['user' => $user]);
    }

    public function postUpdateUser($username, Request $request)
    {
        $this->validate($request, [
        'name' => 'required|min:3',
        'username' => 'required|min:3|unique:users|unique:schools',
        'email' => 'required|email|unique:users',
        'phone' => 'required|digits:10'
        ]);

        $user = User::where('username', $username)->first();
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->phone = $request['number'];
        $user->update();
        return redirect()->back()->with(['message' => 'User account was updated successfully.']);
    }
}
