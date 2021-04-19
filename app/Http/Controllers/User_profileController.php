<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Http\Controllers\PublicClass\PublicControllerFunction;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User_profileController extends Controller
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
        $this->module['modulename'] = 'user_profile';
        $this->module['moduleattachment'] = 1; // 0 = false, 1= single, 2 = multi
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
    public function list()
    {
        $module = $this->module;
        if (count($module['moduleparent'])) {
            $record = $module['modulemodel']::with(['userole', 'user'])->get();
            /* create columns */
            $label = array($module['moduleprimarykey']);
            $modulelabel = \App\Tab_list_header::where('tabid', $module['moduletabid'])->value('columnname');
            if (!$modulelabel)
                $modulelabel = array('name', 'created_at', 'updated_at');
            else
                $modulelabel = explode(',', $modulelabel);

            $label = array_merge($label, array_keys($module['moduleparent']), $modulelabel);

            /* fill rel columns */
            if (count($record)) {
                foreach ($record as $key => $item) {
                    foreach ($module['moduleparent'] as $parent_key => $parent_value) {
                        $name = null;
                        if ($record[$key]->userole->$parent_key) $name = $item['userole'][$parent_key]['name'];
                        $record[$key]->$parent_key = $name;
                    }
                    $email = false;
                    if ($record[$key]->user->$parent_key) $email = $item['user']['email'];
                    $record[$key]['email'] = $email;
                }
            }
        } else {
            $record = $module['modulemodel']::all();
            /* create columns */
            $label = array($module['moduleprimarykey']);
            $modulelabel = \App\Tab_list_header::where('tabid', $module['moduletabid'])->pluck('columnname');
            if (!$modulelabel)
                $modulelabel = array('name', 'created_at', 'updated_at');
            else
                $modulelabel = explode(',', $modulelabel);

            $label = array_merge($label, array_keys($module['moduleparent']), $modulelabel);
        }
        $function = array('data' => $record, 'label' => $label);

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
        $function['block_field']['authentication'] = array(
            'email' => array('type' => 'text', 'required' => true, 'value' => null, 'readonly' => false, 'placeholder' => ''),
            'password' => array('type' => 'password', 'required' => true, 'value' => null, 'readonly' => false, 'placeholder' => ''),
            'password_confirmation' => array('type' => 'password', 'required' => true, 'value' => null, 'readonly' => false, 'placeholder' => '', 'maxlength' => 11),
        );

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
        $this->validate($request, [
            'email' => 'required|email:rfc|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roleid' => 'required|numeric|not_in:0',
        ]);

        /* save laravel user */
        $record = new \App\User();
        $record->email = $request->email;
        $record->password = bcrypt($request->password);
        $record->roleid = $request->roleid;
        $record->save();

        /* insert new file */
        if ($this->module['moduleattachment'] == 1) {
            if ($request->hasFile('attachment')) {
                /* upload new file */
                $file_path = $request->attachment->store('upload/' . $this->module['modulename']);
                $attachment = new Attachment();
                $attachment->path = $file_path;
                $attachment->tabid = $this->module['moduletabid'];
                $attachment->ownerid = $record[$this->module['moduleprimarykey']];
                try {
                    $attachment->save();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        } elseif ($this->module['moduleattachment'] == 2) {
            if ($request->hasFile('attachment')) {
                /* upload new files */
                foreach ($request->attachment as $attachment_item) {
                    $file_path = $attachment_item->store('upload/' . $this->module['modulename']);
                    $attachment = new Attachment();
                    $attachment->path = $file_path;
                    $attachment->tabid = $this->module['moduletabid'];
                    $attachment->ownerid = $record[$this->module['moduleprimarykey']];
                    try {
                        $attachment->save();
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            }
        }

        /* set and remove additional fields */
        $_request = $request->all();
        $_request['userid'] = $record->id;
        unset($_request['roleid'], $_request['email'], $_request['password'], $_request['password_confirmation']);

        $this->controllerFunction->store($this->module, (object)$_request);
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
     * @param Request $id , $rel
     * @return /view/panel/details
     */
    public function relation($id, $rel)
    {
        return false;
    }

    /**
     * Show the application record of module edit view.
     * @param Request $id
     * @return /view/panel/edit
     */
    public function edit($id)
    {
        $action = '/' . $this->module['modulename'] . '/edit';
        $module = $this->module;
        $block_field = array();
        $record = $this->module['modulemodel']::with('userole')->where($this->module['moduleprimarykey'], $id)->first() ?? abort(404);
        $tabinfo = $this->controllerFunction->gettabinfo($module['moduletabid']);

        if ($record) {
            $block_field = $this->controllerFunction->getblockfield($module);

            /* get parent module info */
            $class = "\App\Http\Controllers\\" . $tabinfo['tablename'] . "Controller";
            $controller = new $class;
            /* remove parent field */
            foreach ($block_field['information'] as $key => $value) {
                if (in_array(substr($key, 0, -2), $module['moduleshowparentview'])) continue;
                if (in_array(substr($key, 0, -2), array_keys($controller->module['moduleparentseq'])))
                    unset($block_field['information'][$key]);
                if (in_array(substr($key, 0, -2), array_keys($controller->module['moduleparent'])))
                    unset($block_field['information'][$key]);
            }

            foreach ($block_field as $item_key => $item_value) {
                foreach ($item_value as $key => $value) {
                    if ($key == 'attachment') {
                        if ($module['moduleattachment'] == 1) {
                            $path_attachment = Attachment::where('tabid', $module['moduletabid'])->where('ownerid', $id)->value('path');
                            $block_field[$item_key][$key]['value'] = $path_attachment;
                        } elseif ($module['moduleattachment'] == 2) {
                            $attachments = Attachment::where('tabid', $module['moduletabid'])->where('ownerid', $id)->get();
                            $path_attachment = array();
                            foreach ($attachments as $item) {
                                $path_attachment[$item->attachmentid] = $item->path;
                            }
                            $block_field[$item_key][$key]['value'] = $path_attachment;
                        }
                    } else {
                        if ($key == 'roleid')
                            $block_field[$item_key][$key]['value'] = $record->userole->role->$key;
                        else
                            $block_field[$item_key][$key]['value'] = $record->$key;
                    }
                }
            }
            $block_field['information'][$module['moduleprimarykey']] = array('type' => 'hidden', 'required' => true, 'value' => $record[$module['moduleprimarykey']], 'readonly' => true);
            if ($tabinfo['usecustomfield']) {
                foreach ($module['moduleparent'] as $key => $value) {
                    $modulename = $key;
                    $moduleparent = $this->controllerFunction->getmoduleinfo($modulename);

                    /* get field record */
                    $fields = \App\Field::where('tabid', $moduleparent['moduletabid'])->get();
                    if (count($fields)) {

                        /* create cf table info */
                        $cfmoduletable = $modulename . '_cf';
                        $cfmoduletableprimary = $cfmoduletable . 'id';
                        $cfmoduletablevalue = DB::table($cfmoduletable)->where($cfmoduletableprimary, $id)->first();

                        foreach ($fields as $item) {
                            $columnname = $item->columnname;
                            $fieldvalue = ($cfmoduletablevalue) ? $cfmoduletablevalue->$columnname : false;
                            $_fieldinfo = array();
                            $_fieldinfo = $this->controllerFunction->setfieldinfo($item->columntype, $fieldvalue);

                            $block_field['customfield'][$item->columnname] = $_fieldinfo;
                        }
                    }
                }
                foreach ($module['moduleparentseq'] as $key => $value) {
                    $modulename = $key;
                    $moduleparent = $this->controllerFunction->getmoduleinfo($modulename);

                    /* get field record */
                    $fields = \App\Field::where('tabid', $moduleparent['moduletabid'])->get();
                    if (count($fields)) {

                        /* create cf table info */
                        $cfmoduletable = $modulename . '_cf';
                        $cfmoduletableprimary = $cfmoduletable . 'id';
                        $cfmoduletablevalue = DB::table($cfmoduletable)->where($cfmoduletableprimary, $id)->first();

                        foreach ($fields as $item) {
                            $columnname = $item->columnname;
                            $fieldvalue = ($cfmoduletablevalue) ? $cfmoduletablevalue->$columnname : false;
                            $_fieldinfo = array();
                            $_fieldinfo = $this->controllerFunction->setfieldinfo($item->columntype, $fieldvalue);

                            $block_field['customfield'][$item->columnname] = $_fieldinfo;
                        }
                    }
                }
            }
        }

        $function = array('block_field' => $block_field);
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
        $this->validate($request, [
            $this->module['moduleprimarykey'] => 'required|numeric',
            'roleid' => 'required|numeric|not_in:0',
        ]);

        /* save laravel user */
        $record = \App\User::find($request->userid) ?? abort(404);
        $record->roleid = $request->roleid;
        $record->save();

        /* set and remove additional fields */
        $_request = $request->all();
        unset($_request['roleid']);

        $fields = $this->controllerFunction->getfield($this->controllerFunction->getblockfield($this->module));
        /* get seq parent module primary key */
        $seqparentprimarykey = array();
        foreach ($this->module['moduleparentseq'] as $key => $value) {
            $seqparentprimarykey[] = $key . 'id';
        }
        foreach ($this->module['moduleparent'] as $key => $value) {
            $seqparentprimarykey[] = $key . 'id';
        }

        /* edit record */
        $record = $this->module['modulemodel']::find($_request[$this->module['moduleprimarykey']]);
        foreach ($fields as $key => $value) {
            if ($key == 'attachment' || in_array($key, $seqparentprimarykey)) continue;
            $field_value = $_request[$key];
            if ($value['type'] == 'currency') $field_value = str_replace(',', '', $field_value);
            $record->$key = $field_value;
        }
        $record->save();

        /* insert new file */
        if ($this->module['moduleattachment'] == 1) {
            if ($request->hasFile('attachment')) {
                /* delete old attachment file */
                $old_attachment = Attachment::where('tabid', $this->module['moduletabid'])->where('ownerid', $record[$this->module['moduleprimarykey']])->first();
                if ($old_attachment)
                    $old_attachment->delete();

                /* upload new file */
                $file_path = $request->attachment->store('upload/' . $this->module['modulename']);

                $attachment = new Attachment();
                $attachment->path = $file_path;
                $attachment->tabid = $this->module['moduletabid'];
                $attachment->ownerid = $record[$this->module['moduleprimarykey']];
                try {
                    $attachment->save();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        } elseif ($this->module['moduleattachment'] == 2) {
            if ($request->hasFile('attachment')) {
                /* upload new file */
                foreach ($request->attachment as $attachment_item) {
                    $file_path = $attachment_item->store('upload/' . $this->module['modulename']);
                    $attachment = new Attachment();
                    $attachment->path = $file_path;
                    $attachment->tabid = $this->module['moduletabid'];
                    $attachment->ownerid = $record[$this->module['moduleprimarykey']];
                    try {
                        $attachment->save();
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            }
        }

        return back()->with('success', 'You have edited one ' . $this->module['modulename']);
    }

    /**
     * Delete a exist record of module.
     *
     * @param Request $ids
     * @return $Response message in view
     */
    public function delete($ids)
    {
        $array_id = explode(',', $ids);
        foreach ($array_id as $item) {
            $record = $this->module['modulemodel']::where($this->module['moduleprimarykey'], $item)->first();
            if (!empty($item)) {
                $user = \App\User::find($record->userid);
                if ($user) $user->delete();
            }
        }
        $function = $this->controllerFunction->delete($this->module, $ids);
        if ($function) {
            return back()->with('success', 'You have deleted one ' . $this->module['modulename']);
        } else {
            return back()->with('error', "you can not delete. record have child");
        }
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

    public function transactionslist()
    {
        $function['data'] = \App\Transaction::with('user_profile')->get();

        foreach ($function['data'] as $key => $item) {
            $function['data'][$key]->user = $item->user_profile->name . ' ' . $item->user_profile->family;

            $bids_projectid = explode(':', (explode('|', (explode(',', $item->transaction_name)[0]))[1]))[1];
            $projectid = \App\Bids_project::where('bids_projectid', $bids_projectid)->value('projectid') ?? false;
            $project = \App\Project::where('projectid', $projectid)->first() ?? false;
            $function['data'][$key]->project = $project->projectid . ' ' . $project->name;

        }
        $function['label'] = array('transactionid', 'user', 'project', 'orderid', 'paypal_transactionid', 'price', 'status', 'created_at');
        return view(
            $this->controllerFunction->view($this->module['modulename'] . '/transactionslist'),
            array(
                'data' => $function['data'],
                'label' => $function['label'],
                'details' => false,
                'permission' => $this->controllerFunction->permission($this->module['moduletabid'])
            )
        );
    }

}
