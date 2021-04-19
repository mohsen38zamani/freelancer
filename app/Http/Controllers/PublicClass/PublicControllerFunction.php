<?php
/**
 * Created by PhpStorm.
 * User: EN.MOHSEN
 * Date: 25/09/2019
 * Time: 06:22 PM
 */

namespace App\Http\Controllers\PublicClass;

use App\Attachment;
use App\Http\Controllers\Controller;
use App\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Morilog\Jalali\CalendarUtils;

class PublicControllerFunction extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * get label and data fot table.
     *
     * @return module data array
     */
    public function list($module)
    {
        if (count($module['moduleparent'])) {
            $record = $module['modulemodel']::with(array_keys($module['moduleparent']))->get();
            /* create columns */
            $label = array($module['moduleprimarykey']);
            $modulelabel = \App\Tab_list_header::where('tabid', $module['moduletabid'])->value('columnname');
            if (!$modulelabel)
                $modulelabel = array('name', 'created_at', 'updated_at');
            else
                $modulelabel = explode(',', $modulelabel);

            $label = array_merge($label, array_keys($module['moduleparent']), $modulelabel);

            /* search date fiels and change to jalali date */
            $fields = self::getfield(self::getblockfield($module));
            $datefield = array();
            foreach ($fields as $key => $value) {
                if ($value['type'] == 'date') $datefield[] = $key;
            }
            if ($datefield) {
                foreach ($record as $key => $value) {
                    foreach ($datefield as $item) {
                        $jalalidate = $this->gregoriantojalali($record[$key][$item]);
                        $record[$key][$item] = $jalalidate;
                    }
                }
            }

            /* fill rel columns */
            if (count($record)) {
                foreach ($record as $key => $item) {
                    foreach ($module['moduleparent'] as $parent_key => $parent_value) {
                        $name = null;
//                        if ($record[$key]->$parent_key) $name = $item[$parent_key]['name'];
                        foreach ($parent_value as $value_label) {
                            $name = $name . ' ' . $item[$parent_key][$value_label];
                        }
                        $record[$key]->$parent_key = $name;
                    }
                }
            }
        } else {
            $record = $module['modulemodel']::all();

            /* search date fiels and change to jalali date */
            $fields = self::getfield(self::getblockfield($module));
            $datefield = array();
            foreach ($fields as $key => $value) {
                if ($value['type'] == 'date') $datefield[] = $key;
            }
            if ($datefield) {
                foreach ($record as $key => $value) {
                    foreach ($datefield as $item) {
                        $jalalidate = $this->gregoriantojalali($record[$key][$item]);
                        $record[$key][$item] = $jalalidate;
                    }
                }
            }

            /* create columns */
            $label = array($module['moduleprimarykey']);
            $modulelabel = \App\Tab_list_header::where('tabid', $module['moduletabid'])->value('columnname');
            if (!$modulelabel)
                $modulelabel = array('name', 'created_at', 'updated_at');
            else
                $modulelabel = explode(',', $modulelabel);

            $label = array_merge($label, array_keys($module['moduleparent']), $modulelabel);
        }

        return array('data' => $record, 'label' => $label);
    }

    /**
     * get blocks and fields.
     *
     * @return module fields array
     *
     * fields type  =>  text,number,password,select,email,tel,hidden,button,submit,reset,checkbox,radio,file,color,date,url,range,time,textarea
     */
    public function new($module)
    {
        $block_field = self::getblockfield($module);
        return array('block_field' => $block_field);
    }

    /**
     * get block and fields from module controller.
     *
     * @param  $module
     * @return module blocks and fields array
     */
    public function getblockfield($module)
    {
        $block_field = $module['moduleblockfield'];
        /* get parents sequence field */
        if (count($module['moduleparentseq'])) {
            $array_relmodule_record = array();
            $relmodule_flag = true;
            foreach ($module['moduleparentseq'] as $key => $value) {
                $parent_module_info = self::getmoduleinfo($key);

                /* get child module */
                $controller = $this->getController($parent_module_info['modulelabel']);
                $modulechild = array_keys($controller->module['modulechild']);

                if ($relmodule_flag) {
                    $relmodule_record = $parent_module_info['modulemodel']::all();
                    $array_relmodule_record[$parent_module_info['moduleprimarykey']]['item'][] = 'Please select...';
                    foreach ($relmodule_record as $item) {
                        $field_label = $parent_module_info['moduleprimarykey'];
                        if (count($value) > 1) {
                            $field_label = '';
                            foreach ($value as $value_label) {
                                $field_label = $field_label . ' ' . $item->$value_label;
                            }
                        } else {
                            $field_label = $item[$value[0]];
                        }

                        $array_relmodule_record[$parent_module_info['moduleprimarykey']]['item'][$item[$parent_module_info['moduleprimarykey']]] = $field_label;
                    }
                    $array_relmodule_record[$parent_module_info['moduleprimarykey']]['child'][] = $modulechild[0];
                    $relmodule_flag = false;
                } else {
                    $array_relmodule_record[$parent_module_info['moduleprimarykey']]['item'][] = 'Please select...';
                    $array_relmodule_record[$parent_module_info['moduleprimarykey']]['child'][] = $modulechild[0];
                }
            }
            foreach ($array_relmodule_record as $key => $value) {
                $block_field['information'][$key] = array('type' => 'select', 'required' => true, 'value' => null, 'readonly' => false, 'option' => $value['item'], 'translate' => false, 'class' => 'haschild', 'data' => $value['child'][0]);
            }
        }

        /* get parents field */
        if (count($module['moduleparent'])) {
            $array_relmodule_record = array();
            foreach ($module['moduleparent'] as $key => $value) {
                $parent_module_info = self::getmoduleinfo($key);

                /* check moduleparentseqrel for fill all cb without relation */
                if (isset($module['moduleparentseqrel']) && !in_array($key, $module['moduleparentseqrel'])) {// $module['moduleparentseqrel'] &&
                    $relmodule_record = $parent_module_info['modulemodel']::all();
                    foreach ($relmodule_record as $item) {
                        $field_label = $parent_module_info['moduleprimarykey'];
                        if (count($value) > 1) {
                            $field_label = '';
                            foreach ($value as $value_label) {
                                $field_label = $field_label . ' ' . $item->$value_label;
                            }
                        } else {
                            $field_label = $item[$value[0]];
                        }
                        $array_relmodule_record[$parent_module_info['moduleprimarykey']][] = 'Please select...';
                        $array_relmodule_record[$parent_module_info['moduleprimarykey']][$item[$parent_module_info['moduleprimarykey']]] = $field_label;
                    }
                } else {
                    $array_relmodule_record[$parent_module_info['moduleprimarykey']][] = 'Please select...';
                }
            }
            foreach ($array_relmodule_record as $key => $item) {
                $block_field['information'][$key] = array('type' => 'select', 'required' => true, 'value' => null, 'readonly' => false, 'option' => $item, 'translate' => false);
            }
        }
        /* add attachment field */
        if ($module['moduleattachment'] == 1) {
            $block_field['information']['attachment'] = array('type' => 'file', 'required' => false, 'value' => null, 'readonly' => false, 'upload_type' => 'image');
        } elseif ($module['moduleattachment'] == 2) {
            $block_field['information']['attachment'] = array('type' => 'file', 'required' => false, 'value' => null, 'readonly' => false, 'upload_type' => 'image', 'multiple' => true, 'multiple_delete_url' => '/' . $module['modulename'] . '/deleteattachment');
        }
        return $block_field;
    }

    /**
     * Store a new record for module.
     *
     * @param  $module , $request
     * @return true
     */
    public function store($module, $request)
    {
        $fields = self::getfield(self::getblockfield($module));
        foreach ($module['moduleparentseq'] as $key => $value) {
            /* remove module parent seq field */
            unset($fields[$key . 'id']);
        }

        /*  insert new record */
        $record = new $module['modulemodel'];
        $language_field = array();
        foreach ($fields as $key => $value) {
            /* skip if field name is not in request */
            if (!isset($request->$key)) continue;
            /* skip if is attachment field */
            if ($key == 'attachment') continue;
            /* skip if is language field */
            if (strpos($key, '|') !== false) {
                $language_field[$key] = $value;
                continue;
            }
            $field_value = $request->$key;
            if ($value['type'] == 'currency') $field_value = str_replace(',', '', $field_value);
            elseif ($value['type'] == 'checkbox') $field_value = ($field_value == 'on') ? true : false;
//            elseif ($value['type'] == 'textarea') $field_value = json_encode($field_value);
            elseif ($value['type'] == 'date') {
                $field_value = str_replace('-', '/', $field_value);
                $field_value = $this->jalalitogregorian($field_value);
            }
            $record->$key = $field_value;
        }
        try {
            $record->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        /* insert new translate */
        if (count($language_field)) {
            $tabinfo = $this->gettabinfo($module['moduletabid']);
            foreach ($language_field as $key => $value) {
                if (!$request->$key) continue;
                /* get language field info */
                $languagefieldinfo = $this->getlanguagefieldinfo($key, $module['moduletabid']);
                if (!$languagefieldinfo['lng']) continue;

                $lng_record = new \App\Translator();
                $lng_record['locale'] = $languagefieldinfo['lng'];
                $lng_record['namespace'] = '*';
                $lng_record['group'] = $tabinfo['tablename'];
                $lng_record['item'] = $request[$languagefieldinfo['field_info']['name']];
                $lng_record['text'] = $request->$key;
                $lng_record['unstable'] = false;
                $lng_record['locked'] = false;
                try {
                    $lng_record->save();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }

        /* insert new file */
        if ($module['moduleattachment'] == 1) {
            if ($request->hasFile('attachment')) {
                /* upload new file */
                $file_path = $request->attachment->store('upload/' . $module['modulename']);
                $attachment = new Attachment();
                $attachment->path = $file_path;
                $attachment->tabid = $module['moduletabid'];
                $attachment->ownerid = $record[$module['moduleprimarykey']];
                try {
                    $attachment->save();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        } elseif ($module['moduleattachment'] == 2) {
            if ($request->hasFile('attachment')) {
                /* upload new files */
                foreach ($request->attachment as $attachment_item) {
                    $file_path = $attachment_item->store('upload/' . $module['modulename']);
                    $attachment = new Attachment();
                    $attachment->path = $file_path;
                    $attachment->tabid = $module['moduletabid'];
                    $attachment->ownerid = $record[$module['moduleprimarykey']];
                    try {
                        $attachment->save();
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            }
        }

        if ($this->getcurrent_user(Auth::id())) {
            $current_user = $this->getcurrent_user(Auth::id());
            $userid = $current_user->user_profileid;
        } else {
            $userid = 0;
        }

        $recordid = $module['moduleprimarykey'];
        $this->savesystemtrackerrecord($module['moduletabid'], $userid, $record->$recordid, 1);
        return $record;
    }

    /**
     * show module record data.
     *
     * @param  $module , $id
     * @return record data array
     */
    public function details($module, $id)
    {
        return false;
    }

    /**
     * get relation modules.
     *
     * @param  $module , $id, $rel
     * @return rel module relation data array
     */
    public function relation($module, $id, $rel)
    {
        return false;
    }

    /**
     * get module blocks and fields with data.
     *
     * @param  $module , $id
     * @return module data array
     */
    public function edit($module, $id, $path = null, $user_profileid = null) // $path = controller path -> like "\App\Http\Controllers\\"
    {
        $block_field = array();
        if ($user_profileid)
            $record = $module['modulemodel']::where('user_profileid', $user_profileid)->find($id) ?? abort(404);
        else
            $record = $module['modulemodel']::find($id) ?? abort(404);
        $tabinfo = $this->gettabinfo($module['moduletabid']);

        if ($record) {
            $block_field = self::getblockfield($module);

            /* get parent module info */
            if ($path)
                $controller = $this->getController($tabinfo['tablename'], $path);
            else
                $controller = $this->getController($tabinfo['tablename']);

            /* remove parent field */
            foreach ($block_field['information'] as $key => $value) {
                /* skip remove if module name is in moduleshowparentview */
                if (in_array(substr($key, 0, -2), $module['moduleshowparentview'])) continue;

                /* skip remove if is moduleparentseqrel has in moduleshowparentview */
                if (in_array(substr($key, 0, -2), array_keys($controller->module['moduleparentseq'])) && in_array($module['moduleparentseqrel'][0], $module['moduleshowparentview'])) continue;
                elseif (in_array(substr($key, 0, -2), array_keys($controller->module['moduleparentseq'])))
                    unset($block_field['information'][$key]);

                if (in_array(substr($key, 0, -2), array_keys($controller->module['moduleparent'])))
                    unset($block_field['information'][$key]);
            }

            /**
             * filling fields data
             */
            /* foreach for blocks */
            foreach ($block_field as $item_key => $item_value) {
                /* foreach for fields */
                foreach ($item_value as $key => $value) {
                    if (strpos($key, '|') !== false) {
                        /* get language field info */
                        $languagefieldinfo = $this->getlanguagefieldinfo($key, $module['moduletabid']);
                        if (!$languagefieldinfo['lng']) continue;

                        /* get translate item */
                        $lng_record = \App\Translator::where('locale', $languagefieldinfo['lng'])
                            ->where('group', $tabinfo['tablename'])
                            ->where('item', $record[$languagefieldinfo['field_info']['name']])
                            ->value('text');
                        $block_field[$item_key][$key]['value'] = $lng_record;
                    } elseif ($key == 'attachment') {
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
                        $fieldvalue = $record->$key;
                        if ($value['type'] == 'date') {
                            $fieldvalue = $this->gregoriantojalali($fieldvalue);
                        }
//                        elseif ($value['type'] == 'textarea') $fieldvalue = json_decode($fieldvalue, true);
                        $block_field[$item_key][$key]['value'] = $fieldvalue;
                    }
                }
            }
            $block_field['information'][$module['moduleprimarykey']] = array('type' => 'hidden', 'required' => true, 'value' => $record[$module['moduleprimarykey']], 'readonly' => true);

            /* insert custom field */
            if ($tabinfo['usecustomfield']) {
                foreach ($module['moduleparent'] as $key => $value) {
                    $modulename = $key;
                    $moduleparent = $this->getmoduleinfo($modulename);

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
                            if ($fieldvalue && $item->columntype == 'date') {
                                $fieldvalue = $this->gregoriantojalali($fieldvalue);
                            }
//                            elseif ($value['type'] == 'textarea') $fieldvalue = json_decode($fieldvalue, true);
                            $_fieldinfo = array();
                            $_fieldinfo = $this->setfieldinfo($item->columntype, $fieldvalue);

                            $block_field['customfield'][$item->columnname] = $_fieldinfo;
                        }
                    }
                }
                foreach ($module['moduleparentseq'] as $key => $value) {
                    $modulename = $key;
                    $moduleparent = $this->getmoduleinfo($modulename);

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
                            if ($fieldvalue && $item->columntype == 'date') {
                                $fieldvalue = $this->gregoriantojalali($fieldvalue);
                            }
//                            elseif ($value['type'] == 'textarea') $fieldvalue = json_decode($fieldvalue, true);
                            $_fieldinfo = array();
                            $_fieldinfo = $this->setfieldinfo($item->columntype, $fieldvalue);

                            $block_field['customfield'][$item->columnname] = $_fieldinfo;
                        }
                    }
                }
            }
        }
        return array('block_field' => $block_field);
    }

    /**
     * save module data in record.
     *
     * @param  $module , $request
     * @return true
     */
    public function save($module, $request, $user_profileid = null)
    {
        $fields = self::getfield(self::getblockfield($module));
        /* get seq parent module primary key */
        $seqparentprimarykey = array();
        foreach ($module['moduleparentseq'] as $key => $value) {
            if (in_array($key, $module['moduleshowparentview'])) continue;
            $seqparentprimarykey[] = $key . 'id';
        }
        foreach ($module['moduleparent'] as $key => $value) {
            if (in_array($key, $module['moduleshowparentview'])) continue;
            $seqparentprimarykey[] = $key . 'id';
        }

        /* edit record */
        $language_field = array();
        if ($user_profileid)
            $record = $module['modulemodel']::where('user_profileid', $user_profileid)->find($request[$module['moduleprimarykey']]);
        else
            $record = $module['modulemodel']::find($request[$module['moduleprimarykey']]);
        $old_record = $record->toArray();

        foreach ($fields as $key => $value) {
            /* skip if is attachment field */
            if ($key == 'attachment') continue;
            /* skip if is parent field */
            if (in_array($key, $seqparentprimarykey)) continue;
            /* skip if is language field */
            if (strpos($key, '|') !== false) {
                $language_field[$key] = $value;
                continue;
            }
            $field_value = $request[$key];
            if ($value['type'] == 'currency') $field_value = str_replace(',', '', $field_value);
            elseif ($value['type'] == 'checkbox') $field_value = ($field_value == 'on') ? true : false;
            elseif ($value['type'] == 'date') {
                $field_value = str_replace('-', '/', $field_value);
                $field_value = $this->jalalitogregorian($field_value);
            }
//            elseif ($value['type'] == 'textarea') $field_value = json_encode($field_value);
            $record->$key = $field_value;
        }
        try {
            $record->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        /* insert new translate */
        if (count($language_field)) {
            $tabinfo = $this->gettabinfo($module['moduletabid']);
            foreach ($language_field as $key => $value) {
                if (!$request->$key) continue;
                /* get language field info */
                $languagefieldinfo = $this->getlanguagefieldinfo($key, $module['moduletabid']);
                if (!$languagefieldinfo['lng']) continue;

                /* get translate item */
                $lng_record = \App\Translator::where('locale', $languagefieldinfo['lng'])
                    ->where('group', $tabinfo['tablename'])
                    ->where('item', $old_record[$languagefieldinfo['field_info']['name']])
                    ->first();
                if ($lng_record){
                    /* update language source field */
                    $lng_record['item'] = $request[$languagefieldinfo['field_info']['name']];
                    $lng_record['text'] = $request->$key;
                } else {
                    $lng_record = new \App\Translator();
                    $lng_record['locale'] = $languagefieldinfo['lng'];
                    $lng_record['namespace'] = '*';
                    $lng_record['group'] = $tabinfo['tablename'];
                    $lng_record['item'] = $request[$languagefieldinfo['field_info']['name']];
                    $lng_record['text'] = $request->$key;
                    $lng_record['unstable'] = false;
                    $lng_record['locked'] = false;
                }
                try {
                    $lng_record->save();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        }

        /* save custom field */
        $request_value = $request->all();
        foreach ($request_value as $key => $value) {
            if (strpos($key, 'cf_') === 0) {
                $cffieldinfo = \App\Field::where('columnname', $key)->first();
                if ($cffieldinfo) {
                    $field_value = $value;
                    if ($cffieldinfo->columntype == 'currency') {
                        $field_value = str_replace(',', '', $field_value);
                    } elseif ($cffieldinfo->columntype == 'date') {
                        $field_value = str_replace('-', '/', $field_value);
                        $field_value = $this->jalalitogregorian($field_value);
                    }
                    $primarykey = $cffieldinfo->tablename . 'id';
                    DB::table($cffieldinfo->tablename)->updateOrInsert([$primarykey => $request[$module['moduleprimarykey']]], [$key => $field_value]);
                }
            }
        }

        /* insert new file */
        if ($module['moduleattachment'] == 1) {
            if ($request->hasFile('attachment')) {
                /* delete old attachment file */
                $old_attachment = Attachment::where('tabid', $module['moduletabid'])->where('ownerid', $record[$module['moduleprimarykey']])->first();
                if ($old_attachment)
                    $old_attachment->delete();

                /* upload new file */
                $file_path = $request->attachment->store('upload/' . $module['modulename']);

                $attachment = new Attachment();
                $attachment->path = $file_path;
                $attachment->tabid = $module['moduletabid'];
                $attachment->ownerid = $record[$module['moduleprimarykey']];
                try {
                    $attachment->save();
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
        } elseif ($module['moduleattachment'] == 2) {
            if ($request->hasFile('attachment')) {
                /* upload new file */
                foreach ($request->attachment as $attachment_item) {
                    $file_path = $attachment_item->store('upload/' . $module['modulename']);
                    $attachment = new Attachment();
                    $attachment->path = $file_path;
                    $attachment->tabid = $module['moduletabid'];
                    $attachment->ownerid = $record[$module['moduleprimarykey']];
                    try {
                        $attachment->save();
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
            }
        }

        if ($user_profileid) {
            $userid = $user_profileid;
        } elseif ($this->getcurrent_user(Auth::id())) {
            $current_user = $this->getcurrent_user(Auth::id());
            $userid = $current_user->user_profileid;
        } else {
            $userid = 0;
        }
        $recordid = $module['moduleprimarykey'];
        $this->savesystemtrackerrecord($module['moduletabid'], $userid, $record->$recordid, 2);
        return $record;
    }

    /**
     * delete records data.
     *
     * @param  $module , $ids
     * @return true, false
     */
    public function delete($module, $ids, $user_profileid = null)
    {
        if ($user_profileid) {
            $userid = $user_profileid;
        } elseif ($this->getcurrent_user(Auth::id())) {
            $current_user = $this->getcurrent_user(Auth::id());
            $userid = $current_user->user_profileid;
        } else {
            $userid = 0;
        }

        $array_id = explode(',', $ids);
        $recordid = $module['moduleprimarykey'];
        foreach ($array_id as $item) {
            if (!empty($item)) {
                /* check childs */
                $permission = true;
                if (count($module['modulechild']))
                    foreach ($module['modulechild'] as $child_key => $child_item) {
                        $child_module_info = self::getmoduleinfo($child_key);
                        $record = $child_module_info['modulemodel']::where($module['moduleprimarykey'], $item)->first();
                        if ($record) $permission = false;
                    }

                if ($permission) {
                    /* delete record */
                    if ($user_profileid)
                        $record = $module['modulemodel']::where('user_profileid', $user_profileid)->find($item) ?? abort(404);
                    else
                        $record = $module['modulemodel']::find($item) ?? abort(404);

                    try {
                        $record->delete();
                        $this->savesystemtrackerrecord($module['moduletabid'], $userid, $record->$recordid, 3);
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                    }

                    /* delete rel attachment for record */
                    if ($module['moduleattachment']) {
                        $attachment = Attachment::where('tabid', $module['moduletabid'])->where('ownerid', $record[$module['moduleprimarykey']])->get();
                        foreach ($attachment as $attachment_item) {
                            try {
                                $attachment_item->delete();
                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }
                        }
                    }
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * setfieldvalidation.
     *
     * @param  $module , $request
     * @return array
     */
    public function setfieldvalidation($module, $request, $path = null) // $path = controller; path -> like "\App\Http\Controllers\\"
    {
        $validationsign = '';
        $validationparams = array();
        $fields = self::getfield(self::getblockfield($module));
        $tabinfo = $this->gettabinfo($module['moduletabid']);
        /* get parent module info */
        if ($path)
            $controller = $this->getController($tabinfo['tablename'], $path);
        else
            $controller = $this->getController($tabinfo['tablename']);

        foreach ($fields as $key => $value) {
            /* remove parent field */
            if (in_array(substr($key, 0, -2), $module['moduleshowparentview'])) continue;
            if (in_array(substr($key, 0, -2), array_keys($controller->module['moduleparentseq'])))
                unset($fields[$key]);
        }

        foreach ($fields as $key => $value) {
            switch ($value['type']) {
                case 'email' :
                    $validationsign = array('email:rfc');
                    break;
                case 'number' :
                    $validationsign = array('numeric');
                    break;
                case 'select' :
                    $validationsign = ($value['translate']) ? array('string') : array('numeric', 'not_in:0');
                    break;
                default :
                    $validationsign = array('string');
                    break;
            }

            if ($value['required']) {
                $validationparams[$key][] = 'required';
                $validationparams[$key] = $validationsign;
            }
            /* translate validate */
            if (strpos($key, '|') === 2) {
                $parent_item = explode('|', $key);
                $parent_value = $request[$parent_item[1]];
                /* insert mode */
                if (!isset($request[$module['moduleprimarykey']])) {
                    $validationparams[$key][] = new \App\Rules\Translator($module, $parent_value);
                }
                /* edit mode */
                else {
                    $validationparams[$key][] = new \App\Rules\Translate_editor($module, $parent_value, $request[$module['moduleprimarykey']]);
                }
            }
        }
        /* if edit mode set mandatory primary key  */
        if ($request[$module['moduleprimarykey']]) {
            $validationparams[$module['moduleprimarykey']][] = 'required';
            $validationparams[$module['moduleprimarykey']][] = 'numeric';
        }
        /* if module has attachment set file size validate  */
        if ($request->attachment) $validationparams['attachment'][] = 'max:2048'; //2MB
        return $validationparams;
    }

    /**
     * delete attachment record.
     *
     * @type ajax
     * @param  $id
     * @return true, false
     */
    public function deleteattachment($id)
    {
        $record = Attachment::find($id);
        if ($record) {
            try {
                $record->delete();
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
            return 'true';
        }
        return 'false';
    }

    /**
     * get parent module chields.
     *
     * @type ajax
     * @param Request $request
     * @return data array
     */
    public function getChild(Request $request, $path = null) // $path = controller path -> like "\App\Http\Controllers\\"
    {
        $child_module_info = self::getmoduleinfo($request->childModule);
        /* get child module */
        /* get parent module info */
        if ($path)
            $controller = $this->getController($request->module, $path);
        else
            $controller = $this->getController($request->module);

        $modulechildfield = $controller->module['modulechild'][$request->childModule];

        $id = $request->id;
        $response = array();
        $primaryKey = $request->module . 'id';
        $relmodule_record = $child_module_info['modulemodel']::whereHas($request->module, function ($query) use ($id, $primaryKey) {
            $query->where($primaryKey, $id);
        })->get();

        foreach ($relmodule_record as $item) {
            if (count($modulechildfield) > 1) {
                $field_label = '';
                foreach ($modulechildfield as $value_label) {
                    $field_label = $field_label . ' ' . $item->$value_label;
                }
            } else {
                $field_label = $item[$modulechildfield[0]];
            }
            $response[$item[$child_module_info['moduleprimarykey']]] = $field_label;
        }

        return $response;
    }

    /**
     * get module controller variable.
     *
     * @param  $modulename
     * @return controller objects
     */
    public function getController($modulename, $path = "\App\Http\Controllers\\")
    {
        $controller = array();
        $class = $path . ucfirst($modulename) . "Controller";
        $controller = new $class;

        return $controller;
    }

    /**
     * create path for view.
     *
     * @param  $path
     * @return /view address
     */
    public function view($path, $perent = 'panel')
    {
        /* $temp[0] = folder, $temp[1] = view */
        $temp = explode('/', $path);
        $view = $perent . '/' . $temp[1];
        $base_path = base_path("resources/views/$perent/") . $temp[0];
        if (is_dir($base_path)) {
            $view_check = $perent . '/' . $path;
            if (view()->exists($view_check)) {
                $view = $view_check;
            }
        }
        return $view;
    }

    /**
     * get application module permission.
     *
     * @param  $moduletabid
     * @return $permission to view
     */
    public function permission($moduletabid)
    {
        $roleid = Auth::user()->roleid;
        $permission = \App\Permission::where('tabid', $moduletabid)->where('roleid', $roleid)->first();
        if ($permission) {
            if ($permission->show) {
                return $permission;
            }
        }
        return false;
    }

    /**
     * get module information.
     *
     * @param Request $modulename
     * @return data array
     */
    public function getmoduleinfo($modulename)
    {
        $info = array();
        $info['modulelabel'] = ucfirst($modulename);
        $info['modulemodel'] = 'App\\' . $info['modulelabel']; // create model name
        $info['moduleprimarykey'] = $modulename . 'id';
        $info['moduletabid'] = Tab::where('tablename', $modulename)->value('tabid');
        return $info;
    }

    /**
     * create field and set all information.
     *
     * @param $columntype , $fieldvalue
     * @return field data array
     */
    public function setfieldinfo($columntype, $fieldvalue = false)
    {
        $_fieldinfo = array();
        switch ($columntype) {
            case 'number':
                $_fieldinfo = array('type' => 'number', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'class' => '', 'data' => '');
                break;
            case 'textarea':
                $_fieldinfo = array('type' => 'textarea', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'placeholder' => '', 'class' => '', 'data' => '');
                break;
            case 'select':
                $_fieldinfo = array('type' => 'select', 'required' => false, 'value' => $fieldvalue, 'readonly' => true, 'option' => array('' => ''), 'translate' => false, 'multiple' => false, 'class' => '', 'data' => '');
                break;
            case 'multiselect':
                $_fieldinfo = array('type' => 'select', 'required' => false, 'value' => $fieldvalue, 'readonly' => true, 'option' => array('' => ''), 'translate' => false, 'multiple' => true, 'class' => '', 'data' => '');
                break;
            case 'checkbox':
                $_fieldinfo = array('type' => 'checkbox', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'class' => '', 'data' => '');
                break;
            case 'file':
                $_fieldinfo = array('type' => 'file', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'upload_type' => 'image', 'class' => '', 'data' => '');
                break;
            case 'multifile':
                $_fieldinfo = array('type' => 'file', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'upload_type' => 'image', 'multiple' => true, 'multiple_delete_url' => null, 'class' => '', 'data' => '');
                break;
            case 'password':
                $_fieldinfo = array('type' => 'password', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'class' => '', 'data' => '');
                break;
            case 'email':
                $_fieldinfo = array('type' => 'email', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'placeholder' => '', 'class' => '', 'data' => '');
                break;
            case 'time':
                $_fieldinfo = array('type' => 'time', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'class' => '', 'data' => '');
                break;
            case 'date':
                $_fieldinfo = array('type' => 'date', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'class' => '', 'data' => '');
                break;
            case 'currency':
                $_fieldinfo = array('type' => 'currency', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'class' => '', 'data' => '');
                break;
            case 'tags':
                $_fieldinfo = array('type' => 'tags', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'class' => '', 'data' => '');
                break;
            default:
                $_fieldinfo = array('type' => 'text', 'required' => false, 'value' => $fieldvalue, 'readonly' => false, 'placeholder' => '', 'class' => '', 'data' => '');
                break;
        }
        return $_fieldinfo;
    }

    /**
     * get module tab information.
     *
     * @param $tabid
     * @return array
     */
    public function gettabinfo($tabid)
    {
        $info = array();
        $info = Tab::where('tabid', $tabid)->first()->toArray();
        return $info;
    }

    /**
     * get module field.
     *
     * @param array $block_field
     * @return array
     */
    public function getfield($block_field)
    {
        $field = array();
        foreach ($block_field as $item) {
            foreach ($item as $key => $value) {
                $field[$key] = $value;
            }
        }
        return $field;
    }

    /**
     * get field information from database by field id.
     *
     * @param array $fieldid
     * @return array
     */
    public function getdbfieldinfobyid($fieldid)
    {
        $response = false;
        if ($fieldid) {
            $response = \App\Field::find($fieldid);
        }
        return $response;
    }

    /**
     * get field information from database by field name.
     *
     * @param $fieldname , $tabid
     * @return array
     */
    public function getdbfieldinfobyname($fieldname, $tabid)
    {
        $response = false;
        if ($fieldname && $tabid) {
            $response = \App\Field::where('name', $fieldname)->where('tabid', $tabid)->first();
        }
        return $response;
    }

    /**
     * get module blocks and fields.
     *
     * @param array tabid
     * @return array
     */
    public function getmoduleblockfield($tabid)
    {
        $block_field = array();
        $languages = $this->getlanguages();
        $block_field_db = \App\Field::with('block')->where('tabid', $tabid)->get();
        foreach ($block_field_db as $item) {
            $block_field[$item['block']['name']][$item['name']] = json_decode($item['option'], true);
            if ($item['translator']) {
                foreach ($languages as $lang_item) {
                    if ($lang_item['default']) continue;
                    $block_field[$lang_item['name']][$lang_item['locale'] . '|' . $item['name']] = json_decode($item['option'], true);
                }
            }
        }
        return $block_field;
    }

    /**
     * get panel languages.
     *
     * @param null
     * @return array
     */
    public function getlanguages()
    {
        $response = array();
        $languages = \App\Language::all();
        foreach ($languages as $item) {
            $response[] = array(
                'locale' => $item['locale'],
                'name' => $item['name'],
                'default' => $item['default'],
            );
        }
        return $response;
    }

    /**
     * get language field information.
     *
     * @param $name , $tabid
     * @return array
     */
    public function getlanguagefieldinfo($name, $tabid)
    {
        /* get field info */
        $tmp = explode('|', $name);
        $lng = ($tmp[0]) ? $tmp[0] : false;
        $fieldname = $tmp[1];
        $field_info = $this->getdbfieldinfobyname($fieldname, $tabid);
        $response = array(
            'lng' => $lng,
            'field_info' => $field_info
        );
        return $response;
    }

    /**
     * get current_user.
     *
     * @param $userid
     * @return array
     */
    public function getcurrent_user($userid, $relation = array('user', 'attachment'))
    {
        $current_user = \App\User_profile::with($relation)->where('userid', $userid)->first();
        //Check if user got saved
        if ($current_user) {
            if (!$current_user->username) {
                Redirect::to('/Username')->send();
            }
        } else {
            Redirect::to('/Username')->send();
        }

        return $current_user;
    }

    /**
     * convert jalali date to gregorian.
     *
     * @param $jalalidate
     * @return $gregoriandate
     */
    public function jalalitogregorian($jalalidate)
    {
//        try {
//            $date = explode('/', str_replace('-_.', '/', $jalalidate));
//            $gregoriandate = implode('-', CalendarUtils::toGregorian($date[0], $date[1], $date[2]));
//        } catch (\Exception $e) {
//            $gregoriandate = date('Y-m-d');
//        }
//
        return $jalalidate;
    }

    /**
     * convert gregorian date to jalali.
     *
     * @param $gregoriandate
     * @return $jalalidate
     */
    public function gregoriantojalali($gregoriandate = null)
    {
        $gregoriandate = date('Y-m-d', strtotime($gregoriandate));
//        try {
//            $date = str_replace('/-_.', '-', $gregoriandate);
//            $jalalidate = CalendarUtils::strftime('Y/m/d', strtotime($date));
//        } catch (\Exception $e) {
//            $jalalidate = CalendarUtils::strftime('Y/m/d', time());
//        }
        return $gregoriandate;
    }

    /**
     * save system tracker record.
     *
     * 1=create, 2=edit, 3=delete
     *
     * @param $tabid , $user_profileid, $recordid, $trackmod
     * @return false
     */
    public function savesystemtrackerrecord($tabid, $user_profileid, $recordid, $trackmod)
    {
//        try {
//            $record = new \App\Systemtracker();
//            $record->tabid = $tabid;
//            $record->user_profileid = $user_profileid;
//            $record->recordid = $recordid;
//            $record->trackmod = $trackmod;
//            $record->saveOrFail();
//        } catch (\Exception $e) {
//            dd($e);
//        }

        return false;
    }
}
