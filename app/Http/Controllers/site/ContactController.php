<?php

namespace App\Http\Controllers\site;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use Illuminate\Http\Request;

class ContactController extends Controller
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
        /* module details */
        $this->module['modulename'] = 'contact_us';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('lv1skill'=> array('name'));//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array('lv1skill');// select parent for show in edit view
        $this->module['modulechild'] = array(''); //array('module name' => array('module show fields'))

        /* Auto fill -> no change sub line */
        $this->controllerFunction = new PublicControllerFunction();
        $moduleinfo = $this->controllerFunction->getmoduleinfo($this->module['modulename']);
        $this->module['modulelabel'] = $moduleinfo['modulelabel'];
        $this->module['modulemodel'] = $moduleinfo['modulemodel']; // create model name
        $this->module['moduleprimarykey'] = $moduleinfo['moduleprimarykey'];
        $this->module['moduletabid'] = $moduleinfo['moduletabid'];
        $this->module['moduleblockfield'] = $this->controllerFunction->getmoduleblockfield($moduleinfo['moduletabid']);
    }
//
//    public function show()
//    {
//        return view('site.contact', array(
//                'footer' => \App\Footermenu::with('Footeritem')->get(),
//                'lv1skill' => \App\Lv1skill::all()
//            )
//        );
//    }
    /**
     * Show the application module List.
     *
     * @return /view/panel/list
     */
    public function list()
    {
        return false;
    }

    /**
     * Show the application New for module.
     *
     * @return /view/panel/edit
     *
     * input type  =>  text,number,password,select,email,tel,hidden,button,submit,reset,checkbox,radio,file,color,date,url,range,time,textarea
     */
    public function new(Request $request)
    {
        $result=null;
        if (isset($request->result)) $result =$request->result;
        $action = '/contact/new';
        $function = $this->controllerFunction->new($this->module);
        return view(
            '/site/contact',
            array(
                'block_field' => $function['block_field'],
                'action' => $action,
                'permission' => true,
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'current_user' => array(),
                'result' => $result,
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
            "firstname" => "required|string",
            "lastname" => "required|string",
            "email" => "required|string",
            "message" => "required|string",
        );

        $this->validate($request, $validationparams);
        $_request = $request->all();
        unset($_request['_token']);
        $response = $this->controllerFunction->store($this->module, new \Illuminate\Http\Request($_request, $_request, [], [],[]));

        return redirect()->route('contact', ['result' => 200]);
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

}
