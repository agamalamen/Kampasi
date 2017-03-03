<?php

namespace App\Http\Middleware;

use Closure;
use App\Classroom;
use App\School;
use Illuminate\Support\Facades\Auth;

class EnrolledToClassroom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $classroom = Classroom::where('username', $request->classroom_username)->first();
        if(!Auth::User()->classrooms->find($classroom->id)) {
          return redirect()->route('get.classrooms', $request->username);
        }
        return $next($request);
    }
}
