<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use Illuminate\Http\Request;

class PortfolioController extends Controller
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
        $this->middleware(['auth', 'twostep'], ['except' => ['view', 'list']]);

        /* module details */
        $this->module['modulename'] = 'portfolio';
        $this->module['moduleattachment'] = 2; // 0 = false, 1= single, 2 = multi
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

    /**
     * Show the application module List.
     *
     * @return /view/panel/list
     */
    public function list($username)
    {
        if (!$username) abort(404);
        $current_page_user = \App\User_profile::with(['user', 'country', 'attachment', 'freelancerinfo', 'education', 'job_experience', 'qualification', 'publication'])->where('username', $username)->first();
        if (!$current_page_user) abort(404);
        $authenticatied = false;

        /* check this user profile owner */
        $current_user = array();
        if (Auth()->id()) {
            $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
            if ($current_user->user_profileid == $current_page_user->user_profileid) $authenticatied = true;
        }
        $function = \App\Portfolio::with('attachment')->where('user_profileid', $current_page_user->user_profileid)->get();

        return view(
            '/site/' . $this->module['modulename'] . '/list',
            array(
                'portfolio' => $function,
                'permission' => true,
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'chat' => \App\Message::where('target_user_id', $current_user->userid ?? false)->where('visit', 0)->count(),
                'current_user' => $current_user ?? false,
                'current_page_user' => $current_page_user,
                'authenticatied' => $authenticatied,
            )
        );
    }

    /**
     * Show the application New for module.
     *
     * @return /view/panel/edit
     *
     * input type  =>  text,number,password,select,email,tel,hidden,button,submit,reset,checkbox,radio,file,color,date,url,range,time,textarea
     */
    public function new()
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $action = '/' . $this->module['modulename'] . '/new';
        $function = $this->controllerFunction->new($this->module);

        /* skill list */
        $item = array();
        $skill = \App\Skill::all();
        foreach ($skill as $key => $value) {
            $item[$value->skillid] = $value->name;
        }
        $function['block_field']['information']['skill'] = array('type' => 'select', 'required' => false, 'value' => array(), 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => true);

        return view(
            '/site/' . $this->module['modulename'] . '/new',
            array(
                'block_field' => $function['block_field'],
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid']),
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
                'current_user' => $current_user,
                'current_page_user' => $current_user,
            )
        );
    }

    /**
     * Store a new record for module.
     *
     * @param Request $request
     * @return Response message in view
     */
    public function store(Request $request)
    {
        $validationparams = $this->controllerFunction->setfieldvalidation($this->module, $request, "\App\Http\Controllers\site\\");
        $this->validate($request, $validationparams);

        $_request = $request->all();
        unset($_request['_token'], $_request['skill'], $_request['attachment']);
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $_request['user_profileid'] = $current_user['user_profileid'];
        $this->module['moduleblockfield']['information']['user_profileid'] = [
            "type" => "text",
            "required" => true,
            "value" => null,
            "readonly" => false,
            "placeholder" => "",
        ];
        $attachment = ($request->attachment) ? array('attachment' => $request->attachment) : [];
        $response = $this->controllerFunction->store($this->module, new \Illuminate\Http\Request($_request, $_request, [], [], $attachment));

        foreach ($request->skill as $item) {
            $record = new \App\Portfolio_skill();
            $record->portfolioid = $response->portfolioid;
            $record->skillid = $item;
            $record->save();
        }
        return redirect('/profile');
    }

    /**
     * Show the application record of module edit view.
     * @param Request $id
     * @return /view/panel/edit
     */
    public function edit($id)
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $action = '/' . $this->module['modulename'] . '/edit';
        $function = $this->controllerFunction->edit($this->module, $id, "\App\Http\Controllers\site\\", $current_user->user_profileid);

        /* skill list */
        $selected_item = array();
        $selected_skill = \App\Portfolio_skill::where('portfolioid', $id)->get();
        foreach ($selected_skill as $value) {
            $selected_item[] = $value->skillid;
        }
        $item = array();
        $skill = \App\Skill::all();
        foreach ($skill as $value) {
            $item[$value->skillid] = $value->name;
        }
        $function['block_field']['information']['skill'] = array('type' => 'select', 'required' => false, 'value' => $selected_item, 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => true);

        return view(
            '/site/' . $this->module['modulename'] . '/new',
            array(
                'block_field' => $function['block_field'],
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid']),
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
                'current_user' => $current_user,
                'current_page_user' => $current_user,
            )
        );
    }

    /**
     * save a edited record of module.
     *
     * @param Request $request
     * @return $Response message in view
     */
    public function save(Request $request)
    {
        $validationparams = $this->controllerFunction->setfieldvalidation($this->module, $request, "\App\Http\Controllers\site\\");
        foreach ($this->module['moduleparentseqrel'] as $item) {
            if (in_array($item, $this->module['moduleshowparentview'])) continue;
            unset($validationparams[$item]);
        }
        $this->validate($request, $validationparams);

        $_request = $request->all();
        unset($_request['_token'], $_request['skill'], $_request['attachment']);
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $_request['user_profileid'] = $current_user['user_profileid'];
        $this->module['moduleblockfield']['information']['user_profileid'] = [
            "type" => "text",
            "required" => true,
            "value" => null,
            "readonly" => false,
            "placeholder" => "",
        ];
        $attachment = ($request->attachment) ? array('attachment' => $request->attachment) : [];
        $response = $this->controllerFunction->save($this->module, new \Illuminate\Http\Request($_request, $_request, [], [], $attachment), $current_user->user_profileid);

        /* skill list */
        $selected_item = array();
        $selected_skill = \App\Portfolio_skill::where('portfolioid', $response->portfolioid)->get();
        foreach ($selected_skill as $value) {
            $selected_item[] = $value->skillid;
        }
        foreach ($request->skill as $item) {
            if (in_array($item, $selected_item)) {
                if (($key = array_search($item, $selected_item)) !== false) {
                    unset($selected_item[$key]);
                }
                continue;
            }
            $record = new \App\Portfolio_skill();
            $record->portfolioid = $response->portfolioid;
            $record->skillid = $item;
            $record->save();
        }
        \App\Portfolio_skill::whereIn('skillid', $selected_item)->where('portfolioid', $response->portfolioid)->delete();
        return redirect("/portfolio/$current_user->username/list");
    }

    /**
     * Show the application record of module edit view.
     * @param Request $id
     * @return /view/panel/edit
     */
    public function view($id)
    {
        $user_profileid = \App\Portfolio::where('portfolioid', $id)->value('user_profileid') ?? abort(404);
        $current_page_user = \App\User_profile::with(['user', 'country', 'attachment'])->where('user_profileid', $user_profileid)->first();
        if (!$current_page_user) abort(404);
        $current_user = array();
        if (Auth()->id()) $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());

        $function = $this->controllerFunction->edit($this->module, $id, "\App\Http\Controllers\site\\");

        /* skill list */
        $selected_item = array();
        $selected_skill = \App\Portfolio_skill::where('portfolioid', $id)->get();
        foreach ($selected_skill as $value) {
            $selected_item[] = $value->skillid;
        }
        $item = array();
        $skill = \App\Skill::all();
        foreach ($skill as $value) {
            $item[$value->skillid] = $value->name;
        }
        $function['block_field']['information']['skill'] = array('type' => 'select', 'required' => false, 'value' => $selected_item, 'readonly' => false, 'class' => '', 'data' => '', 'option' => $item, 'translate' => false, 'multiple' => true);

        return view(
            '/site/' . $this->module['modulename'] . '/view',
            array(
                'block_field' => $function['block_field'],
                'permission' => true,
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'chat' => \App\Message::where('target_user_id', $current_user->userid ?? false)->where('visit', 0)->count(),
                'current_page_user' => $current_page_user,
                'current_user' => $current_user ?? false,
            )
        );
    }

    /**
     * Delete a exist record of module.
     *
     * @param Request $ids
     * @return $Response message in view
     */
    public function delete($ids)
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $function = $this->controllerFunction->delete($this->module, $ids, $current_user->user_profileid);
        $selected_skill = \App\Portfolio_skill::where('portfolioid', $ids)->delete();
        return redirect('/profile');
    }

    /**
     * Delete a exist attachment.
     *
     * @param Request $request
     * @return Response
     */
    public function deleteattachment(Request $request)
    {
        $result = 'ERROR 404';
        $function = $this->controllerFunction->deleteattachment($request->id);
        if ($function) $result = 'OK';
        return $result;
    }
}
