<?php

namespace WPEXtra\Modules;

use WPEXtra\Core\ClassEXtra;

class WPEX_Security {

	public function __construct() {
		if (wp_extra_get_option('page_extension')) {
			add_action('init', [$this, 'init_page_slash'], -1);
            add_filter('user_trailingslashit', [$this, 'no_page_slash'], 66, 2);
        }
      
		if (wp_extra_get_option('disable_embeds')) {
			add_action('init', [$this, 'disableEmbeds'], 9999);
		}
		if(wp_extra_get_option('disable_xmlrpc')) {
			add_filter('xmlrpc_enabled', '__return_false');
			add_filter('wp_headers', [$this, 'removeXpingback']);
			add_filter('pings_open', '__return_false', 9999);
			add_filter('pre_update_option_enable_xmlrpc', '__return_false');
			add_filter('pre_option_enable_xmlrpc', '__return_zero');
			add_filter('wpex_output_buffer_template_redirect', [$this, 'removePingbackLinks'], 2);
			add_action('init', [$this, 'interceptXmlrpcHeader']);
		}
		
		if(wp_extra_get_option('remove_jquery_migrate')) {
			add_filter('wp_default_scripts', [$this, 'removeJqueryMigrate']);
		}
		if(wp_extra_get_option('remove_wp_version')) {
			remove_action('wp_head', [$this, 'wp_generator']);
			add_filter('the_generator', [$this, 'hideWPversion']);
		}
		if(wp_extra_get_option('remove_wlwmanifest_link')) {
			remove_action('wp_head', [$this, 'wlwmanifest_link']);
		}
		if(wp_extra_get_option('remove_rsd_link')) {
			remove_action('wp_head', [$this, 'rsd_link']);
		}
		if(wp_extra_get_option('remove_shortlink')) {
			remove_action('wp_head', [$this, 'wp_shortlink_wp_head']);
			remove_action ('template_redirect', [$this, 'wp_shortlink_header'], 11, 0);
		}
		if(wp_extra_get_option('disable_rss_feeds')) {
			add_action('template_redirect', [$this, 'disableRSSFeeds'], 1);
		}
		if(wp_extra_get_option('remove_feed_links')) {
			remove_action('wp_head', [$this, 'feed_links'], 2);
			remove_action('wp_head', [$this, 'feed_links_extra'], 3);
		}
		if(wp_extra_get_option('disable_self_pingbacks')) {
			add_action('pre_ping', [$this, 'disableSelfPingbacks']);
		}

		if(wp_extra_get_option('disable_rest_api')) {
			add_filter('rest_authentication_errors', [$this, 'restAuthenticationErrors'], 20);
		}
		if(wp_extra_get_option('remove_rest_api_links')) {
			remove_action('xmlrpc_rsd_apis', [$this, 'rest_output_rsd']);
			remove_action('wp_head', [$this, 'rest_output_link_wp_head']);
			remove_action('template_redirect', [$this, 'rest_output_link_header'], 11, 0);
		}
		if(wp_extra_get_option('disable_heartbeat')) {
			add_action('init', [$this, 'disableHeartbeat'], 1);
		}
		if(wp_extra_get_option('heartbeat_frequency')) {
			add_filter('heartbeat_settings', [$this, 'heartbeatFrequency']);
		}
		
		if(wp_extra_get_option('themeplugin_edits')) {
			if(defined('DISALLOW_FILE_EDIT') || defined('DISALLOW_FILE_MODS')) {
				add_action('admin_notices', [$this, 'notice_disallow_file']);
			} else {
				define( 'DISALLOW_FILE_EDIT', true );
				define( 'DISALLOW_FILE_MODS', true );
			}
		}
		if(wp_extra_get_option('core_updates')) {
			if(defined('WP_AUTO_UPDATE_CORE')) {
				add_action('admin_notices', [$this, 'notice_auto_update_core']);
			} else {
				define( 'WP_AUTO_UPDATE_CORE', false );
			}
		}
		if(wp_extra_get_option('donot_copy')) {
			add_action( 'wp_enqueue_scripts', [$this, 'donot_scripts']);
		}
		if(wp_extra_get_option('restricted_backend')) {
			add_action( 'admin_init', [$this, 'redirect_non_admin_user']);
		}
		
        if(wp_extra_get_option('cookie')) {
            add_action( 'wp_enqueue_scripts', [$this, 'cookie_enqueue_scripts'] );
            add_action('wp_footer', [$this, 'display_cookie_info']);
            add_action( 'init', [$this, 'display_cookie_notice']);
        }
    }
    
    public function init_page_slash() {
        global $wp_rewrite;
        $page_slash = wp_extra_get_option('page_slash') ? wp_extra_get_option('page_slash') : '.html';
        if (!strpos($wp_rewrite->get_page_permastruct(), $page_slash)) {
            $wp_rewrite->page_structure = $wp_rewrite->page_structure . $page_slash;
        }
    }
    
    public function no_page_slash($string, $type) {
        global $wp_rewrite;
        if ($wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes == true && $type == 'page') {
            return untrailingslashit($string);
        }
        return $string;
    }

