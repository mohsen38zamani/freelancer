<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Translate_editor implements Rule
{
    protected $module;
    protected $recordid;
    protected $parent_value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($module, $parent_value, $recordid)
    {
        $this->module = $module;
        $this->recordid = $recordid;
        $this->parent_value = $parent_value;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = true;
        if (!$value) return $response;
        $item = explode('|', $attribute);
        $lang = $item[0];
        $field_name = $item[1];
        $record = $this->module['modulemodel']::where($this->module['moduleprimarykey'], $this->recordid)->first();

        /* get translate item */
        $condition = array(
            'locale' => $lang,
            'group' => $this->module['modulename'],
            'item' => $this->parent_value
        );
        $result = \App\Translator::where($condition)->first();

        if ($result && $result->item != $record->$field_name) {
            $response = false;
        }
        return $response;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Translation is exist in ' . $this->module['modulename'] . ' module';
    }
}
