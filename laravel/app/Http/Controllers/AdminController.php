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
    	return 'hi';
    }
}
