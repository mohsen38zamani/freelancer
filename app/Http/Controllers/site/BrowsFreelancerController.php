<?php

namespace App\Http\Controllers\site;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use Illuminate\Http\Request;

class BrowsFreelancerController extends Controller
{
    public $module;
    protected $controllerFunction;

    public function __construct()
    {
        $this->middleware(['auth', 'twostep'], ['except' => ['profile']]);
        /* module details */
        $this->module['modulename'] = 'user_profile';
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
        $this->module['moduleblockfield'] = $this->controllerFunction->getmoduleblockfield($moduleinfo['moduletabid']);
    }

    public function showAll()
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'projects']);
        }

        $priceHour['min'] = ceil(\App\Wage::where('type', 'hour')->min('minbudget'));
        $priceHour['max'] = ceil(\App\Wage::where('type', 'hour')->max('maxbudget'));

        /* skill list */
        $item = array();
        $skill = \App\Skill::all();
        foreach ($skill as $key => $value) {
            $item[$value->skillid] = $value->name;
        }
        $function['block_field']['information']['skill'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => true);

        $Country = \App\Country::all();
        $function['block_field']['information']['Country'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $Country, 'translate' => false, 'multiple' => false);

        return view('site.browsFreelancer', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'current_user' => $current_user,
            'current_page_user' => $current_user,
            'priceHour' => $priceHour,
            'authenticatied' => true,
            'block_field' => $function['block_field']
        ));
    }

    public function list(Request $request)
    {
        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'projects']);
        }

        $arrayWhere = [];
        if (isset($request['priceHourly']) && $request['priceHourly'] != null) {
            //------ check priceHourly project is set.
            $priceHourly = explode(',', $request['priceHourly']);
            $arrayWhere['minbudget'] = $priceHourly[0];
            $arrayWhere['maxbudget'] = $priceHourly[1];
        }

        //------ check skills project is set.
        if (isset($request['skills'])) {
            $arrayWhere['skillid'] = $request['skills'];
        }

        //------ check country project is set.
        if (isset($request['country'])) {
            $arrayWhere['countryid'] = $request['country'];
        }

        //-----------check post value price min and max : if not exist get min and max from table wage.
        if (isset($arrayWhere['minbudget']) && isset($arrayWhere['maxbudget'])) {
            $minbudget = $arrayWhere['minbudget'];
            $maxbudget = $arrayWhere['maxbudget'];
            unset($arrayWhere['minbudget'], $arrayWhere['maxbudget']);
        } else {
            $minbudget = 2;
            $maxbudget = 250;
            unset($arrayWhere['minbudget'], $arrayWhere['maxbudget']);
        }

        //---if not post skill_id -> select all skills from (tabel skill) for use in query.
        if (isset($arrayWhere['skillid']) && $arrayWhere['skillid'] == "null") {
            $skillid = \App\Skill::pluck('skillid');
            unset($arrayWhere['skillid']);
        } else {
            $skillid = explode(',', $arrayWhere['skillid']);
            unset($arrayWhere['skillid']);
        }

        //---if not post countryid -> select all userProfile with any countryid from (tabel userProfile) for use in query.
        if (isset($arrayWhere['countryid']) && $arrayWhere['countryid'] == "null") {
            $countryid = \App\User_profile::groupBy('countryid')->pluck('countryid', 'countryid');
            unset($arrayWhere['countryid']);
        } else {
            $countryid[0] = $arrayWhere['countryid'];
            unset($arrayWhere['countryid']);
        }

        if ($request->textSearch != "") {
            $word = '%' . $request->textSearch . '%';
            $result = \App\User_profile::with("attachment", "freelancerinfo", "country", "user")
                ->whereHas("freelancerinfo.skill_freelancer", function ($query) use ($skillid) {
                    $query->whereIn("skillid", $skillid);
                })
                ->whereBetween("hourly_rate_value", [(int)$minbudget, (int)$maxbudget])
                ->whereIn("countryid", $countryid)
                ->whereIn('userid', function ($query) {
                    $query->select('id')
                        ->from('users')
                        ->where('roleid', 3)
                        ->groupBy('userid');
                })
                ->where(function($query) use ($word) {
                    $query->where('username', 'LIKE', $word)
                        ->orWhere('name', 'LIKE', $word)
                        ->orWhere('family', 'LIKE', $word)
                        ->orWhere('description', 'LIKE', $word)
                        ->toSql();
                })
                ->get();
        } else {
            $result = \App\User_profile::with("attachment", "freelancerinfo", "country")
                ->whereHas("freelancerinfo.skill_freelancer", function ($query) use ($skillid) {
                    $query->whereIn("skillid", $skillid);
                })
                ->whereIn('userid', function ($query) {
                    $query->select('id')
                        ->from('users')
                        ->where('roleid', 3)
                        ->groupBy('userid');
                })
                ->whereBetween("hourly_rate_value", [(int)$minbudget, (int)$maxbudget])
                ->whereIn("countryid", $countryid)->get();
        }

        return $result;
    }

    public function chat_request(Request $request)
    {
        $response = false;
        $freelancer = \App\User_profile::where('userid', $request->freelancerid)->first();
        if ($freelancer) {
            /* create message */
            $url = url('/project-request/' . $request->projects);
            $message = " <div style='width: 100%; background-color: #f0f0fd;padding: 0 35px 20px;'><br> Hi<b style='color: #843534'> " . $freelancer->name . " " . $freelancer->family . ". </b><br>";
            $message .= "I have a project and i want to work with you. If you're interested, please visit the My Project ";
            $message .= "<a href='$url' target='_blank' class='btn btn-success'> View</a></div>";

            $message = auth()->user()->messages()->create([
                'message' => $message,
                'target_user_id' => $request->freelancerid
            ]);

            if ($message) {
                broadcast(new MessageSent($message->load('user')))->toOthers();
                $response = ['status' => 'Message Sent!'];
            }
        }

        return $response;
    }
}
