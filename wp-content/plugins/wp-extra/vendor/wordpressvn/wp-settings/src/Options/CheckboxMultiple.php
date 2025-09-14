<?php

namespace WPVNTeam\WPSettings\Options;

class CheckboxMultiple extends OptionAbstract
{
    public $view = 'checkbox-multiple';

    public function get_name_attribute()
    {
        $name = parent::get_name_attribute();

        return "{$name}[]";
    }

    public function sanitize($value)
    {
        return (array) $value;
    }
}
