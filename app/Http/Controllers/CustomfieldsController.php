<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class CustomfieldsController extends Controller
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
        $this->module['modulename'] = 'customfields';
        $this->module['moduleattachment'] = 0; // 0 = false, 1= single, 2 = multi
        $this->module['moduleparentseqrel'] = array();// fill cb by ajax seq relation
        $this->module['moduleparentseq'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleparent'] = array();//array('module name' => array('module show fields'))
        $this->module['moduleshowparentview'] = array();// select parent for show in edit view
        $this->module['modulechild'] = array(); //array('module name' => array('module show fields'))
        $fieldtype = array(
            'text' => 'نوشته',
            'number' => 'عدد',
            'textarea' => 'متن',
//            'select' => 'فهرست انتخابی',
//            'multiselect' => 'فهرست چند انتخابی',
            'checkbox' => 'چک باکس',
            'file' => 'فایل',
            'multifile' => 'چند فایل',
            'password' => 'کلمه عبور',
            'email' => 'پست الکترونیک',
            'time' => 'زمان',
            'date' => 'تاریخ',
            'currency' => 'پول',
            'tags' => 'تگ',
        );
        $block_field = array(
            'information' => array(
                'tabid' => array('type' => 'hidden', 'required' => true, 'value' => null, 'readonly' => false, 'placeholder' => ''),
                'columnname' => array('type' => 'hidden', 'required' => true, 'value' => 'cf_', 'readonly' => false, 'placeholder' => ''),
                'columnlabel' => array('type' => 'text', 'required' => true, 'value' => null, 'readonly' => false, 'placeholder' => 'نام فیلد'),
                'columntype' => array('type' => 'select', 'required' => true, 'value' => null, 'readonly' => true, 'option' => $fieldtype, 'translate' => false, 'multiple' => false, 'class' => '',),
            ),
        );

        /* Auto fill -> no change sub line */
        $this->controllerFunction = new PublicControllerFunction();
        $moduleinfo = $this->controllerFunction->getmoduleinfo($this->module['modulename']);
        $this->module['modulelabel'] = $moduleinfo['modulelabel'];
        $this->module['modulemodel'] = $moduleinfo['modulemodel']; // create model name
        $this->module['moduletabid'] = $moduleinfo['moduletabid'];
        $this->module['moduleprimarykey'] = $moduleinfo['moduleprimarykey'];
        $this->module['moduleblockfield'] = $block_field;
    }

    /**
     * Show the application record List.
     *
     * @return /view/panel/list
     */
    public function list()
    {
        /* fill cb with clinic in list */
        $block_field = array();
        $array_modules = array('Please select...');
        $tabs = \App\Tab::where('hascustomfield', true)->get();
        if (count($tabs)) {
            foreach ($tabs as $item) {
                $array_modules[$item->tabid] = $item->name;
            }
            $block_field = array(
                'tabid' => array('type' => 'select', 'required' => true, 'value' => null, 'readonly' => true, 'option' => $array_modules, 'translate' => false),
            );
        }

        $fields = array();
        $label = array('fieldid', 'columnname', 'columnlabel', 'columntype', 'created_at');
        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/list'),
            array(
                'block_field' => $block_field,
                'data' => $fields,
                'label' => $label,
                'details' => false,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

    /**
     * Show the application record List by id.
     *
     * @return /view/panel/list
     */
    public function list_by_id($id)
    {
        /* fill cb with clinic in list */
        $block_field = array();
        $array_modules = array('Please select...');
        $tabs = \App\Tab::where('hascustomfield', true)->get();
        if (count($tabs)) {
            foreach ($tabs as $item) {
                $array_modules[$item->tabid] = $item->name;
            }
            $block_field = array(
                'tabid' => array('type' => 'select', 'required' => true, 'value' => $id, 'readonly' => true, 'option' => $array_modules, 'translate' => false),
            );
        }

        $fields = array();
        $columnnames = array();
        $fields = \App\Field::where('tabid', $id)->get();

        /* get translate for columnlabel */
        foreach ($fields as $item) {
            $columnnames[] = $item['columnname'];
        }
        $labels = \App\Translator::whereIn('item', $columnnames)->where('locale', App::getLocale())->get()->toArray();
        foreach ($fields as $key => $value) {
            foreach ($labels as $item) {
                if ($value['columnname'] == $item['item'])
                    $fields[$key]['columnlabel'] = $item['text'];
            }
        }

        $label = array('fieldid', 'columnname', 'columnlabel', 'columntype', 'created_at');
        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/list'),
            array(
                'block_field' => $block_field,
                'data' => $fields,
                'label' => $label,
                'details' => false,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

    /**
     * Show the application New record.
     *
     * @return /view/panel/edit
     *
     * input type  =>  text,number,password,select,email,tel,hidden,button,submit,reset,checkbox,radio,file,color,date,url,range,time,textarea
     */
    public function new($id)
    {
        $action = '/' . $this->module['modulename'] . '/new';
        $this->module['moduleblockfield']['information']['tabid']['value'] = $id;
        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/edit'),
            array(
                'block_field' => $this->module['moduleblockfield'],
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

    /**
     * Store a new record.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        /* set field validation */
        $fields = $this->module['moduleblockfield']['information'];
        $validate = array();
        foreach ($fields as $key => $value) {
            $validate[$key] = 'required|string';
        }
        $this->validate($request, $validate);

        /* get latest custom field id */
        $field = \App\Field::withTrashed()->latest()->value('fieldid');
        $field = ($field) ? ++$field : 1;
        $columnname = $request->columnname . $field;

        /* set language label */
        $customfieldtarget = \App\Customfieldmapping::where('sourcetabid', $request->tabid)->get();
        if (!$customfieldtarget) return back()->with('error', 'Customfieldmapping is null');
        foreach ($customfieldtarget as $item) {
            $lang = App::getLocale();
            $targettab = $this->controllerFunction->gettabinfo($item->targettabid);
            $translate = new \App\Translator();
            $translate->locale = $lang;
            $translate->namespace = '*';
            $translate->group = $targettab['tablename'];
            $translate->item = $columnname;
            $translate->text = $request->columnlabel;
            $translate->unstable = 0;
            $translate->locked = 0;
            $translate->save();
        }

        unset($fields['columnlabel']);
        $fields['tablename'] = array();

        /* create table name and primary key */
        $tab = \App\Tab::where('tabid', $request->tabid)->first();
        $cf_tablename = $tab->tablename . '_cf';
        $cf_table_primarykey = $tab->tablename . '_cfid';

        /* insert new customfield */
        $record = new \App\Field();
        foreach ($fields as $key => $value) {
            if ($key == 'columnname')
                $record->$key = $columnname;
            elseif ($key == 'tablename')
                $record->$key = $cf_tablename;
            else
                $record->$key = $request->$key;
        }
        $record->save();

        /* check exist cf_table */
        if (!Schema::hasTable($cf_tablename)) {
            Schema::create($cf_tablename, function (Blueprint $table) use ($cf_table_primarykey) {
                $table->bigInteger($cf_table_primarykey)->primary();
            });
        }

        /* create cf column */
        switch ($request->columntype) {
            case 'number' :
                $type = 'float';
                $length = 12;
                $fieldName = $columnname;
                break;
            case 'textarea' :
                $type = 'text';
                $length = 0;
                $fieldName = $columnname;
                break;
            case 'checkbox' :
                $type = 'tinyInteger';
                $length = 0;
                $fieldName = $columnname;
                break;
            case 'currency' :
                $type = 'float';
                $length = 12;
                $fieldName = $columnname;
                break;
            case 'time' :
                $type = 'time';
                $length = 0;
                $fieldName = $columnname;
                break;
            case 'date' :
                $type = 'date';
                $length = 0;
                $fieldName = $columnname;
                break;
            case 'tags' :
                $type = 'text';
                $length = 0;
                $fieldName = $columnname;
                break;
            default :
                $type = 'string';
                $length = 255;
                $fieldName = $columnname;
                break;
        }

        Schema::table($cf_tablename, function (Blueprint $table) use ($type, $length, $fieldName) {
            $table->$type($fieldName, $length)->nullable();
        });

        /* save system tracker */
        $current_user = $this->controllerFunction->getcurrent_user(Auth::id());
        $recordid = 'fieldid';
        $this->controllerFunction->savesystemtrackerrecord($this->module['moduletabid'], $current_user->user_profileid, $record->$recordid, 1);
        return back()->with('success', 'You have just created one customfield');
    }

    /**
     * Show the application edit view.
     *
     * @return /view/panel/edit
     */
    public function edit($id, $tabid)
    {
        $action = '/' . $this->module['modulename'] . '/edit';

        /* set parameter */
        $field = \App\Field::where('fieldid', $id)->first() ?? abort(404);
        $label = \App\Translator::where('item', $field->columnname)->where('locale', App::getLocale())->value('text');

        unset($this->module['moduleblockfield']['information']['columntype'], $this->module['moduleblockfield']['information']['columnname']);
        $this->module['moduleblockfield']['information']['tabid']['value'] = $tabid;
        $this->module['moduleblockfield']['information']['fieldid'] = array('type' => 'hidden', 'required' => true, 'value' => $id, 'readonly' => false, 'placeholder' => '');
        $this->module['moduleblockfield']['information']['columnlabel']['value'] = $label;

        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/edit'),
            array(
                'block_field' => $this->module['moduleblockfield'],
                'action' => $action,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

    /**
     * Save a Edit record.
     *
     * @param Request $request
     * @return Response
     */
    public function save(Request $request)
    {
        $this->validate($request, [
            'columnlabel' => 'required|string',
        ]);
        /* set language label */
        $lang = App::getLocale();
        $field = \App\Field::where('fieldid', $request->fieldid)->first() ?? abort(404);

        $customfieldtarget = \App\Customfieldmapping::where('sourcetabid', $request->tabid)->get();
        foreach ($customfieldtarget as $item) {
            $targettab = $this->controllerFunction->gettabinfo($item->targettabid);
            $translate = \App\Translator::where('locale', $lang)->
            where('group', $targettab['tablename'])->
            where('item', $field->columnname)->first();
            if (!$translate) {
                $translate = new \App\Translator();
            }
            $translate->locale = $lang;
            $translate->namespace = '*';
            $translate->group = $targettab['tablename'];
            $translate->item = $field->columnname;
            $translate->text = $request->columnlabel;
            $translate->unstable = 0;
            $translate->locked = 0;
            $translate->save();
        }

        return back()->with('success', 'You have edited one customfield');
    }

    /**
     * Delete a exist record.
     *
     * @param Request $request
     * @return Response
     */
    public function delete($ids, $tabid)
    {
        $current_user = $this->controllerFunction->getcurrent_user(Auth::id());
        $recordid = $this->module['moduleprimarykey'];
        $array_id = explode(',', $ids);
        foreach ($array_id as $item) {
            if (!$item) continue;
            /* delete record */
            $record = \App\Field::find($item) ?? abort(404);
            $recordid = $record->fieldid;
            $record->delete();
            /* save system tracker */
            $this->controllerFunction->savesystemtrackerrecord($this->module['moduletabid'], $current_user->user_profileid, $recordid, 3);
        }
        return back()->with('success', 'You have deleted one customfield');
    }
}
