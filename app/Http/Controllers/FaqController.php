<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class FaqController extends GamaController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['sitelist', 'siteitemshow']]);

        /* module details */
        $this->module['modulename'] = 'faq';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array('role' => array('name'));//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array('role');// select parent for show in edit view
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
    public function sitelist()
    {
        $current_user = array();
        if (Auth()->id()) $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $function = $this->controllerFunction->list($this->module);

        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/list', 'site'),
            array(
                'data' => $function['data'],
                'label' => $function['label'],
                'details' => false,
                'permission' => true,
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'current_user' => $current_user,
                'current_page_user' => $current_user,
                'lang' => \App::getLocale(),
                'def_lang' => \App\Language::where('default', 1)->value('locale'),
            )
        );
    }

    /**
     * Show the application record of module edit view.
     * @param  Request $id
     * @return /view/panel/edit
     */
    public function siteitemshow($id)
    {
        $current_user = array();
        if (Auth()->id()) $current_user = $this->controllerFunction->getcurrent_user(Auth()->id());
        $function = $this->controllerFunction->edit($this->module, $id);
        $def_lang = \App\Language::where('default', 1)->value('locale');
        $lang = \App::getLocale();

        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/view', 'site'),
            array(
                'block_field' => $function['block_field'],
                'permission' => true,
                'footer' => \App\Footermenu::with('Footeritem')->get(),
                'socialmedialist' => \App\Socialmedialist::all(),
                'current_user' => $current_user,
                'current_page_user' => $current_user,
                'lang' => $lang,
                'def_lang' => $def_lang,
            )
        );
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
}
