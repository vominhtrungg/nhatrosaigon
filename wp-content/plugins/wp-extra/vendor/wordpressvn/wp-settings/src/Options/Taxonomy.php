<?php

namespace WPVNTeam\WPSettings\Options;

class Taxonomy extends OptionAbstract
{
    public $view = 'taxonomy';

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
