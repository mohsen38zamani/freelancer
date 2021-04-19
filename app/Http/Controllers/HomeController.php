<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->roleid == 1){
            return redirect()->route('Dashboard');
        }

        elseif (Auth::user()->roleid == 2 || Auth::user()->roleid == 3) {
            $controller = new \App\Http\Controllers\PublicClass\PublicControllerFunction();
            $current_user = $controller->getcurrent_user(Auth()->id());
            /* two step verification */
            if (Auth::user()->two_step_verify) {
                $token = time() . $current_user->user_profileid;
                $user = $current_user->user;
                $user->two_step_verify = true;
                $user->two_step_login = sha1($token);
                $user->save();

                Mail::to($current_user->user->email)->send(new \App\Mail\TwoStepVerificationMail($current_user));
                return redirect()->to("/profile/" . $current_user->username)->with('success', 'please check your email.');;
            }
            return redirect()->to("/profile/" . $current_user->username);

        } else {
            Redirect::to('/login')->send();
        }
    }
}
