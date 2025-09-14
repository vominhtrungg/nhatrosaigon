<?php

namespace WPVNTeam\WPSettings\Options;

class PostType extends OptionAbstract
{
    public $view = 'post-type';

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
