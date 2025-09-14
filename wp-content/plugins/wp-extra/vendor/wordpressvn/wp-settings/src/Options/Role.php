<?php

namespace WPVNTeam\WPSettings\Options;

class Role extends OptionAbstract
{
    public $view = 'role';

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
