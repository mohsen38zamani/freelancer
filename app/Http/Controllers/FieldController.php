<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class FieldController extends Controller
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
        $this->middleware('auth');

        /* module details */
        $this->module['modulename'] = 'field';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi`
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('tab' => array('name'), 'block' => array('name'));//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array('tab');// select parent for show in edit view
        $this->module['modulechild'] = array();//array('module name' => array('module show fields'))

        $type = array('text' => 'text', 'number' => 'number', 'textarea' => 'textarea', 'select' => 'select', 'multiselect' => 'multiselect', 'checkbox' => 'checkbox', 'file' => 'file', 'multifile' => 'multifile', 'password' => 'password', 'email' => 'email', 'time' => 'time', 'date' => 'date', 'currency' => 'currency', 'tags' => 'tags', 'hidden' => 'hidden');
        $block_field = array(
            'information' => array(
                'name'          => array('type' => 'text',      'required' => true,  'value' => false, 'readonly' => false, 'placeholder' => ''),
                'type' 	 	    => array('type' => 'select', 	'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => '', 'option' => $type, 'translate' => false, 'multiple' => false),
                'required' 	 	=> array('type' => 'checkbox',  'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => ''),
                'readonly' 	 	=> array('type' => 'checkbox',  'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => ''),
                'class'         => array('type' => 'textarea', 	'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => '', 'placeholder' => ''),// 'class' => 'summernote'
                'data'          => array('type' => 'textarea', 	'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => '', 'placeholder' => ''),// 'class' => 'summernote'
                'placeholder'   => array('type' => 'text',      'required' => false, 'value' => false, 'readonly' => false, 'placeholder' => ''),
                'maxlength'     => array('type' => 'number', 	'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => ''),
                'translate'     => array('type' => 'checkbox',  'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => ''),
                'upload_type'   => array('type' => 'select', 	'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => '', 'option' => array('image' => 'image'), 'translate' => false, 'multiple' => false),
                'multiple' 	 	=> array('type' => 'checkbox',  'required' => false, 'value' => false, 'readonly' => false, 'class' => '', 'data' => ''),
                'multiple_delete_url' => array('type' => 'text','required' => false, 'value' => false, 'readonly' => false, 'placeholder' => ''),
            ),
        );

        /* Auto fill -> no change sub line */
        $this->controllerFunction = new PublicControllerFunction();
        $moduleinfo = $this->controllerFunction->getmoduleinfo($this->module['modulename']);
        $this->module['modulelabel'] = $moduleinfo['modulelabel'];
        $this->module['modulemodel'] = $moduleinfo['modulemodel']; // create model name
        $this->module['moduleprimarykey'] = $moduleinfo['moduleprimarykey'];
        $this->module['moduletabid'] = $moduleinfo['moduletabid'];
        $this->module['moduleblockfield'] = $block_field;
    }

    /**
     * Show the application module List.
     *
     * @return /view/panel/list
     */
    public function list()
    {
        $function = $this->controllerFunction->list($this->module);
        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/list'),
            array(
                'data' => $function['data'],
                'label' => $function['label'],
                'details' => false,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
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
        $action = '/' . $this->module['modulename'] . '/new';
        $function = $this->controllerFunction->new($this->module);

        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/edit'),
            array(
                'block_field' => $function['block_field'],
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

    /**
     * Store a new record for module.
     *
     * @param  Request $request
     * @return Response message in view
     */
    public function store(Request $request)
    {
        $validationparams = $this->controllerFunction->setfieldvalidation($this->module, $request);
        $this->validate($request, $validationparams);

        $this->controllerFunction->store($this->module, $request);
        return back()->with('success', 'You have just created one ' . $this->module['modulename']);
    }

    /**
     * Show the application record of module details view.
     *
     * @return /view/panel/edit
     */
    public function details($id)
    {
        return false;
    }

    /**
     * Show the application record of module details view.
     * @param  Request $id , $rel
     * @return /view/panel/details
     */
    public function relation($id, $rel)
    {
        return false;
    }

    /**
     * Show the application record of module edit view.
     * @param  Request $id
     * @return /view/panel/edit
     */
    public function edit($id)
    {
        return false;
    }

    /**
     * save a edited record of module.
     *
     * @param  Request $request
     * @return $Response message in view
     */
    public function save(Request $request)
    {
        return false;
    }

    /**
     * Delete a exist record of module.
     *
     * @param  Request $ids
     * @return $Response message in view
     */
    public function delete($ids)
    {
        return false;
    }

    /**
     * Delete a exist attachment.
     *
     * @param  Request $request
     * @return Response
     */
    public function deleteattachment(Request $request)
    {
        return false;
    }
}
