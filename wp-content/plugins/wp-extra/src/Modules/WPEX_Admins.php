<?php

namespace WPEXtra\Modules;

use WPEXtra\Core\ClassEXtra;

class WPEX_Admins {
    public function __construct() {
        add_action( 'admin_bar_menu', [$this, 'removeNodes'], 999);
        
        if (wp_extra_get_option('wp_adminbar_visible')) {
           add_action('get_header', [$this, 'wpAdminbar_filter']);
        }
        if (wp_extra_get_option('wp_adminbar_visible') && in_array('site-admin',  wp_extra_get_option('wp_adminbar_visible'))) {
            add_action( 'admin_enqueue_scripts',  [$this, 'wpAdminbar' ]);
        }
        if (wp_extra_get_option('wp_adminbar_visible') && in_array('homepage',  wp_extra_get_option('wp_adminbar_visible'))) {
            add_action( 'wp_enqueue_scripts',  [$this, 'wpAdminbar' ]);
        }
        if(wp_extra_get_option('adminfooter_version')) {
            add_filter( 'update_footer', '__return_empty_string', 11 );
        }
        
        if(wp_extra_get_option('adminfooter_extra') && wp_extra_get_option('adminfooter_custom')) {
            add_filter( 'admin_footer_text', [$this, 'wpex_footer_text']);
        } else {
            add_filter( 'admin_footer_text', [$this, 'wpex_footer_text']);
        }
        add_action( 'admin_bar_menu', [$this, 'vnex_adminbar_menu'], 150 );
    }

    
    public function vnex_adminbar_menu( $meta = true ) {  
        global $wp_admin_bar;  
        if ( ! is_user_logged_in() ) { return; }  
        if ( ! is_super_admin() || ! is_admin_bar_showing() ) { return; }  
        $pro_check = ClassEXtra::instance();
        if ($pro_check->isPro()) { return; } 
        $wp_admin_bar->add_menu( array(   
            'id'     => 'wp-extra',
            'title'  => __('❤ WP EXtra Pro'),
            'href'   => 'https://wpvnteam.com/downloads/wp-extra-pro/',
            'meta'   => array( 'target' => '_blank' )
        ) );  
    }
    
    
    public function removeNodes($wp_admin_bar) {
        $toolbar_options = wp_extra_get_option('wp_toolbar');
        if ($toolbar_options) {
            foreach ($toolbar_options as $menu_id) {
                $wp_admin_bar->remove_node($menu_id);
            }
        }
    }

    public function wpAdminbar_filter() {
        remove_action('wp_head', '_admin_bar_bump_cb');
    } 

    public function wpAdminbar() {
        $EXtra = ClassEXtra::instance();
        $wpex_css = "";
    
        if(wp_extra_get_option('wp_adminbar') && !wp_extra_get_option('wp_adminbar_auto')) {
            $wpex_css .= "
                html.wp-toolbar {
                    padding-top: 0 !important;
                }
                #adminmenu {
                    margin: 0 !important;
                }
                .show-admin-bar {
                    display: none;
                } 
                #wpadminbar { 
                    display:none; 
                }
                @media (min-width: 850px) {
                    .mfp-content, .stuck, button.mfp-close {
                        margin-top: -32px!important;
                    }
                }
                ";

        } 
        wp_add_inline_style('admin-bar', $EXtra->minify_css($wpex_css));
    }
    
    public function wpex_footer_text() {
        $content = '';
        if(wp_extra_get_option('adminfooter_custom')) {
            $content .= wp_kses_post(wp_extra_get_option('adminfooter_custom'));
        } else {
            // Translators: %s is a placeholder for a link to give a star review.
            $content .= sprintf(__('If you like ❤ <strong>WP EXtra</strong>, please give it a %s .Thanks!', 'wp-extra'), 
            '<a target="_blank" href="https://wordpress.org/support/plugin/wp-extra/reviews/?filter=5#new-post"> ★ ★ ★ ★ ★ review</a>');
        }
        return $content;
    }

}