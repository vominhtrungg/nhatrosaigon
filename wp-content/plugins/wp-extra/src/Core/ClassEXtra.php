<?php

namespace WPEXtra\Core;

class ClassEXtra {

    private static $instance;

    public static function instance()
    {
        if (! isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    public function minify_css($css){
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
        return $css;
    }
    
    public function check_plugin_active( $file = '' ) 
	{
		if( $file == '' || file_exists( ABSPATH . 'wp-content/plugins/' . $file ) == false ) {
			return false;
		}

		if( function_exists('is_plugin_active') == false ) {
			include( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		
		return is_plugin_active( $file );
	}

    public function isPro() {
        return $this->check_plugin_active('wp-extra-pro/wp-extra-pro.php');
    }
    
}