	public function disableEmbeds() {
		global $wp;
		$wp->public_query_vars = array_diff($wp->public_query_vars, array('embed'));
		add_filter('embed_oembed_discover', '__return_false');
		remove_filter('oembed_dataparse', [$this, 'wp_filter_oembed_result'], 10);
		remove_action('wp_head', [$this, 'wp_oembed_add_discovery_links']);
		remove_action('wp_head', [$this, 'wp_oembed_add_host_js']);
		add_filter('tiny_mce_plugins', [$this, 'disableEmbedsTinyMCE']);
		add_filter('rewrite_rules_array', [$this, 'disableEmbedsRewrites']);
		remove_filter('pre_oembed_result', [$this, 'wp_filter_pre_oembed_result'], 10);
	}

	public function disableEmbedsTinyMCE($plugins) {
		return array_diff($plugins, array('wpembed'));
	}

	public function disableEmbedsRewrites($rules) {
		foreach($rules as $rule => $rewrite) {
			if(false !== strpos($rewrite, 'embed=true')) {
				unset($rules[$rule]);
			}
		}
		return $rules;
	}

	public function removeXpingback($headers) {
		unset($headers['X-Pingback'], $headers['x-pingback']);
		return $headers;
	}

	public function interceptXmlrpcHeader() {
		if(!isset($_SERVER['SCRIPT_FILENAME'])) {
			return;
		}
		if('xmlrpc.php' !== basename($_SERVER['SCRIPT_FILENAME'])) {
			return;
		}
		$header = 'HTTP/1.1 403 Forbidden';
		header($header);
		echo $header;
		die();
	}

	public function hideWPversion() {
		return '';
	}

	public function removeJqueryMigrate(&$scripts) {
		if(!is_admin()) {
			$scripts->remove('jquery');
			$scripts->add('jquery', false, array( 'jquery-core' ), '1.12.4');
		}
	}


	public function disableRSSFeeds() {
		if(!is_feed() || is_404()) {
			return;
		}
		global $wp_rewrite;
		global $wp_query;

		if(isset($_GET['feed'])) {
			wp_redirect(esc_url_raw(remove_query_arg('feed')), 301);
			exit;
		}

		if(get_query_var('feed') !== 'old') {
			set_query_var('feed', '');
		}
		
		redirect_canonical();

        // Translators: %s is a placeholder for the homepage URL.
		wp_die(sprintf(__("No feed available, please visit the <a href='%s'>homepage</a>!"), esc_url(home_url('/'))));
	}

	public function disableSelfPingbacks(&$links) {
		$home = get_option('home');
		foreach($links as $l => $link) {
			if(strpos($link, $home) === 0) {
				unset($links[$l]);
			}
		}
	}

	public function restAuthenticationErrors($result) {
        if (!empty($result)) {
            return $result;
        } else {
            $disabled = false;
            $rest_route = $GLOBALS['wp']->query_vars['rest_route'];
            $exceptions = apply_filters('wpex_rest_api_exceptions', array(
                'contact-form-7',
                'wordfence',
                'elementor'
            ));

            foreach ($exceptions as $exception) {
                // Check if $rest_route is an array before using in_array
                if (is_array($rest_route) && in_array($exception, $rest_route)) {
                    return;
                }
            }

            $disableOptions = wp_extra_get_option('disable_rest_api');

            // Ensure $disableOptions is an array
            if (!is_array($disableOptions)) {
                $disableOptions = array();
            }

            if (in_array('non_admins', $disableOptions) && !current_user_can('manage_options')) {
                $disabled = true;
            } elseif (in_array('logged_out', $disableOptions) && !is_user_logged_in()) {
                $disabled = true;
            }
        }

        if ($disabled) {
            return new WP_Error('rest_authentication_error', __('Sorry, you do not have permission to make REST API requests.', 'wp-extra'), array('status' => 401));
        }

        return $result;
    }


	public function disableHeartbeat() {
		if(is_admin()) {
			global $pagenow;
			if(!empty($pagenow)) {
				if($pagenow == 'admin.php') {
					if(!empty($_GET['page'])) {
						$exceptions = array(
							'gf_edit_forms',
							'gf_entries',
							'gf_settings'
						);
						if(in_array($_GET['page'], $exceptions)) {
							return;
						}
					}
				}
				if($pagenow == 'site-health.php') {
					return;
				}
			}
		}
		if(wp_extra_get_option('disable_heartbeat')) {
			if(wp_extra_get_option('disable_heartbeat') == 'everywhere') {
				$this->replaceHearbeat();
			}
			elseif(wp_extra_get_option('disable_heartbeat') == 'allow_posts') {
				global $pagenow;
				if($pagenow != 'post.php' && $pagenow != 'post-new.php') {
					$this->replaceHearbeat();
				}
			}
		}
	}

