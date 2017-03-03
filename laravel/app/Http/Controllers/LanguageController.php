<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App;

class LanguageController extends Controller
{
    public function changeLanguage($lang)
    {
      Session::set('language', $lang);
      return redirect()->back();
    }
}
