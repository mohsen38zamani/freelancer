<?php

namespace App\Http\Controllers\site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GamaController;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class User_verification_itemsController extends GamaController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'twostep']);

        /* module details */
        $this->module['modulename'] = 'user_verification_items';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('user_profile' => array('name', 'family'));//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array();// select parent for show in edit view
        $this->module['modulechild'] = array(); //array('module name' => array('module show fields'))

        /* Auto fill -> no change sub line */
        $this->controllerFunction = new PublicControllerFunction();
        $moduleinfo = $this->controllerFunction->getmoduleinfo($this->module['modulename']);
        $this->module['modulelabel'] = $moduleinfo['modulelabel'];
        $this->module['modulemodel'] = $moduleinfo['modulemodel']; // create model name
        $this->module['moduleprimarykey'] = $moduleinfo['moduleprimarykey'];
        $this->module['moduletabid'] = $moduleinfo['moduletabid'];
        $this->module['moduleblockfield'] = $this->controllerFunction->getmoduleblockfield($moduleinfo['moduletabid']);
    }

    /**
     * Show the application record of module edit view.
     * @param  Request $id
     * @return /view/panel/edit
     */
    public function edit($id)
    {
        $action = '/' . $this->module['modulename'] . '/edit';
        $function = $this->controllerFunction->edit($this->module, $id, "\App\Http\Controllers\site\\");

        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/edit'),
            array(
                'block_field' => $function['block_field'],
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

    /**
     * save a edited record of module.
     *
     * @param  Request $request
     * @return $Response message in view
     */
    public function save(Request $request)
    {
        $this->controllerFunction->save($this->module, $request);
        return back()->with('success', 'You have edited one ' . $this->module['modulename']);
    }

    /**
     * Show the application mail verification.
     *
     * @return /
     */
    public function mail_verification($username)
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
     * Show the application verify user.
     *
     * @return /
     */
    public function verify_user($token)
    {
        $verify_user = \App\Verify_user::with('user_profile')->where('token', $token)->first();
        if ($verify_user) {
            $user_profile = $verify_user->user_profile;
            if (!$user_profile->user_verification_items->email) {
                $user_profile->user_verification_items->email = 1;
                $user_profile->user_verification_items->save();
                $verify_user = \App\Verify_user::where('user_profileid', $user_profile->user_profileid)->first();
                if ($verify_user) $verify_user->delete();
                $status = "Your e-mail is verified.";
            } else {
                $status = "Your e-mail is already verified.";
            }
        } else {
            return redirect('/login')->with('error', "Sorry your email cannot be identified.");
        }
        return redirect('/profile/' . $user_profile->username)->with('success', $status);
    }
}
