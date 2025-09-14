<?php

namespace WPVNTeam\WPSettings\Options;

class Sizes extends OptionAbstract
{
    public $view = 'sizes';
    
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
