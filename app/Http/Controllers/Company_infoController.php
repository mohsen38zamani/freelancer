<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use Morilog\Jalali\CalendarUtils;

class Company_infoController extends Controller
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
        $this->controllerFunction = new PublicControllerFunction();
        $this->middleware('auth');
        /* module details */
        $this->module['modulename'] = 'company_info';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array();// select parent for show in edit view
        $this->module['modulechild'] = array(); //array('module name' => array('module show fields'))

        /* Auto fill -> no change sub line */
        $moduleinfo = $this->controllerFunction->getmoduleinfo($this->module['modulename']);
        $this->module['modulelabel'] = $moduleinfo['modulelabel'];
        $this->module['modulemodel'] = $moduleinfo['modulemodel']; // create model name
        $this->module['moduletabid'] = $moduleinfo['moduletabid'];
        $this->module['moduleprimarykey'] = $moduleinfo['moduleprimarykey'];
        $this->module['moduleblockfield'] = $this->controllerFunction->getmoduleblockfield($moduleinfo['moduletabid']);
    }

    /**
     * Show the application record of module edit view.
     *
     * @return /view/panel/edit
     */
    public function edit()
    {
        $block_field = array();
        $action = '/' . $this->module['modulename'] . '/edit';
        $record = $this->module['modulemodel']::first();
        $block_field = $this->controllerFunction->getblockfield($this->module);
        foreach ($block_field as $item_key => $item_value) {
            foreach ($item_value as $key => $value) {
                $record_value = ($record) ? $record->$key : $value['value'];
                if ($value['type'] == 'date') $record_value = $this->controllerFunction->gregoriantojalali($record_value);

                $block_field[$item_key][$key]['value'] = $record_value;
            }
        }
        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/edit'),
            array(
                'block_field' => $block_field,
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

    /**
     * save a edited record of module.
     *
     * @param Request $request
     * @return Response
     */
    public function save(Request $request)
    {
        $validationparams = $this->controllerFunction->setfieldvalidation($this->module, $request);
        $this->validate($request, $validationparams);
        $fields = $this->controllerFunction->getfield($this->controllerFunction->getblockfield($this->module));

        /* edit record */
        $record = $this->module['modulemodel']::first();
        if (!$record) $record = new $this->module['modulemodel'];
        foreach ($fields as $key => $value) {
            if ($key == $this->module['moduleprimarykey']) continue;
            $record_value = $request->$key;
            if ($value['type'] == 'date') {
                $record_value = $this->controllerFunction->jalalitogregorian($record_value);
            }

            $record->$key = $record_value;
        }
        $record->save();

        return back()->with('success', 'You have edited ' . $this->module['modulename']);
    }

    /**
     *  Admin change password.
     *
     * @param Request $request
     * @return alert
     */
    public function change_password(Request $request)
    {
        $user = User::find($request);
        $user->makeVisible('password')->toArray();
        $current_password = $user->makeVisible('password')->toArray()[0]['password'];
        $userid = $user->makeVisible('password')->toArray()[0]['id'];
        if (Hash::check($request->current_password, $current_password)) {
            DB::table('users')
                ->where('id', $userid)
                ->update(['password' => Hash::make($request->new_password)]);

            return response()->json(array('success' => 'Your password is changed!'), 200);
        } else {
            return response()->json(array('error' => 'Please enter correct current password'), 200);
        }
    }
}
