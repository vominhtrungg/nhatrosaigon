<?php

namespace WPEXtra\Modules;

class WPEX_SMTP {

	public function __construct() {
		if (wp_extra_get_option('smtp_options') && in_array('antispam', wp_extra_get_option('smtp_options'))) {
			add_action( 'wp_enqueue_scripts', [$this, 'smtpmail_scripts'], 99 );
		}

		$from_email = wp_extra_get_option('from_email');
		if ( ! empty( $from_email ) ) {
			add_filter(
				'wp_mail_from',
				function( $email ) use ( $from_email ) {
					return $from_email;
				}
			);
		}

		$from_name = wp_extra_get_option('from_name');
		if ( ! empty( $from_name ) ) {
			add_filter(
				'wp_mail_from_name',
				function( $email ) use ( $from_name ) {
					return $from_name;
				}
			);
		}

		add_action( 'phpmailer_init', [$this, 'process_mail' ] );
	}

	public function smtpmail_scripts() 
	{
		$anti_spam_form = in_array('antispam', (array) wp_extra_get_option('smtp_options'), true) ? 1 : 0;
		wp_enqueue_script( 'security', plugins_url('/assets/js/security.js', WPEX_FILE ),  array('jquery'), '1.2.13', true );
		wp_localize_script( 'security', 'security_setting', array('anti_spam_form' => $anti_spam_form) );
	}

	public function process_mail( $phpmailer ) {
		if (wp_extra_get_option('smtp') || wp_extra_get_option('smtp_source')) {
            if (wp_extra_get_option('smtp_source') == 1) {
                $phpmailer->Host       = "smtp.gmail.com";
                $phpmailer->Port       =  465;
                $phpmailer->SMTPSecure = "ssl";
                $phpmailer->SMTPAuth   = true;
            } elseif (wp_extra_get_option('smtp_source') == 2) {
                $phpmailer->Host       = "smtp.yandex.com";
                $phpmailer->Port       =  465;
                $phpmailer->SMTPSecure = "ssl";
                $phpmailer->SMTPAuth   = true;
            } else {
                $phpmailer->Host     = wp_extra_get_option('smtp_host');
                $phpmailer->Port = wp_extra_get_option('smtp_port');
                $phpmailer->SMTPSecure = wp_extra_get_option('smtp_encryption');
                $phpmailer->SMTPAuth = wp_extra_get_option('smtp_auth');
            };
			$phpmailer->Username = wp_extra_get_option('smtp_username');
			$phpmailer->Password = base64_decode(wp_extra_get_option('smtp_password'));
			if (in_array('noverifyssl', wp_extra_get_option('smtp_options'))) {
				$phpmailer->SMTPOptions = [
					'ssl' => [
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					]
				];
			}
			$phpmailer->IsSMTP();
		}

		return $phpmailer;
	}
}