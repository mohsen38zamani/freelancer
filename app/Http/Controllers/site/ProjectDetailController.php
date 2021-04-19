<?php

namespace App\Http\Controllers\site;

use App\Bids_project;
use App\Freelancerinfo;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use App\Manage_project;
use App\Mile_stone;
use App\Payment_bill;
use App\Project;
use App\Roll_bill;
use App\User_profile;
use App\User_verification_items;
use hisorange\BrowserDetect\Exceptions\Exception;
use Illuminate\Http\Request;

class ProjectDetailController extends Controller
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

    public function detail($id)
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items']);
        }

        /* skill list */
        $item = array();
        $skill = \App\Skill::all();
        foreach ($skill as $key => $value) {
            $item[$value->skillid] = $value->name;
        }
        $function['block_field']['information']['skill'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => true);


        /* currency list */
        $item = array();
        $currency = \App\Currency::all();
        foreach ($currency as $key => $value) {
            $item[$value->currencyid] = $value->name;
        }
        $function['block_field']['information']['currency'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => false);

        /* advanceoption list */
        $item = array();
        $advanceoption = \App\Advanceoption::with('currency')->where([
            'enable' => 1,
            'currencyid' => 1,
            'use_in' => 'postProject'
        ])->get();

        $function['block_field']['information']['advanceoption'] = $advanceoption;
        $project = \App\Project::with('attachment', 'project_advanceoption', 'skill_requirment', 'wage')->where([
            'user_profileid' => $current_user->user_profileid,
            'projectid' => $id
        ])->firstOrFail();

        return view('site.employer.project_detail', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'current_user' => $current_user,
            'current_page_user' => $current_user,
            'project' => $project,
            'authenticatied' => true,
            'block_field' => $function['block_field']
        ));
    }

    public function requestProject($id)
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items', 'freelancerinfo']);
        }

        /* skill list */
        $item = array();
        $skill = \App\Skill::all();
        foreach ($skill as $key => $value) {
            $item[$value->skillid] = $value->name;
        }
        $function['block_field']['information']['skill'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => true);


        /* currency list */
        $item = array();
        $currency = \App\Currency::all();
        foreach ($currency as $key => $value) {
            $item[$value->currencyid] = $value->name;
        }
        $function['block_field']['information']['currency'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => false);

        /* advanceoption list */
        $item = array();
        $advanceoption = \App\Advanceoption::with('currency')->where([
            'enable' => 1,
            'currencyid' => 1,
            'use_in' => 'postProject'
        ])->get();

        $function['block_field']['information']['advanceoption'] = $advanceoption;
        $project = \App\Project::with('skill_requirment', 'wage')->where([
            'projectid' => $id
        ])->firstOrFail();
        $userProject = [];
        if ($project) {
            $userIdProject = User_profile::where('user_profileid', $project->user_profileid)->firstOrFail();

            if ($userIdProject->user_profileid) {
                $userProject = $this->controllerFunction->getcurrent_user($userIdProject->userid, ['user', 'country', 'user_verification_items']);
            }
        }

        //----- get skills project
        foreach ($project['skill_requirment'] as $list) {
            $skillProject[] = $list->skillid;
        }

        //----- get skills (current freelancer) and check exists in skill project request.
        $exists_skill_project = false;
        if ($current_user['freelancerinfo'] && $current_user['freelancerinfo']['skill_freelancer']) {
            foreach ($current_user['freelancerinfo']['skill_freelancer'] as $list) {
                $skillFreelancer[] = $list->skillid;
                if (in_array($list->skillid, $skillProject)) {
                    $exists_skill_project = true;
                    break;
                }
            }
        }

        //----check if current_user = user_project -> not allow request for project and redirect to page edit project.
        if ($current_user->user_profileid == $project->user_profileid) {
            return redirect('/project-detail/' . $id);
        }

        return view('site.project_request', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'userProject' => $userProject,
            'current_user' => $current_user,
            'project' => $project,
            'exists_skill_project' => $exists_skill_project,
            'authenticatied' => true,
            'block_field' => $function['block_field']
        ));
    }

    public function checkEmailVerify(Request $request)
    {
        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items', 'freelancerinfo']);
        }

        if ($current_user) {
            try {
                $result = User_verification_items::where([
                    'user_profileid' => $current_user['user_profileid'],
                    'email' => '1'
                ])->first();

                if ($result) {
                    return 1;
                } else {
                    return 0;
                }
            } catch (Exception $e) {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function saveSkillFreelancer(Request $request)
    {

        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), []);
        }

        $resultFInfo = [];
        $skillid = [];
        $resultFInfo;
        $counter = 0;
        //---- 1) insert user in table -> freelancerinfo
        if ($current_user['user_profileid']) {
            $resultFInfo = Freelancerinfo::firstOrCreate(['user_profileid' => $current_user['user_profileid']]);
        }
        //---- 2) save skill for freelancer.
        $skillid = explode(',', $request->array_skillFreelancer);
        if ($resultFInfo) {
            foreach ($skillid as $id) {
                if ($counter >= 20) break;

                $lv1skillid = \App\Skill::where('skillid', $id)->value('lv1skillid');
                //------------if not exists lv1skillid in table Skill -> continue.
                if (!$lv1skillid) continue;

                //-----save skill in Skill_freelancer.
                $result = \App\Skill_freelancer::firstOrCreate([
                    'freelancerinfoid' => $resultFInfo->freelancerinfoid,
                    'lv1skillid' => $lv1skillid,
                    'skillid' => $id
                ]);
                $counter++;
            }
        }

        return 1;
    }

    public function updateUserProfile(Request $request)
    {
        $arrayRequest = explode(",", substr($request->data, 0, -1));
        $arrayData = [];
        foreach ($arrayRequest as $list) {
            $data = explode(":", $list);
            $arrayData[$data[0]] = $data[1];
        }

        if (count($arrayData) > 0) {
            $current_user = array();
            if (Auth()->id()) {
                $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), []);
            }

            if ($current_user) {
                $result = User_profile::where('user_profileid', $current_user['user_profileid'])->update($arrayData);

                if ($result) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }

    }

    public function saveBidProject(Request $request)
    {
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), []);
        }

        $find_project = Project::find($request->projectid);
        //---- check project state is opened.
        if ($find_project && $find_project['state'] == 'opened') {
            if ($current_user) {
                //----- type -> hour.
                if ($request->type == "hour") {
                    $result = Bids_project::updateOrCreate([
                        'projectid' => $request->projectid,
                        'user_profileid' => $current_user['user_profileid']
                    ],
                        [
                            'projectid' => $request->projectid,
                            'user_profileid' => $current_user['user_profileid'],
                            'bid' => $request->Hourly_Rate,
                            'type' => $request->type,
                            'period_time' => $request->Weekly_Limit,
                            'describe' => $request->Describe_your_proposal,
                        ]
                    );

                    $price = (int)$request->Weekly_Limit * (int)$request->Hourly_Rate;
                    Mile_stone::where('bids_projectid', $result->bids_projectid)->delete();
                    $Mile_stone = new Mile_stone;
                    $Mile_stone->bids_projectid = $result->bids_projectid;
                    $Mile_stone->price = $price;
                    $Mile_stone->title = 'Milestone bid (1)';
                    $Mile_stone->save();

                    if ($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    //----- type -> project.
                    $result = Bids_project::updateOrCreate([
                        'projectid' => $request->projectid,
                        'user_profileid' => $current_user['user_profileid']
                    ],
                        [
                            'projectid' => $request->projectid,
                            'user_profileid' => $current_user['user_profileid'],
                            'bid' => $request->Hourly_Rate,
                            'type' => $request->type,
                            'period_time' => $request->Weekly_Limit,
                            'describe' => $request->Describe_your_proposal,
                        ]
                    );

                    Mile_stone::where('bids_projectid', $result->bids_projectid)->delete();
                    $dataPriceMilestone = explode(",", $request->dataPriceMilestone);
                    $dataTitleMilestone = explode(",", $request->dataTitleMilestone);
                    foreach ($dataPriceMilestone as $key => $listPrice) {
                        $Mile_stone = new Mile_stone;
                        $Mile_stone->bids_projectid = $result->bids_projectid;
                        $Mile_stone->price = $listPrice;
                        $Mile_stone->title = $dataTitleMilestone[$key];
                        $Mile_stone->save();
                    }

                    if ($result) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function proposal($id)
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items']);
        }

        $project = \App\Project::where([
            'projectid' => $id,
            'user_profileid' => $current_user->user_profileid
        ])->firstOrFail();

        return view('site.employer.project_proposal', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'current_user' => $current_user,
            'current_page_user' => $current_user,
            'project' => $project,
            'authenticatied' => true,
            'block_field' => $function['block_field']
        ));

    }

    public function proposalFreelancer($id)
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items', 'freelancerinfo']);
        }

        $project = \App\Project::where([
            'projectid' => $id
        ])->firstOrFail();

        if ($project) {
            $userIdProject = User_profile::where('user_profileid', $project->user_profileid)->pluck('userid');

            if ($userIdProject) {
                $userProject = $this->controllerFunction->getcurrent_user($userIdProject, ['user', 'country', 'user_verification_items']);
            }
        }

        return view('site.freelancer_proposal', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'userProject' => $userProject,
            'current_user' => $current_user,
            'project' => $project,
            'authenticatied' => true,
            'block_field' => $function['block_field']
        ));

    }

    public function list_proposal(Request $request)
    {
        $result = Bids_project::with('user_profile', 'mile_stone','project')->where('projectid', $request->projectid)->get();
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function delete_proposal(Request $request)
    {
        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items', 'freelancerinfo']);
        }

        Mile_stone::where('bids_projectid', $request->bid_id)->delete();
        $result = Bids_project::find($request->bid_id);
        if ($result) {
            if ($request->roll == 3) {
                $result->retract_by = 'freelancer';
            } else {
                $result->retract_by = 'employer';
            }
            $result->save();
            $result->delete();
            return 1;
        } else {
            return 0;
        }
    }

    public function detail_bid_freelancer(Request $request)
    {
        //----- get bid_id is payment.
        $roll_bill_id = Roll_bill:: where([
            'target' => 'bids',
            'customid_lv1' => $request->bid_id
        ])->pluck('customid_lv2');

        //----- get bid and mile_stone.
        $bids_project = Bids_project::with(['mile_stone' => function ($query) use ($roll_bill_id) {
            $query->whereNotIn('mile_stoneid', $roll_bill_id);
        }, 'user_profile','project'])
            ->where('bids_projectid', $request->bid_id)
            ->first();

        if ($bids_project) {
            return $bids_project;
        } else {
            return 0;
        }
    }

    public function payment_milestone(Request $request)
    {
        $milestone_finally = array();
        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items', 'freelancerinfo']);
        }

        //---- get array milestonid.
        $milestonid = explode(',', $request->milestonid);

        //----get bids_projectid
        $bids_projectid = Mile_stone::whereIn('mile_stoneid', $milestonid)->value('bids_projectid');

        if ($request->bid_id = $bids_projectid) {
            //----- get bid_id is payment.
            $roll_bill_id = Roll_bill:: where([
                'target' => 'bids',
                'customid_lv1' => $bids_projectid
            ])->pluck('customid_lv2');

            //----- get id not payment.
            $mailston_self = Mile_stone::where('bids_projectid', $request->bid_id)
                ->whereNotIn('mile_stoneid', $roll_bill_id)->get();

            $id_mailston_self = Mile_stone::where('bids_projectid', $request->bid_id)
                ->whereNotIn('mile_stoneid', $roll_bill_id)->pluck('mile_stoneid');

            $id_mailston_self = json_decode($id_mailston_self);
            //-------check data wrong pass in server for payment.
            foreach ($milestonid as $list) {
                if (!in_array($list, $id_mailston_self)) {
                    return false;
                    break;
                } else {
                    $milestone_finally[] = $mailston_self[array_search($list, $id_mailston_self)];
                }
            }

            //------send to payPal. ==> price : $price.
            $name = '';
            $currency = $request->currency;
            $price = 0;
            foreach ($milestone_finally as $key => $value) {
                $price += $value->price;
                $name .= 'mile_stoneid:' . $value->mile_stoneid . '|bids_projectid:' . $value->bids_projectid . ',';
            }
            $response = array();
            $response['name'] = $name;
            $response['price'] = $price;
            $response['currency'] = $currency;
            return $response;
        } else{
            return false;
        }
    }

    public function payment_accepted($request)
    {
        $bid_id = null;
        $payment_bill = null;
        $projectid = null;
        $transaction_name = explode(",",$request);
        //---- create in roll_bill & Payment_bill.
        foreach ($transaction_name as $list){
            $array_milestonid_bidid = explode("|",$transaction_name[0]);
            $array_bid_id = explode(":",$array_milestonid_bidid[1]);
            $array_mileston_id = explode(":",$array_milestonid_bidid[0]);
            $roll_billid = Roll_bill::firstOrCreate([
                'target' => 'bids',
                'customid_lv1' => $array_bid_id[1],
                'customid_lv2' => $array_mileston_id[1]
            ]);

            $price_milestone = Mile_stone::find($array_mileston_id[1])->value('price');

            $payment_bill = Payment_bill::firstOrCreate([
                'roll_billid' => $roll_billid['roll_billid'],
                'price' => $price_milestone,
                'state_pay' => 1
            ]);

            $projectid = Bids_project::find($array_bid_id[1])->value('projectid');
            //------check if payment is true -> project start.
            if ($payment_bill['state_pay'] == 1) {
                $Manage_project = Manage_project::firstOrCreate([
                    'projectid' => $projectid,
                    'bids_projectid' => $array_bid_id[1]
                ], [
                    'projectid' => $projectid,
                    'bids_projectid' => $array_bid_id[1],
                    'start_date' => date('Y-m-d H:i:s'),
                    'status_project' => 'working'
                ]);

                //----- change state project.
                $project = Project::find($projectid);
                $project->state = 'closed';
                $project->save();

                if ($Manage_project) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function edit($id)
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items']);
        }

        /* skill list */
        $item = array();
        $skill = \App\Skill::all();
        foreach ($skill as $key => $value) {
            $item[$value->skillid] = $value->name;
        }
        $function['block_field']['information']['skill'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => true);


        /* currency list */
        $item = array();
        $currency = \App\Currency::all();
        foreach ($currency as $key => $value) {
            $item[$value->currencyid] = $value->name;
        }
        $function['block_field']['information']['currency'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => false);

        /* advanceoption list */
        $item = array();
        $advanceoption = \App\Advanceoption::with('currency')->where([
            'enable' => 1,
            'currencyid' => 1,
            'use_in' => 'postProject'
        ])->get();

        $function['block_field']['information']['advanceoption'] = $advanceoption;
        $project = \App\Project::with('attachment', 'project_advanceoption', 'skill_requirment', 'wage')->where([
            'user_profileid' => $current_user->user_profileid,
            'projectid' => $id
        ])->firstOrFail();

        return view('site.employer.project_detail', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'current_user' => $current_user,
            'current_page_user' => $current_user,
            'project' => $project,
            'authenticatied' => true,
            'block_field' => $function['block_field'],
        ));
    }

    public function save(Request $request)
    {
        $_request = $request->all();
        unset($_request['_token'], $_request['skill']);
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $_request['user_profileid'] = $current_user['user_profileid'];
        $this->module['moduleblockfield']['information']['user_profileid'] = [
            "type" => "text",
            "required" => true,
            "value" => null,
            "readonly" => false,
            "placeholder" => "",
        ];

        $response = $this->controllerFunction->save($this->module, new \Illuminate\Http\Request($_request, $_request, [], [], []));

        /* skill list */
        $pld_selected_item = array();
        $selected_skill = \App\Skill_requirment::where('projectid', $response->projectid)->get();

        foreach ($selected_skill as $value) {
            $pld_selected_item[] = $value->skill_requirmentid;
        }

        $skill_array_post = explode(',', $request->skill);
        foreach ($skill_array_post as $item) {

            $record = new \App\Skill_requirment();
            $record->projectid = $response->projectid;
            $record->skillid = $item;
            $record->save();
        }
        \App\Skill_requirment::whereIn('skill_requirmentid', $pld_selected_item)->where('projectid', $response->projectid)->delete();
        return 1;
    }

    public function save_advanceOption(Request $request)
    {
        $advanceOption_selected = explode(',', $request->advanceOption);
        //-----save advanceoption
        foreach ($advanceOption_selected as $item) {
            \App\Project_advanceoption::updateOrCreate([
                'projectid' => $request->projectid,
                'advanceoptionid' => $item
            ],
                [
                    'projectid' => $request->projectid,
                    'advanceoptionid' => $item
                ]
            );

        }
        return 1;
    }

    public function delete(Request $request)
    {
        $function = $this->controllerFunction->delete($this->module, $request->id);
        $selected_skill = \App\Skill_requirment::where('projectid', $request->id)->delete();
        $selected_skill = \App\Project_advanceoption::where('projectid', $request->id)->delete();
        return 1;
    }

    public function close(Request $request)
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());

        $request = \App\Project::where([
            'projectid' => $request['id'],
            'user_profileid' => $current_user['user_profileid']
        ])->update(['state' => 'closed']);

        return $request;
    }

    public function deleteFile(Request $request)
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
//        $attachment  = \App\Attachment::with('project')->where([
//            'attachmentid'=> $request->id ,
//            'user_profileid'=> $current_user['user_profileid']
//        ])->firstOrFail();
        $user_profileid = $current_user['user_profileid'];

        $attachment = \App\Attachment::with('project')->whereHas('project', function ($query) use ($user_profileid) {
            $query->where('user_profileid', $user_profileid);
        })->where('attachmentid', $request->id)->firstOrFail();

        if ($attachment) {
            \App\Attachment::where('attachmentid', $request->id)->delete();
            return 1;
        } else {
            abort(404);
        }
    }

    public function file($id)
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country', 'user_verification_items']);
        }


        $project = \App\Project::with('attachment')->where([
            'user_profileid' => $current_user->user_profileid,
            'projectid' => $id
        ])->firstOrFail();

        return view('site.employer.project_file', array(
            'footer' => \App\Footermenu::with('Footeritem')->get(),
            'socialmedialist' => \App\Socialmedialist::all(),
            'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
            'current_user' => $current_user,
            'current_page_user' => $current_user,
            'project' => $project,
            'authenticatied' => true,
            'block_field' => $function['block_field']
        ));
    }
}