	public function replaceHearbeat() {
		wp_deregister_script('heartbeat');
		if(is_admin() && wp_extra_get_option('disable_heartbeat')) {
			wp_register_script('hearbeat', plugins_url('/assets/js/heartbeat.js', WPEX_FILE ));
			wp_enqueue_script('hearbeat', plugins_url('/assets/js/heartbeat.js', WPEX_FILE ));
		}
	}

	public function heartbeatFrequency($settings) {
		if(wp_extra_get_option('heartbeat_frequency')) {
			$settings['interval'] = wp_extra_get_option('heartbeat_frequency');
		}
		return $settings;
	}

	public function notice_disallow_file() {
		$message = sprintf(
			'<div class="notice notice-error"><p><strong>%s</strong> %s %s</p></div>',
			__('Warning:'),
			__('DISALLOW_FILE_EDIT / DISALLOW_FILE_MODS'),
			__('is already enabled somewhere else on your site. We suggest only enabling this feature in one place.', 'wp-extra')
		);
	
		echo $message;
	}

	public function notice_auto_update_core() {
		$message = sprintf(
			'<div class="notice notice-error"><p><strong>%s</strong> %s %s</p></div>',
			__('Warning:'),
			__('WP_AUTO_UPDATE_CORE'),
			__('is already enabled somewhere else on your site. We suggest only enabling this feature in one place.', 'wp-extra')
		);
	
		echo $message;
	}

    public function donot_scripts() {
		if ( current_user_can( 'manage_options' ) ) {
			return;
		}
		$copyright = wp_extra_get_option('donot_copyright') ? wp_extra_get_option('donot_copyright') : 'WP EXtra';
		$select_text = wp_extra_get_option('donot_content') ? true : false;
		wp_enqueue_script( 'donotcopy', plugins_url( '/assets/js/copyright.js', WPEX_FILE ), array( 'jquery' ) );
		wp_localize_script( 'donotcopy', 'wpEXtra', array( 'copyright' => $copyright, 'select_text' => $select_text ) );
	}

	public function redirect_non_admin_user(){
		if ( !defined( 'DOING_AJAX' ) && !current_user_can('administrator') ){
			wp_redirect( site_url() );  exit;
		} 
	}
    
    public function display_cookie_notice() {
        if ( isset( $_POST['ex-cookie-privacy-policy'] ) ) {
            wp_safe_redirect( get_privacy_policy_url() );
            exit;
        }
    }
    
    public function cookie_enqueue_scripts() {
        if ( !isset( $_COOKIE['cookie-accepted'] ) ) {
            wp_enqueue_style( 'cookie', plugins_url( '/assets/css/cookie.css', WPEX_FILE ) );
			wp_enqueue_script('cookie', plugins_url( '/assets/js/cookie.js', WPEX_FILE ), array(), time(), true );
        }
    }
    
    public function display_cookie_info() {
        $cookie_message = wp_extra_get_option( 'cookie_message', __('This site uses cookies to improve your online experience, allow you to share content on social media, measure traffic to this website and display customised ads based on your browsing activity.', 'wp-extra') );
        $cookie_info_button = wp_extra_get_option( 'cookie_button', __('Accept Cookies', 'wp-extra' ));
        $show_policy_privacy = wp_extra_get_option( 'cookie_privacy' );
        $background_color = wp_extra_get_option( 'cookie_bgcolor', '#ffffff' );
        $text_color = wp_extra_get_option( 'cookie_textcolor', '#666666' );
        $button_background_color = wp_extra_get_option( 'cookie_btnbgcolor', '#1e58b1' );
        $button_text_color = wp_extra_get_option( 'cookie_btntextcolor', '#ffffff' );
        $cookie_info_placemet = wp_extra_get_option( 'cookie_placement', 'bottom' );
        $cookie_expire_time = wp_extra_get_option( 'cookie_expire', '30' );
    ?>
    <div class="cookie-box cookie-hidden" style="<?php echo 'background-color: '.esc_attr( $background_color ).'; '.esc_attr( $cookie_info_placemet ).': 0' ?>" id="cookie-box">
        <form method="post" id="cookie-form"> 
            <div id="extra-cookie-info" style="<?php echo 'color: '.esc_attr( $text_color ) ?>"><?php echo $cookie_message; ?></div>
            <div id="cookie-notice-button">
                <?php if ( $show_policy_privacy ) { ?>
                <button type="submit" name="ex-cookie-privacy-policy" class="extra-cookie-privacy-policy" id="cookie-privacy-policy" style="<?php echo 'border: 1px solid '.esc_attr( $button_background_color ).';color: '.esc_attr( $button_background_color ) ?>">
                <?php esc_html_e( 'Privacy Policy' ) ?>
                </button>
                <?php } ?>
                <button type="submit" name="ex-cookie-accept-button" class="extra-cookie-accept-button" id="cookie-accept-button" style="<?php echo 'background-color: '.esc_attr( $button_background_color ).';color: '.esc_attr( $button_text_color )  ?>" data-expire="<?php echo esc_html( $cookie_expire_time ) ?>">
                <?php echo $cookie_info_button; ?>
                </button>
            </div>
        </form>
    </div>
    <?php
    }

}