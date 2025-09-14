<?php

namespace WPEXtra;

use WPEXtra\Core\ClassEXtra;
use WPVNTeam\WPSettings\WPSettings;
use WPEXtra\WPSettings\Admins;
use WPEXtra\WPSettings\Sizes;
use WPEXtra\WPSettings\SMTP;
use WPEXtra\WPSettings\Import;

class Settings
{
    public function __construct()
    {
        add_filter('wp_settings_option_type_map', function($options){
            $options['admins'] = Admins::class;
            $options['sizes'] = Sizes::class;
            $options['smtp'] = SMTP::class;
            $options['import'] = Import::class;
            return $options;
        });
        add_action('admin_menu', [$this, 'register'], 10);
    }

    public function register()
    {
        $settings = new WPSettings(__('WP EXtra'));
        $settings->set_menu_icon('dashicons-superhero-alt');
        $settings->set_menu_position(80);
        $settings->set_version(WPEX_VERSION);
        $settings->set_lite('cop-lite');
        
        $tab = $settings->add_tab('<span class="dashicons dashicons-superhero-alt"></span>'.__('Modules'));
        $section = $tab->add_section('');
        $section->add_option('checkbox-multiple', [
            'name' => 'modules',
            'options' => [
                'dashboard'	=> '<span class="dashicons dashicons-dashboard"></span> '.__('Dashboard'),
				'media'	=> '<span class="dashicons dashicons-admin-media"></span> '.__( 'Media' ),
				'posts'	=> '<span class="dashicons dashicons-admin-post"></span> '.__( 'Posts' ),
				'admins'	=> '<span class="dashicons dashicons-admin-settings"></span> '.__('Site Admin'),
				'logins'	=> '<span class="dashicons dashicons-admin-appearance"></span> '.__('Log in'),
				'comments'	=> '<span class="dashicons dashicons-admin-comments"></span> '.__('Comments'),
				'security'	=> '<span class="dashicons dashicons-privacy"></span> '.__('Security'),
				'smtp'	=> '<span class="dashicons dashicons dashicons-email"></span> '.__('SMTP'),
				'optimize'	=> '<span class="dashicons dashicons-superhero"></span> '.__( 'Optimize', 'wp-extra' ),
				'code'	=> '<span class="dashicons dashicons-editor-code"></span> '.__( 'Code' ),
				'tools'	=> '<span class="dashicons dashicons-controls-repeat"></span> '.__( 'Tools' ),
            ],
            'label' => __('Modules')
        ]);
        $section->add_option('checkbox', [
            'name' => 'mode',
            'label' => __('Basic Mode', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        
    if (wp_extra_get_option('modules') && in_array('dashboard',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-dashboard"></span>'.__('Dashboard'));
        $section = $tab->add_section('');
        $section->add_option('checkbox', [
            'name' => 'dashboard',
            'label' => __('All Dashboard', 'wp-extra'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'dashboard_welcome',
            'label' => __('Admin Notice', 'wp-extra'),
            'description' => __('Hide').'. '.__('Welcome to your WordPress Dashboard!')
        ]);
        $section->add_option('text', [
            'name' => 'dashboard_title',
            'css' => ['hide_class' => 'dashboard_welcome hidden pro', 'input_class' => 'regular-text' ],
            'label' => __('Add title')
        ]);
        $section->add_option('wp-editor', [
            'name' => 'dashboard_content',
            'css' => ['hide_class' => 'dashboard_welcome hidden'],
            'label' => __('Add to Widget')
        ]);
        $section->add_option('text', [
            'name' => 'dashboard_rss_feed',
            'css' => ['hide_class' => 'dashboard_welcome hidden pro', 'input_class' => 'regular-text' ],
            'label' => __('RSS Feed')
        ]);
        $section->add_option('checkbox', [
            'name' => 'tab_help',
            'label' => __('Help'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'tab_screen',
            'label' => __('Screen Options'),
            'description' => __('Hide')
        ]);
    }

    if (wp_extra_get_option('modules') && in_array('posts',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-admin-post"></span>'.__('Posts'));
        $section = $tab->add_section(__('Editor toolbar'));
        $section->add_option('checkbox', [
            'name' => 'mce_classic',
            'label' => __('Classic Editor'),
            'description' => __('Use the classic WordPress editor.', 'wp-extra')
        ]);
        $section->add_option('checkbox-multiple', [
            'name' => 'mce_plugin',
            'label' => __('TinyMCE Plugins', 'wp-extra'),
            'options' => [
                'justify'	=> '<span class="dashicons dashicons-editor-justify"></span> '.__('Justify'),
				'unlinks'	=> '<span class="dashicons dashicons-editor-unlink"></span> '.__( 'Unlinks' ),
				'letterspacing'	=> '<strong>[VA]</strong> '.__( 'Letter Spacing' ),
				'changecase'	=> '<strong>[Aa]</strong> '.__('Change Case'),
				'table'	=> '<span class="dashicons dashicons-editor-table"></span> '.__('Table'),
				'visualblocks'	=> '<span class="dashicons dashicons-editor-paragraph"></span> '.__('Visual Blocks'),
				'searchreplace'	=> '<span class="dashicons dashicons-code-standards"></span> '.__('Search Replace'),
				'nofollow'	=> '<span class="dashicons dashicons-admin-links"></span> '.__('Add rel=nofollow & sponsored', 'wp-extra'),
				'cleanhtml'	=> '<span class="dashicons dashicons-editor-spellcheck"></span> '.__('Clean HTML', 'wp-extra').'<code>PRO</code>',
            ],
        ]);
        $section->add_option('checkbox', [
            'name' => 'signature',
            'label' => __('Signature', 'wp-extra'),
            'description' => sprintf(__('Used %1$s or %2$s','wp-extra'),
                '<code>[signature]</code>',
                '<span class="dashicons dashicons-heart"></span>'
            )
        ]);
        $section->add_option('wp-editor', [
            'name' => 'signature_content',
            'teeny' => true,
            'css' => ['hide_class' => 'signature hidden'],
            'label' => __('Content')
        ]);
        $section->add_option('choices', [
            'name' => 'signature_pos',
            'options' => [
                '' => __( 'Shortcode' ),
                'top'	=> __( 'Top' ),
				'bottom'	=> __( 'Bottom' )
            ],
            'label' => __('Display Options'),
            'css' => ['hide_class' => 'signature hidden']
        ]);
        if ( wp_get_theme()->template !== 'flatsome' ) {
            $section->add_option('checkbox', [
                'name' => 'classic_widget',
                'label' => __('Classic Widgets','wp-extra'),
                'description' => __('Display a legacy widget.', 'wp-extra')
            ]);
        }
        $section->add_option('post-type', [
            'name' => 'publish_btn',
            'exclude' => ['attachment'],
            'label' => __('Publish Button', 'wp-extra'),
            'description' => __('Making it stick to the bottom of the page when scrolling down the page', 'wp-extra')
        ]);
        
        $section = $tab->add_section(__('Posts Page'));
        $section->add_option('select', [
            'name' => 'limit_post_revisions',
            'options' => [
                ''      => __('No limit','wp-extra') . ' (' . __('Default') . ')',
                'false' => __('Disabled'),
                '1'     => '1',
                '3'     => '3',
                '5'     => '5',
                '10'    => '10'
            ],
            'label' => __('Revisions'),
            'description' => __('Required to be true, as revisions do not support trashing.')
        ]);
        $section->add_option('select', [
            'name' => 'autosave_interval',
            'options' => [
                ''    => sprintf(__('%s minute'), '1') . ' (' . __('Default') . ')',
                '180' => sprintf(__('%s minute'), '3'),
                '300' => sprintf(__('%s minute'), '5'),
                '600' => sprintf(__('%s minute'), '10')
            ],
            'label' => __('Auto Draft'),
            'description' => __('Maximum number of items to be returned in result set.')
        ]);
        $section->add_option('checkbox', [
            'name' => 'img_column',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Show Images'),
            'description' => __('Posts list')
        ]);
        $section->add_option('checkbox', [
            'name' => 'redirect_single_post',
            'label' => __('Redirect Single Post', 'wp-extra'),
            'description' => __('Redirect to the post if the search results return only one post.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'tag_links',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Tag links', 'wp-extra'),
            'description' => __('Remove link in the tags from all post', 'wp-extra')
        ]);
    }

    if (wp_extra_get_option('modules') && in_array('media',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-admin-media"></span>'.__('Media'));
        $section = $tab->add_section(__('Auto Save Images', 'wp-extra'));
        $section->add_option('select', [
            'name' => 'save_images',
            'label' => __('Save Images', 'wp-extra'),
            'options' => [
                '' => __('No'),
                'all' => __('All'),
                'only' => __('Featured Images')
            ],
            'description' => __('Downloading automatically image from a post to gallery', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'autocrop',
            'label' => __('Auto Crop', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        $section->add_option('number', [
            'name' => 'crop_width',
            'css' => ['hide_class' => 'autocrop'],
            'label' => __('Crop Width'),
            'description' => __('px (E.g: 800px). ')
        ]);
        $section->add_option('number', [
            'name' => 'crop_height',
            'css' => ['hide_class' => 'autocrop'],
            'label' => __('Crop Height'),
            'description' => __('px (E.g: 600px). ')
        ]);
        $section->add_option('checkbox', [
            'name' => 'autoflip',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Flip horizontal', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        $section->add_option('checkbox', [
            'name' => 'image_convert',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Convert PNG to JPG', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        $section->add_option('checkbox', [
            'name' => 'use_alt',
            'label' => __('Use Alt-Text Old', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        $section->add_option('checkbox', [
            'name' => 'use_slug',
            'label' => __('Use Post Slug as File Name', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        
        $section = $tab->add_section(__('Upload New Media'));
        $section->add_option('checkbox', [
            'name' => 'resize_images',
            'label' => __('Resize Images', 'wp-extra'),
            'description' => __('Automatically resizes uploaded images (JPEG, GIF, and PNG)', 'wp-extra')
        ]);
        $section->add_option('number', [
            'name' => 'image_quality',
            'css' => ['hide_class' => 'resize_images'],
            'default' => '90',
            'options' => [
                'step' => '5',
                'min' => '70',
                'max' => '100'
            ],
            'label' => __('JPEG compression level', 'wp-extra'),
            'description' => __('% (Default: 90%)', 'wp-extra')
        ]);
        $section->add_option('number', [
            'name' => 'image_max_width',
            'css' => ['hide_class' => 'resize_images'],
            'default' => '1000',
            'label' => __('Max Width'),
            'description' => __('px (E.g: 1000px). ').__('Max size of an uploaded file')
        ]);
        $section->add_option('number', [
            'name' => 'image_max_height',
            'css' => ['hide_class' => 'resize_images'],
            'default' => '1000',
            'label' => __('Max Height'),
            'description' => __('px (E.g: 1000px). ').__('Max size of an uploaded file')
        ]);
        $section->add_option('number', [
            'name' => 'image_limit',
            'default' => '2000',
            'label' => __('Image Size in kilobytes', 'wp-extra'),
            'description' => __('kb (E.g: 2000 = 2MB). ').__('Max size of an uploaded file')
        ]);
        $section->add_option('select', [
            'name' => 'rename_images',
            'css' => ['hide_class' => 'pro'],
            'label' => __('File Renamer', 'wp-extra'),
            'options' => [
				''	=> __( 'No' ),
				'slug'	=> __('slug.jpg'),
				'filename'	=>  __('slug-{file-name}.jpg'),
				'date'=> __('slug-{2023-06-11}.jpg')
            ],
            'description' => __('Rename uploaded files available in wordpress media and change the postname or slug name.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'autoset',
            'label' => __('Set Featured Image', 'wp-extra'),
            'description' => __('Automatically Set the Featured Image', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'meta_images',
            'label' => __('Image metadata', 'wp-extra'),
            'description' => __('Auto Set The Image Title, Alt-Text, Caption & Description. Default to using the post title.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'meta_images_filename',
            'css' => ['hide_class' => 'meta_images hidden'],
            'label' => __('From Image Filename', 'wp-extra'),
            'description' => __('Default')
        ]);
        $section->add_option('sizes', [
            'name' => 'media_thumbnails',
            'label' => __('Disable Thumbnails', 'wp-extra'),
            'description' => __('Remove Selected Items')
        ]);
        $section->add_option('checkbox-multiple', [
            'name' => 'media_functions',
            'del' => true,
            'label' => __('Function Thumbnails', 'wp-extra'),
            'options' => [
				'threshold'	=> __('Large image threshold', 'wp-extra'),
				'exif'=> __('Exif automatic rotation', 'wp-extra')
            ],
            'description' => __('Remove Selected Items')
        ]);
        
        $section = $tab->add_section(__('Post Thumbnail'));
        $section->add_option('image', [
            'name' => 'media_default',
            'label' => __('Default featured image', 'wp-extra'),
            'description' => __('Add a Default Featured Image for all posts & pages.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'media_default_single',
            'label' => __('Displaying Featured Image on Single Post', 'wp-extra'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'delete_attached',
            'label' => __('Delete Attached Media', 'wp-extra'),
            'description' => __('Enabled')
        ]);
    
        $section = $tab->add_section(__('Media list'));
        $section->add_option('checkbox', [
            'name' => 'media_filesize',
            'label' => __('File size:'),
            'description' => __('Show')
        ]);
        $section->add_option('checkbox', [
            'name' => 'media_alt',
            'label' => __('Alt Text'),
            'description' => __('Show')
        ]);
    }

    if (wp_extra_get_option('modules') && in_array('comments',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-admin-comments"></span>'.__('Comments'));
        $section = $tab->add_section(__('Comments'));
        $section->add_option('checkbox', [
            'name' => 'disable_comments',
            'label' => __('All Comments'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'cm_antispam',
            'label' => __('Anti-Spam Comments', 'wp-extra'),
            'description' => __('Automatically checks all comments and filters out the ones that look like spam.', 'wp-extra')
        ]);
        $section->add_option('text', [
            'name' => 'cm_traffic',
            'css' => ['hide_class' => 'cm_antispam hidden pro', 'input_class' => 'regular-text'],
            'label' => __('Traffic Spam', 'wp-extra'),
            'description' => __('Redirect to link', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'cm_media',
            'label' => __('Comment Media'),
            'description' => __('Hide')
        ]);
    }
        
    if (wp_extra_get_option('modules') && in_array('admins',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-admin-settings"></span>'.__('Site Admin'));
        $section = $tab->add_section(__('Admin Bar'));
        $section->add_option('checkbox', [
            'name' => 'wp_adminbar',
            'label' => __('Admin Bar'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'wp_adminbar_auto',
            'css' => ['hide_class' => 'wp_adminbar hidden pro' ],
            'label' => __('Auto-hide', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        $section->add_option('checkbox-multiple', [
            'name' => 'wp_adminbar_visible',
            'css' => ['hide_class' => 'wp_adminbar hidden' ],
            'label' => __('Show'),
            'options' => [
				'site-admin'=> __('Site Admin'),
				'homepage'	=> __( 'Homepage' )
            ]
        ]);
        $section->add_option('checkbox-multiple', [
            'name' => 'wp_toolbar',
            'options' => [
				'wp-logo'	=> __( 'Logo' ),
				'site-name'	=> __( 'Site Title' ),
				'new-content'	=> __( 'New Menu' ),
				'comments'	=> __( 'Comments' ),
				'updates'	=> __( 'Update' ),
				'flatsome_panel'	=> __( 'Flatsome' ),
				'wpseo-menu'	=> __( 'Yoast SEO' ),
				'rank-math'	=> __( 'Rank Math' ),
				'wp-rocket'	=> __( 'WP Rocket' ),
				'my-account'	=> __( 'Profile' )
            ],
            'label' => __('Toolbar'),
            'description' => __('List of menu items selected for deletion:')
        ]);

        $section = $tab->add_section(__('Admin Menu'));
        $section->add_option('admins', [
            'list' => 'menu',
            'name' => 'adminmenu_list',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Navigation Menus list'),
            'description' => __('Filter Navigation Menu list')
        ]);
        $section->add_option('admins', [
            'name' => 'adminplugin_list',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Plugins list'),
            'description' => __('Filter plugins list')
        ]);
        $section->add_option('role', [
            'list' => 'group',
            'css' => ['hide_class' => 'pro'],
            'name' => 'adminmenu_roles',
            'label' => __('User Roles'),
            'description' => __('Roles assigned to the user.')
        ]);

        $section = $tab->add_section(__('Admin Footer'));
        $section->add_option('checkbox', [
            'name' => 'adminfooter_version',
            'label' => sprintf(__('%s WordPress'),__('Version')),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'adminfooter_extra',
            'css' => ['hide_class' => 'pro'],
            'label' => sprintf(__('%s WP EXtra'),__('Version')),
            'description' => __('Hide')
        ]);
        $section->add_option('wp-editor', [
            'name' => 'adminfooter_custom',
            'css' => ['hide_class' => 'adminfooter_extra hidden pro'],
            'teeny' => true,
            'label' => __('Text'),
            'description' => __('Arbitrary text.')
        ]);

        $section = $tab->add_section(__('Admin Branding'));
        $section->add_option('image', [
            'name' => 'admin_logo',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Admin Logo'),
            'description' => __('Replace image')
        ]);
        $section->add_option('text', [
            'name' => 'admin_logo_link',
            'css' => ['hide_class' => 'pro', 'input_class' => 'regular-text'],
            'label' => __('Link URL'),
            'description' => __('Add New Link')
        ]);
        $section->add_option('choices', [
            'name' => 'admincolor_scheme',
            'css' => ['hide_class' => 'pro' ],
            'options' => [
                '' => __('Default'),
                'blue' => __('Blue'),
                'light' => __('Light')
            ],
            'label' => __('Admin Color Scheme'),
            'description' => __('Custom Colors')
        ]);
    }
        
    if (wp_extra_get_option('modules') && in_array('logins',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-admin-appearance"></span>'.__('Log in'));
        $section = $tab->add_section(__('Personal Options'));
        $section->add_option('text', [
            'name' => 'login_title',
            'css' => ['input_class' => 'regular-text'],
            'label' => __('Login Title', 'wp-extra'),
            'description' => __('Change the title tag content used on the login page.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'login_logo_hide',
            'default' => 1,
            'label' => __('Logo'),
            'description' => __('Hide')
        ]);
        $section->add_option('image', [
            'name' => 'login_logo',
            'label' => __('Custom Logo'),
            'description' => __('Replace the default WordPress logo. Max width: 320px.', 'wp-extra')
        ]);
        $section->add_option('text', [
            'name' => 'login_logo_url',
            'css' => ['hide_class' => 'pro', 'input_class' => 'regular-text'],
            'label' => __('Logo URL', 'wp-extra'),
            'description' => __('When login logo is clicked, the user will be redirected to this url.', 'wp-extra')
        ]);
        $section->add_option('color', [
            'name' => 'login_color',
            'label' => __('Custom Colors')
        ]);
        $section->add_option('image', [
            'name' => 'login_bg_image',
            'type' => 'text',
            'label' => __('Set as background'),
            'description' => '<small>' . __('Random & Blur') . ': <code>https://picsum.photos/1200/768/?blur&random</code><br>' . __('Random') . ': <code>https://source.unsplash.com/1200x768/?seo</code></small>'
        ]);
        $section->add_option('color', [
            'name' => 'login_bg_color',
            'label' => __('Custom Background')
        ]);
        $section->add_option('number', [
            'name' => 'login_form_radius',
            'label' => __('Form Border Radius'),
            'description' => 'px'
        ]);
        $section->add_option('checkbox', [
            'name' => 'login_placeholder',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Placeholder'),
            'description' => __('Username') .' & '.__('Password'),
        ]);
        $section->add_option('checkbox', [
            'name' => 'login_remember',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Remember Me'),
            'description' => __('Auto-check')
        ]);
        $section->add_option('checkbox-multiple', [
            'name' => 'login_link_form',
            'css' => ['hide_class' => 'pro'],
            'options' => [
				'remember' => __('Remember Me'),
                'lost' => __('Register') .' | '.__('Lost your password?'),
                'backto' => __('&laquo; Back'),
                'language' => __('Language'),
                'privacy' => __('Privacy Policy')
            ],
            'label' => __('Hide Controls','wp-extra')
        ]);
        $section->add_option('text', [
            'name' => 'login_url',
            'label' => __('Login Address (URL)'),
            'description' => __('When configured, this feature modifies your WordPress login URL (slug) to the specified string and prevents direct access to the wp-admin and wp-login endpoints.', 'wp-extra')
        ]);
    }
        
    if (wp_extra_get_option('modules') && in_array('security',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-privacy"></span>'.__('Security'));
        $section = $tab->add_section(__('Htaccess'), ['description' => __('Please backup before making any changes.', 'wp-extra')]);
        $section->add_option('import', [
            'name' => 'htaccess_root',
            'label' => __('Root', 'wp-extra'),
            'description' => __('.htaccess'),
            'default' => '# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress'
        ]);
        $section->add_option('import', [
            'name' => 'htaccess_includes',
            'label' => __('WP Includes'),
            'description' => __('wp-includes/.htaccess')
        ]);
        $section->add_option('import', [
            'name' => 'htaccess_content',
            'label' => __('WP Content'),
            'description' => __('wp-content/.htaccess')
        ]);
        
        $section = $tab->add_section(__('Basic', 'wp-extra'));
        $section->add_option('checkbox', [
            'name' => 'disable_embeds',
            'label' => __('Embeds'),
            'description' => __('Removes WordPress Embed JavaScript file (wp-embed.min.js).', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'disable_xmlrpc',
            'label' => __('XML-RPC'),
            'description' => __('XML-RPC services are disabled on this site.')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_jquery_migrate',
            'label' => __('jQuery Migrate'),
            'description' => __('Removes jQuery Migrate JavaScript file (jquery-migrate.min.js).', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_wp_version',
            'label' => __('Version'),
            'description' => __('Removes WordPress version meta tag.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_wlwmanifest_link',
            'label' => __('wlwmanifest'),
            'description' => __('Remove wlwmanifest (Windows Live Writer) link tag.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_rsd_link',
            'label' => __('RSD Link'),
            'description' => __('Remove RSD (Real Simple Discovery) link tag.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_shortlink',
            'label' => __('Shortlink'),
            'description' => __('Remove Shortlink link tag.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'disable_rss_feeds',
            'label' => __('RSS Feeds'),
            'description' => __('Disable WordPress generated RSS feeds and 301 redirect URL to parent.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_feed_links',
            'label' => __('RSS Feed Links'),
            'description' => __('Disable WordPress generated RSS feed link tags.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'disable_self_pingbacks',
            'label' => __('Self Pingbacks'),
            'description' => __('Disable Self Pingbacks (generated when linking to an article on your own blog).', 'wp-extra')
        ]);
        $section->add_option('choices', [
            'name' => 'disable_rest_api',
            'options' => [
                ''           => __('Default (Enabled)', 'wp-extra'),
    			'non_admins' => __('Disable for Non-Admins', 'wp-extra'),
    			'logged_out' => __('Disable When Logged Out', 'wp-extra')
            ],
            'label' => __('REST API'),
            'description' => __('Disables REST API requests and displays an error message if the requester does not have permission.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_rest_api_links',
            'label' => __('REST API Links'),
            'description' => __('Removes REST API link tag from the front end and the REST API header link from page requests.', 'wp-extra')
        ]);
        $section->add_option('choices', [
            'name' => 'disable_heartbeat',
            'options' => [
                '' => __('Default'),
                'everywhere' => __('Disable Everywhere', 'wp-extra'),
                'allow_posts' => __('Only Allow When Editing Posts/Pages', 'wp-extra')
            ],
            'label' => __('Heartbeat'),
            'description' => __('Disable WordPress Heartbeat everywhere or in certain areas (used for auto saving and revision tracking).', 'wp-extra')
        ]);
        $section->add_option('select', [
            'name' => 'heartbeat_frequency',
            'options' => [
                ''   => sprintf(__('%s second'), '15') . ' (' . __('Default') . ')',
                '30' => sprintf(__('%s second'), '30'),
                '45' => sprintf(__('%s second'), '45'),
                '60' => sprintf(__('%s second'), '60')
            ],
            'label' => __('Heartbeat Frequency'),
            'description' => __('Controls how often the WordPress Heartbeat API is allowed to run.', 'wp-extra')
        ]);

        $section = $tab->add_section(__('Advanced'));
        $section->add_option('checkbox', [
            'name' => 'page_extension',
            'label' => __('Add Any Extension to Pages', 'wp-extra'),
            'description' => __('Allows you to specify an extension for pages', 'wp-extra')
        ]);
        $section->add_option('text', [
            'name' => 'page_slash',
            'css' => ['hide_class' => 'page_extension pro'],
            'label' => __('Extension', 'wp-extra'),
            'description' => __('Type in the extension you would like to use e.g. .html, .htm, .jsp, .cop, or any other. (Default: .html)', 'wp-extra')
        ]);
        $section->add_option('role', [
            'css' => ['hide_class' => 'pro'],
            'name' => 'adminmenu_extra',
            'role' => 'administrator',
            'one' => 'multiple',
            'label' => __('WP EXtra Permission', 'wp-extra'),
            'description' => __('This user has super admin privileges.')
        ]);
        $section->add_option('role', [
            'css' => ['hide_class' => 'pro'],
            'name' => 'hide_users',
            'role' => 'administrator',
            'one' => 'multiple',
            'label' => __('Hide Users', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'watermark',
            'label' => __('Watermark Image', 'wp-extra'),
            'description' => __('Add Site URL')
        ]);
        $section->add_option('checkbox', [
            'name' => 'donot_copy',
            'label' => __('Do Not Copy', 'wp-extra'),
            'description' => __('Restrict user to copy content & disable mouse right click.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'donot_content',
            'css' => ['hide_class' => 'donot_copy pro'],
            'label' => __('Copying Content', 'wp-extra'),
            'description' => __('Allow')
        ]);
        $section->add_option('text', [
            'name' => 'donot_copyright',
            'css' => ['hide_class' => 'donot_copy pro', 'input_class' => 'regular-text'],
            'label' => __('Copyright WP EXtra', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'donot_back',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Button Back', 'wp-extra'),
            'description' => __('Restrict user from clicking the back button.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'themeplugin_edits',
            'label' => __('Theme & Plugin Editors', 'wp-extra'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'core_updates',
            'label' => __('All Core Updates', 'wp-extra'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'misc_client_nags',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Nags & Notices', 'wp-extra'),
            'description' => __('Hide')
        ]);

        $section = $tab->add_section(__('Users'));
        $section->add_option('checkbox', [
            'name' => 'restricted_backend',
            'label' => __('Restricted backend access for non-admins.', 'wp-extra'),
            'description' => __('Enabled')
        ]);
        $section->add_option('checkbox', [
            'name' => 'profile_email',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Field Email', 'wp-extra'),
            'description' => __('Hide')
        ]);
        $section->add_option('checkbox', [
            'name' => 'profile_pw',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Field Password', 'wp-extra'),
            'description' => __('Hide')
        ]);
        
        $section = $tab->add_section(__('Cookie'));
        $section->add_option('checkbox', [
            'name' => 'cookie',
            'label' => __('Enabled')
        ]);
        $section->add_option('textarea', [
            'name' => 'cookie_message',
            'css' => ['hide_class' => 'cookie hidden pro'],
            'label' => __('Message', 'wp-extra')
        ]);
        $section->add_option('text', [
            'name' => 'cookie_button',
            'css' => ['hide_class' => 'cookie hidden pro', 'input_class' => 'regular-text'],
            'label' => __('Button Text', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'cookie_privacy',
            'css' => ['hide_class' => 'cookie hidden pro'],
            'label' => __('Display Privacy Policy', 'wp-extra'),
            'description' => '<a href="'.get_privacy_policy_url().'">'.__('Privacy Policy Page').'</a>'
        ]);
        $section->add_option('choices', [
            'name' => 'cookie_placement',
            'css' => ['hide_class' => 'cookie hidden'],
            'options' => [
                ''    => __('Bottom'),
                'top' => __('Top')
            ],
            'label' => __('Cookie info placement')
        ]);
        $section->add_option('text', [
            'name' => 'cookie_expire',
            'css' => ['hide_class' => 'cookie hidden'],
            'label' => __('Cookie expire time', 'wp-extra'),
            'description' => __('in days')
        ]);
        $section->add_option('color', [
            'name' => 'cookie_bgcolor',
            'css' => ['hide_class' => 'cookie hidden'],
            'label' => __('Background color')
        ]);
        $section->add_option('color', [
            'name' => 'cookie_textcolor',
            'css' => ['hide_class' => 'cookie hidden'],
            'label' => __('Text color')
        ]);
        $section->add_option('color', [
            'name' => 'cookie_btnbgcolor',
            'css' => ['hide_class' => 'cookie hidden'],
            'label' => __('Button background color')
        ]);
        $section->add_option('color', [
            'name' => 'cookie_btntextcolor',
            'css' => ['hide_class' => 'cookie hidden'],
            'label' => __('Button text color')
        ]);
    }
        
    if (wp_extra_get_option('modules') && in_array('smtp',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons dashicons-email"></span>'.__('SMTP'));
        $section = $tab->add_section(__('Settings'), ['description' => __('Fill out this section to allow WordPress to dispatch emails.','wp-extra')]);
        $section->add_option('select', [
            'name' => 'smtp_source',
            'options' => [
                ''    => __('No'),
                1 => __('Gmail'),
                2 => __('Yandex')
            ],
            'label' => __('Source')
        ]);
        $section->add_option('checkbox', [
            'name' => 'smtp',
            'label' => __('Other')
        ]);
        $section->add_option('text', [
            'name' => 'smtp_host',
            'css' => ['hide_class' => 'smtp hidden', 'input_class' => 'regular-text' ],
            'label' => __('Host'),
            'description' => sprintf(__('The SMTP server which will be used to send email. %s', 'wp-extra'),'E.g: smtp.mail.com')
        ]);
        $section->add_option('number', [
            'name' => 'smtp_port',
            'css' => ['hide_class' => 'smtp hidden', 'input_class' => 'regular-text' ],
            'label' => __('Port'),
            'description' => __('The port which will be used when sending an email (587/465/25). If you choose TLS it should be set to 587. For SSL use port 465 instead.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'smtp_auth',
            'css' => ['hide_class' => 'smtp hidden', 'input_class' => 'regular-text' ],
            'label' => __('Authentication'),
            'description' => __('Authenticate connection with username and password', 'wp-extra')
        ]);
        $section->add_option('choices', [
            'name' => 'smtp_encryption',
            'css' => ['hide_class' => 'smtp hidden', 'input_class' => 'regular-text' ],
            'options' => [
                ''    => __('Default'),
                'tls' => __('TLS'),
                'ssl' => __('SSL')
            ],
            'label' => __('Type of Encryption')
        ]);
        $section->add_option('text', [
            'name' => 'smtp_username',
            'css' => ['input_class' => 'regular-text' ],
            'label' => __('Username')
        ]);
        $section->add_option('password', [
            'name' => 'smtp_password',
            'css' => ['input_class' => 'regular-text' ],
            'label' => __('Password')
        ]);
        $section->add_option('text', [
            'name' => 'from_email',
            'css' => ['input_class' => 'regular-text' ],
            'label' => __('Force from e-mail address', 'wp-extra')
        ]);
        $section->add_option('text', [
            'name' => 'from_name',
            'css' => ['input_class' => 'regular-text' ],
            'label' => __('Force from e-mail sender name', 'wp-extra')
        ]);
        $section->add_option('checkbox-multiple', [
            'name' => 'smtp_options',
            'options' => [
                'noverifyssl' => __('Disable SSL Verification', 'wp-extra'),
                'antispam' => __('Anti-spam forms', 'wp-extra')
            ],
            'label' => __('Advanced')
        ]);
        
        $section = $tab->add_section(__('Test Email'), ['description' => __('Sends a simple test email to check your settings.', 'wp-extra')]);
        $section->add_option('smtp', [
            'name' => 'test_email',
        ]);
    }
        
    if (wp_extra_get_option('modules') && in_array('optimize',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-superhero"></span>'.__('Optimize', 'wp-extra'));
        $section = $tab->add_section('');
        $section->add_option('select', [
            'name' => 'to_home',
            'options' => [
                ''    => __('None'),
                'home' => __('Home'),
                'random' => __('Random Post')
            ],
            'label' => __('404 to Home/Post'),
            'description' => __('Redirect 404 Error Page to Homepage/Single Post', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'query_strings',
            'label' => __('Query Strings'),
            'description' => __('Remove query strings from static resources (CSS, JS).', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'gutenberg',
            'label' => __('Gutenberg'),
            'description' => __('Prevent Gutenberg Block Library CSS from Loading on the Frontend.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'defer_css',
            'label' => __('Defer CSS'),
            'description' => __('Enabled')
        ]);
        $section->add_option('checkbox', [
            'name' => 'defer_js',
            'label' => __('Defer JS'),
            'description' => __('Enabled')
        ]);
        $section->add_option('choices', [
            'name' => 'defer_js_type',
            'options' => [
                ''    => __('Javascript'),
                'php' => __('PHP')
            ],
            'css' => ['hide_class' => 'defer_js hidden'],
            'label' => __('Type')
        ]);
        $section->add_option('textarea', [
            'name' => 'defer_js_list',
            'rows' => 20,
            'css' => ['hide_class' => 'defer_js hidden'],
            'label' => __('Items list'),
            'description' => __('List of JavaScript file IDs. Example: id="wp-extra-js" should only use wp-extra. One data field per line.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'minify_html',
            'label' => __('Minify HTML'),
            'description' => __('Minify HTML output for clean looking markup and faster downloading.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'tuborlinks',
            'css' => ['hide_class' => 'pro'],
            'label' => __('Tuborlinks'),
            'description' => __('Enabled')
        ]);
        $section->add_option('checkbox', [
            'name' => 'disable_emojis',
            'label' => __('Emojis'),
            'description' => __('Removes WordPress Emojis JavaScript file (wp-emoji-release.min.js).', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'disable_dashicons',
            'label' => __('Dashicons'),
            'description' => __('Disables dashicons on the front end when not logged in.', 'wp-extra')
        ]);
        $section->add_option('checkbox', [
            'name' => 'remove_global_styles',
            'label' => __('Global Styles & SVG Filters'),
            'description' => __('Remove global-styles-inline-css & SVG Duotone Filter', 'wp-extra')
        ]);
    }

    if (wp_extra_get_option('modules') && in_array('code',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-editor-code"></span>'.__('Code'));
        $section = $tab->add_section(__('Custom Scripts', 'wp-extra'));
        $section->add_option('code-editor', [
            'name' => 'code_header',
            'label' => __('Header Scripts'),
            'description' => __('Add custom scripts inside HEAD tag. You need to have a SCRIPT tag around scripts.', 'wp-extra')
        ]);
        if(function_exists('wp_body_open') && version_compare(get_bloginfo('version'), '5.2' , '>=')) {
            $section->add_option('code-editor', [
                'name' => 'code_body',
                'label' => __('Body Scripts'),
                'description' => __('Add custom scripts just after the BODY tag opened. You need to have a SCRIPT tag around scripts.', 'wp-extra')
            ]);
        }
        $section->add_option('code-editor', [
            'name' => 'code_footer',
            'label' => __('Footer Scripts'),
            'description' => __('Add custom scripts you might want to be loaded in the footer of your website. You need to have a SCRIPT tag around scripts.', 'wp-extra')
        ]);

        $section = $tab->add_section(__('Custom CSS'));
        $section->add_option('textarea', [
            'name' => 'css_all',
            'css' => ['input_class' => 'large-text code'],
            'rows' => 10,
            'label' => __('All screens', 'wp-extra'),
            'description' => __('Add custom CSS here', 'wp-extra')
        ]);
        $section->add_option('textarea', [
            'name' => 'css_tablet',
            'css' => ['input_class' => 'large-text code'],
            'rows' => 10,
            'label' => __('Tablets and down', 'wp-extra'),
            'description' => __('Add custom CSS here for tablets and mobile', 'wp-extra')
        ]);
        $section->add_option('textarea', [
            'name' => 'css_mobile',
            'css' => ['input_class' => 'large-text code'],
            'rows' => 10,
            'label' => __('Mobile only', 'wp-extra'),
            'description' => __('Add custom CSS here for mobile view', 'wp-extra')
        ]);
    }
        
    if (wp_extra_get_option('modules') && in_array('tools',  wp_extra_get_option('modules'))) {
        $tab = $settings->add_tab('<span class="dashicons dashicons-controls-repeat"></span>'.__('Tools'));
        $section = $tab->add_section(__('Tools'), ['slug' => true]);
        $section->add_option('tools', [
            'name' => 'tools',
            'tools' => 'transfer',
            'label' => __('Transfer Plugin', 'wp-extra'),
            'css' => ['hide_class' => 'pro'],
            'description' => __('You can transfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import".', 'wp-extra')
        ]);
        $section = $tab->add_section(__('Duplicate'));
        $section->add_option('post-type', [
            'name' => 'duplicate',
            'exclude' => ['product', 'attachment'],
            'label' => __('Duplicate Post Type', 'wp-extra'),
            'description' => __('Duplicate Posts, Pages and Custom Post Type', 'wp-extra')
        ]);
        $section->add_option('taxonomy', [
            'name' => 'duplicate_tax',
            'exclude' => ['post_format'],
            'label' => __('Duplicate Taxonomy', 'wp-extra'),
            'description' => __('Duplicate Category, Tags and Custom Taxonomy', 'wp-extra')
        ]);
    }
        
        $pro_check = ClassEXtra::instance();
        if ($pro_check->isPro()) {
            $tab = $settings->add_tab('<span class="dashicons dashicons-admin-network"></span>'.__('License'));
            $section = $tab->add_section(__('License'), ['description' => __('The plugin activation status.')]);
            $section->add_option('license', [
                'name' => 'license_key',
                'label' => __('Activation Key:'),
                'store_url' => WPEXPRO_STORE_URL,
                'item_id'   => WPEXPRO_ITEM_ID,
                'item_name' => WPEXPRO_ITEM_NAME,
                'version' 	=> WPEXPRO_VERSION,
                'file' => WPEXPRO_FILE,
                'download' => WPEXPRO_STORE_URL.'/checkout/?edd_action=add_to_cart&download_id=' . WPEXPRO_ITEM_ID,
            ]);
        }

        $tab = $settings->add_tab('<span class="dashicons dashicons-editor-help"></span>'.__('Support'));
        $section = $tab->add_section('', ['slug' => true]);
        $section->add_option('label', [
            'label' => __('Awesome', 'wp-extra'),
            'description' => sprintf(__('If you like the plugin, please buy me a beer 🍻 / coffee ☕️ to inspire me to develop further. Please give it a %s .Thanks!', 'wp-extra'), 
            '<a target="_blank" href="https://wordpress.org/support/plugin/wp-extra/reviews/?filter=5#new-post"> ★ ★ ★ ★ ★ review</a>')
        ]);
        $section->add_option('label', [
            'label' => __('Sponser', 'wp-extra'),
            'description' => sprintf(__('<a class="button" href="%s">%s</a>'), 'https://wpvnteam.com/donate/', __('Donate', 'wp-extra'))
        ]);
        $section->add_option('label', [
            'label' => __('PRO Version', 'wp-extra'),
            'description' => sprintf(__('<a class="button button-primary" href="%s">%s</a>'), 'https://wpvnteam.com/downloads/wp-extra-pro/', __('Buy Now', 'wp-extra'))
        ]);
        $section->add_option('label', [
            'label' => __('Lead Developer'),
            'description' => __('TienCOP', 'wp-extra')
        ]);
        $section->add_option('label', [
            'label' => __('Official Website'),
            'description' => sprintf(__('<a class="button" href="%s">WPVNTeam</a>'), 'https://wpvnteam.com')
        ]);
        $section->add_option('label', [
            'label' => __('Email'),
            'description' => sprintf(__('<a class="button" href="%s">%s</a>'), 'mailto:huynhsitien@gmail.com', __('Support'))
        ]);

        $settings->make();
        
    }

}