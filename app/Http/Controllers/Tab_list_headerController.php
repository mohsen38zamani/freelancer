<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class Tab_list_headerController extends GamaController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        /* module details */
        $this->module['modulename'] = 'tab_list_header';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('tab' => array('name'));//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array('tab');// select parent for show in edit view
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
        $function['block_field']['information']['tabid']['class'] = "haschild";
        $function['block_field']['information']['tabid']['data'] = "columnname";
        unset($function['block_field']['information']['tabid']['option'][1]);
        unset($function['block_field']['information']['tabid']['option'][4]);
        unset($function['block_field']['information']['tabid']['option'][5]);

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
     * @param Request $request
     * @return Response message in view
     */
    public function store(Request $request)
    {
        $validationparams = $this->controllerFunction->setfieldvalidation($this->module, $request);
        $validationparams['columnname'] = "required|array";
        $this->validate($request, $validationparams);

        $_request = $request->all();
        $_request['columnname'] = implode(',', $_request['columnname']);
        $this->controllerFunction->store($this->module, (object)$_request);
        return back()->with('success', 'You have just created one ' . $this->module['modulename']);
    }

    /**
     * Show the application record of module edit view.
     * @param Request $id
     * @return /view/panel/edit
     */
    public function edit($id)
    {
        $action = '/' . $this->module['modulename'] . '/edit';
        $function = $this->controllerFunction->edit($this->module, $id);

        /* fill option value in columnname field */
        $function['block_field']['information']['columnname']['value'] = explode(',', $function['block_field']['information']['columnname']['value']);
        $tabid['id'] = $function['block_field']['information']['tabid']['value'];
        $request = new \Illuminate\Http\Request($tabid, $tabid);
        $options = $this->getChild($request);
        $function['block_field']['information']['columnname']['option'] = $options;

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
     * save a edited record of module.
     *
     * @param Request $request
     * @return $Response message in view
     */
    public function save(Request $request)
    {
        $validationparams = $this->controllerFunction->setfieldvalidation($this->module, $request);
        foreach ($this->module['moduleparentseqrel'] as $item) {
            if (in_array($item, $this->module['moduleshowparentview'])) continue;
            unset($validationparams[$item]);
        }
        $validationparams['columnname'] = "required|array";
        $this->validate($request, $validationparams);

        $_request = $request->all();
        $_request['columnname'] = implode(',', $_request['columnname']);
        $this->controllerFunction->save($this->module, new \Illuminate\Http\Request($_request, $_request));
        return back()->with('success', 'You have edited one ' . $this->module['modulename']);
    }

    /**
     * Delete a exist attachment.
     *
     * @param Request $request
     * @return Response
     */
    public function deleteattachment(Request $request)
    {
        return null;
    }

    /**
     * get parent module chields.
     *
     * @type ajax
     * @param  Request $request
     * @return data array
     */
    public function getChild(Request $request)
    {
        /* get child module */
        $tabinfo = $this->controllerFunction->gettabinfo($request['id']);
        if ($tabinfo['folder'])
            $path = "\App\Http\Controllers\\".$tabinfo['folder']."\\";
        else
            $path = "\App\Http\Controllers\\";
        $controller = $this->controllerFunction->getController($tabinfo['tablename'], $path);
        $field = $this->controllerFunction->getfield($controller->module['moduleblockfield']);
        $fields_array_keys = array_keys($field);
        foreach ($fields_array_keys as $item) {
            $response[$item] = $item;
        }
        $response['created_at'] = 'created_at';
        $response['updated_at'] = 'updated_at';

        return $response;
    }

}
