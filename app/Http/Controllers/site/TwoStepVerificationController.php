<?php

namespace App\Http\Controllers\site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class TwoStepVerificationController extends GamaSiteController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'twostep'], ['except' => ['two_step_verify']]);

        /* module details */
        $this->module['modulename'] = 'twostepverification';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array();// select parent for show in edit view
        $this->module['modulechild'] = array(); //array('module name' => array('module show fields'))

        /* Auto fill -> no change sub line */
        $this->controllerFunction = new PublicControllerFunction();
        $moduleinfo = $this->controllerFunction->getmoduleinfo($this->module['modulename']);
        $this->module['modulelabel'] = $moduleinfo['modulelabel'];
        $this->module['modulemodel'] = $moduleinfo['modulemodel']; // create model name
        $this->module['moduleprimarykey'] = $moduleinfo['moduleprimarykey'];
        $this->module['moduletabid'] = $moduleinfo['moduletabid'];
//        $this->module['moduleblockfield'] = $this->controllerFunction->getmoduleblockfield($moduleinfo['moduletabid']);
    }

    /**
     * run enabled two step verification.
     *
     * @return /
     */
    public function two_step_enabled($username)
    {
        if (!$username) abort(404);
        $current_page_user = \App\User_profile::with(['user'])->where('username', $username)->first();
        if (!$current_page_user || !$current_page_user->user) abort(404);

        $token = time() . $current_page_user->user_profileid;
        $user = $current_page_user->user;
        $user->two_step_verify = true;
        $user->two_step_login = sha1($token);
        $user->save();

        Mail::to($current_page_user->user->email)->send(new \App\Mail\TwoStepVerificationMail($current_page_user));
        Auth::logout();
        return redirect('/login')->with('success', 'please check your email.');
    }

    /**
     * Run disabled two step verification.
     *
     * @return /
     */
    public function two_step_disabled($username)
    {
        if (!$username) abort(404);
        $current_page_user = \App\User_profile::with(['user'])->where('username', $username)->first();
        if (!$current_page_user || !$current_page_user->user) abort(404);
        $user = $current_page_user->user;
        $user->two_step_verify = false;
        $user->two_step_login = null;
        $user->save();
        return back()->with('success', 'two step verification is disabled.');
    }

    /**
     * Show the application two step verification.
     *
     * @return /
     */
    public function twostepverification($username)
    {
        if (!$username) abort(404);
        $current_page_user = \App\User_profile::with(['user'])->where('username', $username)->first();
        if (!$current_page_user) abort(404);


        /* check this user profile owner */
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
            if ($current_user->user_profileid != $current_page_user->user_profileid) abort(404);
        }

        /* check and delete record if is exist */
        $verify_user = \App\Verify_user::where('user_profileid', $current_page_user->user_profileid)->first();
        if ($verify_user) $verify_user->delete();

        $token = time() . $current_page_user->user_profileid;
        $verify_user = \App\Verify_user::create([
            'user_profileid' => $current_page_user->user_profileid,
            'token' => sha1($token)
        ]);

        $current_page_user = \App\User_profile::with(['user', 'verify_user'])->where('username', $username)->first();
        Mail::to($current_page_user->user->email)->send(new \App\Mail\Verify_mail($current_page_user));
        return back()->with('success', 'email was sent successfully.');
    }

    /**
     * two step verify.
     *
     * @return /
     */
    public function two_step_verify($token)
    {
        $user = \App\User::with('user_profile')->where('id', Auth()->id())->first();
        $user_profile = $user->user_profile;
        if (($user->two_step_login == $token)){
            $user->two_step_login = 'verify';
            $user->save();
            $status = "Your account is verified.";
        } else {
            return redirect('/profile/' . $user_profile->username)->with('error', "Sorry your token is not valid.");
        }
        return redirect('/profile/' . $user_profile->username)->with('success', $status);
    }
}
