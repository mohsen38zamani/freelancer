<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Translator implements Rule
{
    protected $module;
    protected $parent_value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($module, $parent_value)
    {
        $this->module = $module;
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
        $condition = array(
            'locale' => $lang,
            'group' => $this->module['modulename'],
            'item' => $this->parent_value
        );
        $result = \App\Translator::where($condition)->first();
        if ($result) {
            $this->existing_module = $result->group;
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
