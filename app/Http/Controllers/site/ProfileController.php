<?php

namespace App\Http\Controllers\site;

use App\Attachment;
use Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public $module;
    protected $controllerFunction;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'twostep'], ['except' => ['profile']]);
        /* module details */
        $this->module['modulename'] = 'user_profile';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('country' => array('name'));//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array();// select parent for show in edit view
        $this->module['modulechild'] = array(); //array('module name' => array('module show fields'))
        $block_field = array(
            'profile' => array(
                'name' => array('type' => 'text', 'required' => true, 'value' => null, 'readonly' => false, 'placeholder' => ''),
                'family' => array('type' => 'text', 'required' => true, 'value' => null, 'readonly' => false, 'placeholder' => ''),
                'address' => array('type' => 'textarea', 'required' => false, 'value' => null, 'readonly' => false, 'placeholder' => ''),
                'city' => array('type' => 'text', 'required' => false, 'value' => null, 'readonly' => false, 'placeholder' => ''),
                'province' => array('type' => 'text', 'required' => false, 'value' => null, 'readonly' => false, 'placeholder' => ''),
                'postcode' => array('type' => 'text', 'required' => false, 'value' => null, 'readonly' => false, 'placeholder' => ''),
                'companyname' => array('type' => 'text', 'required' => false, 'value' => null, 'readonly' => false, 'placeholder' => ''),
            ),
        );
        /* Auto fill -> no change sub line */
        $this->controllerFunction = new PublicControllerFunction();
        $moduleinfo = $this->controllerFunction->getmoduleinfo($this->module['modulename']);
        $this->module['modulelabel'] = $moduleinfo['modulelabel'];
        $this->module['modulemodel'] = $moduleinfo['modulemodel']; // create model name
        $this->module['moduleprimarykey'] = $moduleinfo['moduleprimarykey'];
        $this->module['moduletabid'] = $moduleinfo['moduletabid'];
        $this->module['moduleblockfield'] = $block_field;
    }

    public function login(){
		 if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
            if ($current_user->username){
                return \redirect()->to('/profile/'.$current_user->username);
            }
        }
	}

    public function profile($username)
    {
        if (!$username) abort(404);
        $current_page_user = \App\User_profile::with(['user', 'country', 'profile_img', 'banner_img', 'freelancerinfo', 'education', 'job_experience', 'qualification', 'publication', 'user_verification_items'])->where('username', $username)->first();
        if (!$current_page_user) abort(404);
        $authenticatied = false;

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
            if ($current_user->user_profileid == $current_page_user->user_profileid) $authenticatied = true;
            $chat = \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count();
        }

        $portfolio = \App\Portfolio::with('attachment')->where('user_profileid', $current_page_user->user_profileid)->limit(4)->get();
        return view('site.profile.view', array(
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'chat' => $chat ?? null,
                'current_user' => $current_user,
                'current_page_user' => $current_page_user,
                'portfolio' => $portfolio,
                'authenticatied' => $authenticatied,
                'current_page_user_isOnline' => Cache::has('user-is-online-' . $current_page_user->user->id),
            )
        );
    }

    /**
     * @param $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($username)
    {
        if (!$username) abort(404);
        $current_page_user = \App\User_profile::with(['user', 'country', 'profile_img', 'banner_img', 'user_creditcard', 'transaction'])->where('username', $username)->first();
        if (!$current_page_user) abort(404);
        $authenticatied = false;

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
            if ($current_user->user_profileid != $current_page_user->user_profileid) abort(404);
        }
        $user_device['userAgent'] = Browser::userAgent();
        $user_device['isMobile'] = Browser::isMobile();
        $user_device['isTablet'] = Browser::isTablet();
        $user_device['isDesktop'] = Browser::isDesktop();

        $user_device['browserName'] = Browser::browserName();
        $user_device['platformName'] = Browser::platformName();
        $user_device['deviceFamily'] = Browser::deviceFamily();
        $user_device['deviceModel'] = Browser::deviceModel();
        $user_device['ip'] = \Request::ip();

        $portfolio = \App\Portfolio::with('attachment')->where('user_profileid', $current_page_user->user_profileid)->limit(4)->get();
        return view('site.profile.edit', array(
                'block_field' => $this->module['moduleblockfield'],
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
                'current_user' => $current_user,
                'current_page_user' => $current_page_user,
                'portfolio' => $portfolio,
                'authenticatied' => $authenticatied,
                'user_device' => $user_device,
                'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $this->validate($request, [
            'family' => 'required|string',
        ]);

        /* edit record */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        } else {
            abort(404);
        }
        $record = \App\User_profile::where('user_profileid', $current_user->user_profileid)->first() ?? abort(404);
        $record->name = $request->name;
        $record->family = $request->family;
        $record->address = $request->address;
        $record->city = $request->city;
        $record->postcode = $request->postcode;
        $record->gender = $request->gender;
        $record->description = $request->description;
        $record->tel = $request->tel;
        $record->mobile = $request->mobile;
        $record->birthday = $request->birthday;
        $record->province = $request->province;
        $record->companyname = $request->companyname;
        $record->save();

        return back()->with('success', 'You edit your profile');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit_account(Request $request)
    {
        /* edit record */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        } else {
            abort(404);
        }
        $record = \App\User::where('id', Auth()->id())->first() ?? abort(404);
        $record->roleid = $request->account_type;
        $record->save();

        return back()->with('success', 'You edit your profile');
    }

    /**
     *  Admin change password.
     *
     * @param Request $request
     * @return alert
     */
    public function change_password(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
        if (!Auth()->id()) abort(404);
        $user = \App\User::find(Auth()->id());
        $user->makeVisible('password')->toArray();
        $current_password = $user->makeVisible('password')->toArray()['password'];
        $userid = $user->makeVisible('password')->toArray()['id'];
        if (Hash::check($request->current_password, $current_password)) {
            DB::table('users')
                ->where('id', $userid)
                ->update(['password' => Hash::make($request->new_password)]);

            return back()->with('success', 'Your password is changed!');
        } else {
            return back()->with('error', 'Please enter correct current password');
        }
    }

    /**
     *  Admin upload cover.
     *
     * @param Request $request
     * @return to view
     */
    public function cover(Request $request)
    {
        if (!Auth()->id()) abort(404);
        if ($request->hasFile('cover')) {
            /* upload new file */
            $file_path = $request->cover->store('upload/' . $this->module['modulename']);
            $attachment = new Attachment();
            $attachment->title = 'banner';
            $attachment->path = $file_path;
            $attachment->tabid = $this->module['moduletabid'];
            $attachment->ownerid = Auth()->id();
            try {
                /* delete old attachment file */
                $old_attachment = Attachment::where('tabid', $this->module['moduletabid'])->where('ownerid', Auth()->id())->where('title', 'banner')->first();
                if ($old_attachment)
                    $old_attachment->delete();
                $attachment->save();
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            return back()->with('success', 'Your cover is changed!');
        } else {
            return back()->with('error', 'Please select one file!');
        }
    }

    /**
     *  Admin upload avatar.
     *
     * @param Request $request
     * @return to view
     */
    public function avatar(Request $request)
    {
        if (!Auth()->id()) abort(404);
        if ($request->hasFile('avatar')) {
            /* upload new file */
            $file_path = $request->avatar->store('upload/' . $this->module['modulename']);
            $attachment = new Attachment();
            $attachment->title = 'profile';
            $attachment->path = $file_path;
            $attachment->tabid = $this->module['moduletabid'];
            $attachment->ownerid = Auth()->id();
            try {
                /* delete old attachment file */
                $old_attachment = Attachment::where('tabid', $this->module['moduletabid'])->where('ownerid', Auth()->id())->where('title', 'profile')->first();
                if ($old_attachment)
                    $old_attachment->delete();

                $attachment->save();
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            return back()->with('success', 'Your avatar is changed!');
        } else {
            return back()->with('error', 'Please select one file!');
        }
    }
}
