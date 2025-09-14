<?php

namespace WPEXtra;

class WPEXtra
{
    private static $instance;

    public static function instance()
    {
        if (! isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->boot();
        add_action('activated_plugin', [$this, 'activate_plugin_redirect']);
        add_action('plugins_loaded', [$this, 'loadTextDomain']);
		add_filter('plugin_action_links_' . plugin_basename(WPEX_FILE), [$this, 'plugin_action_links']);
        add_filter('plugin_row_meta', [$this, 'plugin_row_meta'], 10, 2 );
        if (wp_extra_get_option('mode')) {
            add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        }
    }
    
    function admin_enqueue_scripts() {
        ?><style>#nav-cop .nav-menu .nav-item span, .pro {display: none}</style><?php
    }
    
    public function activate_plugin_redirect( $plugin_file ) {
        if( !wp_doing_ajax() && $plugin_file == plugin_basename( WPEX_FILE ) ) {
            wp_safe_redirect( admin_url( 'admin.php?page=wp-extra' ) );
            exit();
        }
    }

    public function loadTextdomain()
    {
        load_plugin_textdomain('wp-extra', false, dirname(plugin_basename(WPEX_FILE)) . '/languages/');
    }

    public function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wp-extra' ) . '">' .__( 'Settings' ) . '</a>',
		);
		return array_merge( $action_links, $links );
	}

    public function plugin_row_meta($plugin_meta, $plugin_file) {
        if ((plugin_basename(WPEX_FILE) === $plugin_file) && !wp_extra_key()) {
            $row_meta = array(
                '<a href="https://wpvnteam.com/donate/" target="_blank">✪ ' .__('Donate to this plugin &#187;') . '</a>',
            );

            $row_meta[] = '<a href="https://wpvnteam.com/downloads/wp-extra-pro/" target="_blank"><strong style="color:#d54e21;font-weight:bold">' .__('Go Premium') . '</strong></a>';

            return array_merge($plugin_meta, $row_meta);
        }

        return $plugin_meta;
    }
     
    public function boot()
    {
        new Settings();
        $enabledModules = wp_extra_get_option('modules');
        $modules = [
            'dashboard' => Modules\WPEX_Dashboards::class,
            'posts' => Modules\WPEX_Posts::class,
            'media' => Modules\WPEX_Media::class,
            'code' => Modules\WPEX_Code::class,
            'admins' => Modules\WPEX_Admins::class,
            'logins' => Modules\WPEX_Logins::class,
            'comments' => Modules\WPEX_Comments::class,
            'security' => Modules\WPEX_Security::class,
            'optimize' => Modules\WPEX_Optimize::class,
            'tools' => Modules\WPEX_Tools::class,
            'smtp' => Modules\WPEX_SMTP::class,
        ];
        foreach ($modules as $key => $class) {
            if (is_string($key) && $enabledModules && in_array($key, $enabledModules)) {
                new $class;
            }
        }
    }

}