<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class SkillController extends GamaController
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
        $this->module['modulename'] = 'skill';
        $this->module['moduleattachment'] = 1; // 0 = false, 1= single, 2 = multi`
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('lv1skill' => array('name'));//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array('lv1skill');// select parent for show in edit view
        $this->module['modulechild'] = array();//array('module name' => array('module show fields'))

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
     *
     * */
    public function grid()
    {
        return view("site.skill-grid");
    }

    /**
     *
     * */
    public function single()
    {
        return view("site.skill-single");
    }
}
