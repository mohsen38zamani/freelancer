<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request)
    {
        /* chat */
        broadcast(new \App\Events\WebsoketEvent('some data'));

        return view('welcome', array(
                'slider' => $slider = \App\Slider::with('attachment')->where('active', true)->limit(5)->get(),
                'Crowd_favorites' => \App\Lv1skill::with('attachment')->limit(8)->get(),
                'skill' => \App\Skill::limit(15)->get(),
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'lang' => \App::getLocale(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'def_lang' => \App\Language::where('default', 1)->value('locale')
            )
        );
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function skills()
    {
        return view('site.skills', array(
                'skill' => \App\Skill::get(),
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'lang' => \App::getLocale(),
                'def_lang' => \App\Language::where('default', 1)->value('locale'),
            )
        );
    }

    public function public_search(Request $request)
    {
        $word = '%' . $request->word . '%';
        $freelancer = \App\User_profile::with("attachment"/*, "freelancerinfo", "country"*/)
            ->whereIn('userid', function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('roleid', 3)
                    ->groupBy('userid');
            })
            ->where(function ($query) use ($word) {
                $query->where('username', 'LIKE', $word)
                    ->orWhere('name', 'LIKE', $word)
                    ->orWhere('family', 'LIKE', $word)
                    ->orWhere('description', 'LIKE', $word)
                    ->toSql();
            })
            ->limit(3)->get()->toArray();

        $project = \App\Project::with(/*"project_advanceoption", "skill_requirment", "wage",*/ "user_profile")
            ->where('state', 'opened')
            ->where(function ($query) use ($word) {
                $query->where('name', 'LIKE', $word)
                    ->orWhere('description', 'LIKE', $word)
                    ->toSql();
            })
            ->limit(3)->get()->toArray();
        return (array('freelancers' => $freelancer, 'projects' => $project));
    }
}
