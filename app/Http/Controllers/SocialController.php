<?php

namespace App\Http\Controllers;

use App\User_profile;
use App\User_verification_items;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\User;
class SocialController extends Controller
{
    protected $flag = false;
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo =Socialite::driver($provider)->stateless()->user();

        $user = $this->createUser($getInfo,$provider);
        auth()->login($user,true);
        if ($this->flag){
            //----register.
            return redirect('/Username');
        }
        else{
            //----login.
			$username = User_profile::where('userid',$user->id)->value('username');
            return redirect('/profile/'.$username);
        }

    }

    public function createUser($getInfo,$provider){

        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $this->flag = true;
            $user = User::create([
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id,
                'password' => '',
                'roleid' => 0
            ]);
        }
		$this->create_userProfile($user,$provider,$getInfo);
        return $user;
    }

	public function create_userProfile($user,$provider,$getInfo){
		//-------- after condition is true -> check with provider login -> google or facebook
        //-------- then type login -> verify is true.
		if($user){
                $User_profile = User_profile::firstOrCreate(['userid' => $user->id]);
                if ($User_profile){
                    if ($provider == "google"){
                        $User_verification = User_verification_items::firstOrCreate(
																[
																	'user_profileid' => $User_profile->user_profileid
																]
															);
						$User_verification->email = 1;
						$User_verification->save();
                    }
                    elseif ($provider == "facebook"){

                       $User_verification = User_verification_items::firstOrCreate(
																[
																	'user_profileid' => $User_profile->user_profileid
																]
															);
						$User_verification->facebook = 1;
						$User_verification->save();
                    }
                }
            }
	}
}
