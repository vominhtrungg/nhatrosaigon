<?php

namespace WPVNTeam\WPSettings\Options;

class Tools extends OptionAbstract
{
    public $view = 'tools';
    
    public function __construct($section, $args = [])
    {
        parent::__construct($section, $args);
    }
	
    private function check_permissions() {
        if (!is_admin() || !current_user_can('manage_options')) {
            return __('You need a higher level of permission.');
        }
    }
    
    public function ToolImport($data)
    {
        $permission_check = $this->check_permissions();
        $nonce = isset($_POST['_wpnonce_import']) ? $_POST['_wpnonce_import'] : '';
        if (!wp_verify_nonce($nonce, 'import_tool_action')) {
            wp_die('Security check failed. Please try again.');
        }
        if ($permission_check) {
            add_action('admin_notices', function() use ($permission_check) {
                echo '<div class="notice notice-error is-dismissible"><p>' . $permission_check . '</p></div>';
            });
            return;
        }
    
		$settings_json = unserialize(base64_decode($data));
        $settings_array = json_decode($settings_json, true);
    
        if ($settings_array) {
            update_option($this->section->tab->settings->option_name, $settings_array);
            add_action('admin_notices', function() {
                echo '<div class="notice notice-success is-dismissible"><p>' . __('Request added successfully.') . '</p></div>';
            });
        } else {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-error is-dismissible"><p>' . __('Invalid translation type.') . '</p></div>';
            });
        }
    }
    
    public function ToolReset()
    {
        $permission_check = $this->check_permissions();
        $nonce = isset($_POST['_wpnonce_reset']) ? $_POST['_wpnonce_reset'] : '';
        if (!wp_verify_nonce($nonce, 'reset_tool_action')) {
            wp_die('Security check failed. Please try again.');
        }

        if ($permission_check) {
            add_action('admin_notices', function() use ($permission_check) {
                echo '<div class="notice notice-error is-dismissible"><p>' . $permission_check . '</p></div>';
            });
            return;
        }
        
        delete_option($this->section->tab->settings->option_name);
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Confirmation request initiated successfully.') . '</p></div>';
        });
    }
}
