<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use Illuminate\Http\Request;

class BrowsProjectController extends Controller
{
    public $module;
    protected $controllerFunction;

    public function __construct()
    {
        $this->middleware(['auth', 'twostep'], ['except' => ['profile']]);
        /* module details */
        $this->module['modulename'] = 'project';
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
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country']);
        }

        $priceProject['min'] = ceil(\App\Wage::where('type', 'project')->min('minbudget'));
        $priceProject['max'] = ceil(\App\Wage::where('type', 'project')->max('maxbudget'));

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

        return view('site.browsProject', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'current_user' => $current_user,
            'current_page_user' => $current_user,
            'priceProject' => $priceProject,
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
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country']);
        }

        $arrayWhere = [];
        $arrayWhere['state'] = 'opened';
        $flag = false;

        //------ check type project is set.
        if (isset($request['typePrice']) && $request['typePrice'] != 'null') {
            if ($request['typePrice'] == 0) {
                $arrayWhere['type'] = 'all';
            } elseif ($request['typePrice'] == 1) {
                $arrayWhere['type'] = 'project';
            } elseif ($request['typePrice'] == 2) {
                $arrayWhere['type'] = 'hour';
            }
        }

        //------ check price (hour and project) is set.
        if ((isset($request['priceFixed']) && $request['priceFixed'] != null) && (isset($request['priceHourly']) && $request['priceHourly'] != null) && (isset($request['typePrice']) && $request['typePrice'] == 0)) {
            $flag = true;
            $priceFixed = explode(',', $request['priceFixed']);
            $arrayWhere['minbudget_f'] = $priceFixed[0];
            $arrayWhere['maxbudget_f'] = $priceFixed[1];

            $priceHourly = explode(',', $request['priceHourly']);
            $arrayWhere['minbudget_h'] = $priceHourly[0];
            $arrayWhere['maxbudget_h'] = $priceHourly[1];
        } elseif ((isset($request['priceFixed']) && $request['priceFixed'] != null) && (isset($request['typePrice']) && $request['typePrice'] == 1)) {
            //------ check priceFixed project is set.
            $flag = false;
            $priceFixed = explode(',', $request['priceFixed']);
            $arrayWhere['minbudget'] = $priceFixed[0];
            $arrayWhere['maxbudget'] = $priceFixed[1];
        } elseif ((isset($request['priceHourly']) && $request['priceHourly'] != null) && (isset($request['typePrice']) && $request['typePrice'] == 2)) {
            //------ check priceHourly project is set.
            $flag = false;
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

        if ($flag) {
            //-----------check post value price min and max : if not exist get min and max from table wage.
            //-----condition price type -> project.
            if (isset($arrayWhere['minbudget_f']) && isset($arrayWhere['maxbudget_f'])) {
                $min_priceFixed = $arrayWhere['minbudget_f'];
                $max_priceFixed = $arrayWhere['maxbudget_f'];
                unset($arrayWhere['type'], $arrayWhere['minbudget_f'], $arrayWhere['maxbudget_f']);
            } else {
                $min_priceFixed = ceil(\App\Wage::where('type', 'project')->min('minbudget'));
                $max_priceFixed = ceil(\App\Wage::where('type', 'project')->max('maxbudget'));
                unset($arrayWhere['type'], $arrayWhere['minbudget_f'], $arrayWhere['maxbudget_f']);
            }
            //-----condition price type -> hour.
            if (isset($arrayWhere['minbudget_h']) && isset($arrayWhere['maxbudget_h'])) {
                $min_pricehourly = $arrayWhere['minbudget_h'];
                $max_pricehourly = $arrayWhere['maxbudget_h'];
                unset($arrayWhere['type'], $arrayWhere['minbudget_h'], $arrayWhere['maxbudget_h']);
            } else {
                $min_pricehourly = ceil(\App\Wage::where('type', 'hour')->min('minbudget'));
                $max_pricehourly = ceil(\App\Wage::where('type', 'hour')->max('maxbudget'));
                unset($arrayWhere['type'], $arrayWhere['minbudget_h'], $arrayWhere['maxbudget_h']);
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
            //--------select for type -> hour
            $sql1 = \App\Project::with("project_advanceoption", "skill_requirment", "wage", "user_profile")
                ->whereHas("wage", function ($query) use ($min_priceFixed, $max_priceFixed) {
                    $query->where("type", 'project')
                        ->where("minbudget", ">=", $min_priceFixed)
                        ->where("maxbudget", "<=", $max_priceFixed);
                })
                ->whereHas("skill_requirment", function ($query) use ($skillid) {
                    $query->whereIn("skillid", $skillid);
                })
                ->whereHas("user_profile", function ($query) use ($countryid) {
                    $query->whereIn("countryid", $countryid);
                })->where($arrayWhere);

            //--------select for type -> project
            $sql2 = \App\Project::with("project_advanceoption", "skill_requirment", "wage", "user_profile")
                ->whereHas("wage", function ($query) use ($min_pricehourly, $max_pricehourly) {
                    $query->where("type", 'hour')
                        ->where("minbudget", ">=", $min_pricehourly)
                        ->where("maxbudget", "<=", $max_pricehourly);
                })
                ->whereHas("skill_requirment", function ($query) use ($skillid) {
                    $query->whereIn("skillid", $skillid);
                })
                ->whereHas("user_profile", function ($query) use ($countryid) {
                    $query->whereIn("countryid", $countryid);
                })->where($arrayWhere);

            //------ check textSearch is set.
            if (isset($request['textSearch']) && $request['textSearch']) {
                $word = '%' . $request['textSearch'] . '%';
                $sql1->where(function($query) use ($word) {
                    $query->where('name', 'LIKE', $word)
                        ->orWhere('description', 'LIKE', $word)
                        ->toSql();
                });
                $sql2->where(function($query) use ($word) {
                    $query->where('name', 'LIKE', $word)
                        ->orWhere('description', 'LIKE', $word)
                        ->toSql();
                });
            }
            $result1 = $sql1->get();
            $result2 = $sql2->get();
            //--------merge 2 (result1[project],result2[hour]) -> result
            $result = ($result1->merge($result2));
        } else {
            //-----------check post value price min and max : if not exist get min and max from table wage.
            if (isset($arrayWhere['type']) && isset($arrayWhere['minbudget']) && isset($arrayWhere['maxbudget'])) {
                $type = $arrayWhere['type'];
                $minbudget = $arrayWhere['minbudget'];
                $maxbudget = $arrayWhere['maxbudget'];
                unset($arrayWhere['type'], $arrayWhere['minbudget'], $arrayWhere['maxbudget']);
            } else {
                $minbudget = ceil(\App\Wage::where('type', $arrayWhere['type'])->min('minbudget'));
                $maxbudget = ceil(\App\Wage::where('type', $arrayWhere['type'])->max('maxbudget'));
                unset($arrayWhere['type'], $arrayWhere['minbudget'], $arrayWhere['maxbudget']);
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

            $sql = \App\Project::with("project_advanceoption", "skill_requirment", "wage", "user_profile")
                ->whereHas("wage", function ($query) use ($type, $minbudget, $maxbudget) {
                    $query->where("type", $type)
                        ->where("minbudget", ">=", $minbudget)
                        ->where("maxbudget", "<=", $maxbudget);
                })
                ->whereHas("skill_requirment", function ($query) use ($skillid) {
                    $query->whereIn("skillid", $skillid);
                })
                ->whereHas("user_profile", function ($query) use ($countryid) {
                    $query->whereIn("countryid", $countryid);
                })->where($arrayWhere);

            //------ check textSearch is set.
            if (isset($request['textSearch']) && $request['textSearch']) {
                $word = '%' . $request['textSearch'] . '%';
                $sql->where(function($query) use ($word) {
                    $query->where('name', 'LIKE', $word)
                        ->orWhere('description', 'LIKE', $word)
                        ->toSql();
                });
            }
            $result = $sql->get();
        }
        return $result;
    }
}
