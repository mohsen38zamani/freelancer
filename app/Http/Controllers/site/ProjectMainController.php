<?php


namespace App\Http\Controllers\site;

use App\Bids_project;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use App\Manage_project;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectMainController extends Controller
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

        $project = \App\Project::with('attachment','project_advanceoption','skill_requirment','wage')->where([
            'user_profileid'=> $current_user->user_profileid,
            'state'=> 'opened'
        ])->get();

        return view('site.employer.project_main', array(
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

    public function project_ending(Request $request)
    {
        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country']);
        }

        if ($request->id && $current_user){
            $manage_project = Manage_project::find($request->id);

           if ($manage_project){
               $project = Project::where([
                   'projectid' => $manage_project->projectid,
                   'user_profileid' => $current_user->user_profileid
               ])->first();

               if ($project){
                   $manage_project->status_project = 'ending';
                   $manage_project->save();
                   return 1;
               }
           }
        }
        return 0;
    }

    public function showPast()
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country']);
        }

        $project = \App\Project::with('attachment','project_advanceoption','skill_requirment','wage')->where([
            'user_profileid'=> $current_user->user_profileid,
            'state'=> 'closed'
        ])->get();

        return $project;
    }

    public function showOpen()
    {
        $function = $this->controllerFunction->new($this->module);

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country']);
        }

        $project = \App\Project::with('attachment','project_advanceoption','skill_requirment','wage')->where([
            'user_profileid'=> $current_user->user_profileid,
            'state'=> 'opened'
        ])->get();

        return $project;
    }

    public function getProjectList(Request $request)
    {
        $project=null;

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id(), ['user', 'country']);
        }

        if ($request->type == "project" && $request->typeTab == "working")
        {
            if($request->text != null && $request->text != "") {
                $status_project = "working";
                $project = \App\Project::with('attachment', 'project_advanceoption', 'skill_requirment', 'wage', 'manage_project')->where([
                    'user_profileid' => $current_user->user_profileid,
                    'name' => $request->text
                ])
                    ->whereHas('manage_project', function ($query) use ($status_project) {
                        $query->where('status_project', $status_project);
                    })->get();
            }
            else{
                $status_project = "working";
                $project = \App\Project::with('attachment', 'project_advanceoption', 'skill_requirment', 'wage', 'manage_project')
                    ->where([
                        'user_profileid' => $current_user->user_profileid
                    ])
                    ->whereHas('manage_project', function ($query) use ($status_project) {
                        $query->where('status_project', $status_project);
                    })->get();
            }
            return $project;
        }
        else if($request->type == "project" && ($request->typeTab == "opened" || $request->typeTab == "closed")){
            if($request->text != null && $request->text != ""){
                $project = \App\Project::with('attachment','project_advanceoption','skill_requirment','wage')->where([
                    'user_profileid'=> $current_user->user_profileid,
                    'name'=> $request->text,
                    'state'=> $request->typeTab
                ])->get();
            }
            else{
                $project = \App\Project::with('attachment','project_advanceoption','skill_requirment','wage')->where([
                    'user_profileid'=> $current_user->user_profileid,
                    'state'=> $request->typeTab
                ])->get();
            }
            return $project;
        }
        else if($request->type == "freelancer" && $request->typeTab == "working"){
            $status_project = "working";
            if($request->text != null && $request->text != "") {
                $text = $request->text;
                $project = Bids_project::with('project','manage_project')
                    ->where('user_profileid', $current_user->user_profileid)
                    ->whereNull('retract_by')
                    ->whereHas('manage_project', function ($query) use ($status_project) {
                        $query->where('status_project', $status_project);
                    })
                    ->whereHas('project', function ($query) use ($text) {
                        $query->where('name', $text);
                    })->get();
            }else{
                $project = Bids_project::with('project','manage_project')
                    ->where('user_profileid', $current_user->user_profileid)
                    ->whereNull('retract_by')
                    ->whereHas('manage_project', function ($query) use ($status_project) {
                        $query->where('status_project', $status_project);
                    })->get();
            }
            return $project;
        }
        else if($request->type == "freelancer" && $request->typeTab == "ending"){
            $status_project = "ending";
            if($request->text != null && $request->text != "") {
                $text = $request->text;
                $project = Bids_project::with('project','manage_project')
                    ->where('user_profileid',$current_user->user_profileid)
                    ->whereNull('retract_by')
                    ->whereHas('manage_project', function ($query) use ($status_project) {
                        $query->where('status_project', $status_project);
                    })
                    ->whereHas('project', function ($query) use ($text) {
                        $query->where('name', $text);
                    })->get();
            }
            else{
                $project = Bids_project::with('project','manage_project')
                    ->where('user_profileid',$current_user->user_profileid)
                    ->whereNull('retract_by')
                    ->whereHas('manage_project', function ($query) use ($status_project) {
                        $query->where('status_project', $status_project);
                    })->get();
            }
            return $project;
        }
        else if($request->type == "freelancer" && $request->typeTab == "bid"){
            if($request->text != null && $request->text != "") {
                $text = $request->text;
                $project = Bids_project::with('project')
                    ->where('user_profileid', $current_user->user_profileid)
                    ->whereNull('retract_by')
                    ->whereHas('project', function ($query) use ($text) {
                        $query->where('name', $text);
                    })
                    ->get();
            }
            else{
                $project = Bids_project::with('project')
                    ->where('user_profileid', $current_user->user_profileid)
                    ->whereNull('retract_by')
                    ->get();
            }
            return $project;
        }
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
}
