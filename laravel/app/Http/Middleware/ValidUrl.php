<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use App\Classroom;
use App\School;

class ValidUrl
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
        $school = School::where('username', $request->username)->first();
        $classroom = Classroom::where('username', $request->classroom_username)->first();
        if (empty($school)) {
          return redirect()->route('503');
        } else if (empty($classroom)) {
          return redirect()->route('503');
        }
        return $next($request);
    }
}
