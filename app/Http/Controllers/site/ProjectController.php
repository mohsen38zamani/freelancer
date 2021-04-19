<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $this->middleware(['auth', 'twostep']);

        /* module details */
        $this->module['modulename'] = 'project';
        $this->module['moduleattachment'] = 2; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('wage' => array('name'), 'assistant_setting' => array('price'));//array('module name' => array('module show fields'))
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
    public function list()
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $function = \App\Project::with('attachment')->where('user_profileid', $current_user->user_profileid)->get();

        return view(
            '/site/' . $this->module['modulename'] . '/list',
            array(
                'project' => $function,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid']),
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'current_user' => $current_user,
                'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
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
        $action = '/postProject/new';
        $function = $this->controllerFunction->new($this->module);

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
        return view(
            '/site/employer/PostProject',
            array(
                'block_field' => $function['block_field'],
                'action' => $action,
                'socialmedialist' => \App\Socialmedialist::all(),
                'permission' => $this->controllerFunction->permission($this->module['moduletabid']),
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'current_user' => $current_user,
                'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
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
        $validationparams = array(
          "name" => "required|string",
        );
        $this->validate($request, $validationparams);

        $_request = $request->all();
        $advanceoption_id = [];
        unset($_request['_token'], $_request['skill'], $_request['attachment']);
        foreach ($_request as $key => $value) {
            if (strpos($key, 'ad_') !== false) {
                unset($_request[$key]);
                $stringAdvanceoption = explode('ad_',$key);
                $advanceoption_id[]= substr($stringAdvanceoption[1],0,stripos($stringAdvanceoption[1],"|"));
            }
        }
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

        //------save skill.
        foreach ($request->skill as $item) {
            $record = new \App\Skill_requirment();
            $record->projectid = $response->projectid;
            $record->skillid = $item;
            $record->save();
        }

        //-----save advanceoption
        if (count($advanceoption_id) > 0) {
            foreach ($advanceoption_id as $item) {
                $record = new \App\Project_advanceoption();
                $record->advanceoptionid = $item;
                $record->projectid = $response->projectid;
                $record->save();
            }
        }
        return redirect('/project-detail/'.$response->projectid);
    }

    /**
     * Show the application record of module edit view.
     * @param Request $id
     * @return /view/panel/edit
     */
    public function edit($id)
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $action = '/postProject/edit';
        $function = $this->controllerFunction->edit($this->module, $id, "\App\Http\Controllers\site\\", $current_user->user_profileid);

        /* skill list */
        $selected_item = array();
        $selected_skill = \App\Skill_requirment::where('projectid', $id)->get();
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
            '/site/employer/postProject',
            array(
                'block_field' => $function['block_field'],
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid']),
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'current_user' => $current_user,
                'chat' => \App\Message::where('target_user_id', $current_user->userid)->where('visit', 0)->count(),
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
        $response = $this->controllerFunction->save($this->module, new \Illuminate\Http\Request($_request, $_request, [], [], $attachment));

        /* skill list */
        $selected_item = array();
        $selected_skill = \App\Skill_requirment::where('projectid', $response->projectid)->get();
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
            $record = new \App\Skill_requirment();
            $record->projectid = $response->projectid;
            $record->skillid = $item;
            $record->save();
        }
        \App\Skill_requirment::whereIn('skillid', $selected_item)->where('projectid', $response->projectid)->delete();
        return redirect('/profile');
    }

    /**
     * Delete a exist record of module.
     *
     * @param Request $ids
     * @return $Response message in view
     */
    public function delete($ids)
    {
        $function = $this->controllerFunction->delete($this->module, $ids);
        $selected_skill = \App\Skill_requirment::where('projectid', $ids)->delete();
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

    public function getWage(Request $request)
    {
        //-------get wage.
        $wage = \App\Wage:: with('currency')->where([
            'currencyid' => $request->id,
            'type' => $request->type
        ])->get();

        //------------get assistant_setting.
        $assitant_setting = \App\Assistant_setting::with('currency')->where('currencyid', $request->id)->firstOrFail();

        $advancedOption = $advanceoption = \App\Advanceoption::with('currency')->where([
            'enable' => 1,
            'currencyid' => $request->id,
            'use_in' => 'postProject'
        ])->get();

        return array($wage, $assitant_setting, $advancedOption);
    }
}
