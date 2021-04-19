<?php

namespace App\Http\Controllers;

use App\Lv1skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'twostep']);
    }

    public function selectSkill()
    {
        //---- get all skill category and send to view.
        return view('auth.skill',array(
                "Lv1skill"=> \App\Lv1skill::with('Skill')->get()
            )
        );
    }


    public function saveSkill(Request $request)
    {
        $skillid = explode(',',$request->data);

        //----get userProfileid by -> userid.
        $userProfileid = \App\User_profile::where('userid', Auth::user()->id)->value('user_profileid');
        //-----if not exists user_profileid redirect to login page.
        if (!$userProfileid)
        {
           return redirect('/login');
        }

        $freelancerinfoid =\App\Freelancerinfo:: firstOrCreate(['user_profileid' =>  $userProfileid ]);

        //-----the loop insert skill user in table --> Skill_freelancer.
        $counter = 0;
        foreach ($skillid as $id){
            if ($counter >= 20) break;

            $lv1skillid = \App\Skill::where('skillid', $id)->value('lv1skillid');
            //------------if not exists lv1skillid in table Skill -> continue.
            if (!$lv1skillid) continue;

            //-----save skill in Skill_freelancer.
            \App\Skill_freelancer::firstOrCreate([
                'freelancerinfoid' => $freelancerinfoid->freelancerinfoid ,
                'lv1skillid'=> $lv1skillid,
                'skillid'=> $id
            ]);
            $counter ++;
        }
        return redirect('/UserInfo');
    }
}
