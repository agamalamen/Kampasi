<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class APIController extends Controller
{
    public function getSurveyMonkey()
    {
    	return 'hello';
    	/*if(request()->has('code')) {
    		return request()->code;
    	}*/
    }
}
