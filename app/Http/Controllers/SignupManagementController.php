<?php

namespace App\Http\Controllers;

use App\Http\Controllers\site\User_verification_itemsController;
use App\User;
use App\User_profile;
use App\User_verification_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class signupManagementController extends Controller
{
    protected $controllerFunction;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Username()
    {
        return view('auth.userName');
    }

    //-------------------Username
    public function username_validate(Request $request)
    {
        //------ get -> request + userid => insert in : $array.
        $array = $request->all();
        $array['userid'] = Auth::user()->id;

        //----- check validation userName.
        $validator = Validator::make($array, [
            'username' => ['unique:user_profile,username','required','min:3'],//, 'regex:/^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$/'
            'userid' => ['required']

        ]);

        //-----if validation not true -> back error validation
        if ($validator->fails())
            throw new ValidationException($validator);  //----- exception not valid username.

        //--- else if is true -> save username in table: User_profile.
        $User_profile = User_profile::firstOrCreate([
            'userid' => Auth::user()->id
        ]);
        //----check userName is null -> then : save current username post.
        if(!$User_profile->username){
            $User_profile->username = $request->username;
            $User_profile->save();
        }

        //---- if save userName goTo next page.
        if($User_profile){
            $User_verification_items = \App\User_verification_items::firstOrCreate([
                'user_profileid' => $User_profile->user_profileid
            ]);
            //------- send email verify.
            $controllerFunctionMail = new User_verification_itemsController();
            $controllerFunctionMail->mail_verification($User_profile->username);
            return redirect('/Username=^s');
        }

        //------ error in save username.
        return back();

    }

    //-------------------page selectType
    public function username_selectType()
    {
        return view('auth.selectType');
    }

    public function selectDeveloper()
    {
        $user = User::find(Auth::user()->id);
        if (!$user)
            return back();

        $user->update([ 'roleid' => 3 ]);
        return redirect('/skill');
    }

    public function selectEmployer()
    {
        $user = User::find(Auth::user()->id);
        if (!$user)
            return back();

        $user->update([ 'roleid' => 2 ]);
        return redirect('/postProject');
    }

//    public function PostProject()
//    {
//        return view('site.employer.PostProject');
//    }

    //-------------------page infoFreeLancer

    public function show_infoFreeLancer()
    {
        return view('auth.infoFreeLancer',array(
                'experince'=> \App\Experince::limit(3)->get(),
                'mainland' => \App\Mainland::with('Country')->get()
            )
        );
    }

    public function saveUserinfo(Request $request)
    {
        //----update name,family,countryid in table -> user_profile.
        \App\User_profile::where('userid',Auth::user()->id)->update([
            'name'=>$request->FirstName,
            'family'=>$request->LastName,
            'countryid'=>$request->country,
        ]);

        //----update expreince in table -> freelancerinfo.
        $user_profileid = \App\User_profile::where('userid',Auth::user()->id)->first();
        if ($user_profileid)
        {
            \App\Freelancerinfo::where('user_profileid',$user_profileid->user_profileid)->update([
                'experinceid'=> $request->expreince,
            ]);
        }

        $this->controllerFunction = new PublicControllerFunction();
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());

        return redirect('/profile/'.$current_user['username']);
    }

    public function getCountry(Request $request){
        return \App\Country::where('mainlandid',$request->id)->get();
    }

    //-------------------

}
