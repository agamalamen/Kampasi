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
        return view('maboneng');
    	if(Auth::User()->role != 'staffulty') {
    		return redirect()->back()->with(['message' => 'You have no access to this page', 'status' => 'alert-info', 'dismiss' =>true]);
    	}
    	return view('app.school.admin.manage-users');
    }

    public function getManageUser($username)
    {
        return view('maboneng');
    	$user = User::where('username', $username)->first();
    	return view('app.school.admin.manage-user')->with(['user' => $user]);
    }

    public function postUpdateUser($username, Request $request)
    {
        $user = User::where('username', $username)->first();

        $this->validate($request, [
        'name' => 'required|min:3',
        'phone' => 'required|digits:10'
        ]);

        if($user->username != $request['username']) {
            $this->validate($request, [
                'username' => 'required|min:3|unique:users|unique:schools',
            ]);            
        }

        if($user->email != $request['email']) {
            $this->validate($request, [
                'username' => 'required|email|unique:users',
            ]);            
        }

        if($request['password'] != '') {
            $this->validate($request, [
                'password' => 'min:6',
            ]);
            $user->password = bcrypt($request['password']);
        }

        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->role = $request['role'];
        $user->phone = $request['phone'];
        $user->hall_id = $request['hall'];
        $user->room = $request['room'];
        $user->update();
        
        return redirect()->back()->with(['message' => 'User account was updated successfully.', 'status' => 'alert-success']);
    }
}
