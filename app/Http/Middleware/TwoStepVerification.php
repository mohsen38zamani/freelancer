<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TwoStepVerification
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
        if (Auth::User()->two_step_verify){
            if (Auth::User()->two_step_login != 'verify'){
                $user = \App\User_profile::where('userid', Auth()->id())->first();
                return redirect('/profile/' . $user->username)->with('error', 'please check your email and click to active link.');
            }
        }
        return $next($request);
    }
}
