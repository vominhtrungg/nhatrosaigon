<?php

/** v1.1.0 **/

namespace WPVNTeam\WPSettings;

use Adbar\Dot;

class WPSettings
{
    public $title;

    public $menu_title;

    public $slug;

    public $parent_slug;

    public $capability = 'manage_options';

    public $menu_icon;

    public $menu_position;

    public $option_name;

    public $tabs = [];

    public $errors;

    public $flash;

    public $version;

    public $lite;

    public function __construct($title, $slug = null)
    {
        $this->title = $title;
        $this->option_name = strtolower(str_replace('-', '_', sanitize_title($this->title)));
        $this->slug = $slug;

        if ($this->slug === null) {
            $this->slug = sanitize_title($title);
        }
    }

    public function set_menu_parent_slug($slug)
    {
        $this->parent_slug = $slug;

        return $this;
    }

    public function set_menu_title($title)
    {
        $this->menu_title = $title;

        return $this;
    }

    public function get_menu_title()
    {
        return $this->menu_title ?? $this->title;
    }

    public function set_capability($capability)
    {
        $this->capability = $capability;

        return $this;
    }

    public function set_option_name($name)
    {
        $this->option_name = $name;

        return $this;
    }

    public function set_menu_icon($icon)
    {
        $this->menu_icon = $icon;

        return $this;
    }

    public function set_menu_position($position)
    {
        $this->menu_position = $position;

        return $this;
    }

    public function set_version($version = null)
    {
        $this->version = $version;

        return $this;
    }

    public function set_lite($lite = null)
    {
        $this->lite = $lite;

        return $this;
    }

    public function add_to_menu()
    {
        if ($this->parent_slug) {
            \add_submenu_page($this->parent_slug, $this->title, $this->get_menu_title(), $this->capability, $this->slug, [$this, 'render'], $this->menu_position);
        } else {
            \add_menu_page($this->title, $this->get_menu_title(), $this->capability, $this->slug, [$this, 'render'], $this->menu_icon, $this->menu_position);
        }
    }

    public function make()
    {
        $this->errors = new Error($this);
        $this->flash = new Flash($this);
        add_action('admin_init', [$this, 'save'], 20);
        add_action('admin_menu', [$this, 'add_to_menu'], 20);
        add_action('admin_head', [$this, 'styling'], 20);
        add_action('admin_head', [$this, 'stylepro'], 20);
        add_action('admin_footer', [$this, 'scripting'], 20);
    }

    public function is_on_settings_page()
    {
        $screen = get_current_screen();

        if ($screen && $screen->base === 'settings_page_'.$this->slug) {
            return true;
        }

        return false;
    }

    public function is_on_toplevel_page()
    {
        $screen = get_current_screen();

        if ($screen && $screen->base === 'toplevel_page_'.$this->slug) {
            return true;
        }

        return false;
    }
    
    public function is_on_parent_page()
    {
        $screen = get_current_screen();

        if ($screen && strpos($screen->base, $this->slug) !== false) {
            return true;
        }
        
        return false;
    }


    public function styling()
    {
        if (! $this->is_on_settings_page()) {
            return;
        }
        ?>
        <style>.wps-error-feedback {color: #d63638;margin: 5px 0;}</style>
        <?php
    }
    
    public function stylepro()
    {
        if ($this->is_on_toplevel_page() || $this->is_on_settings_page() || $this->is_on_parent_page()) {
        ?>
        <style>.pro * {pointer-events: none;opacity: 0.8;}.cop { border-bottom: 1px solid #dedae6;background: #fff;margin-left: -20px;display: flex;justify-content: space-between;padding: 5px 20px;align-items: center;}.cop > span, .cop > h2::after {padding: 0 5px;background: linear-gradient(90.52deg, #3E8BFF 0.44%, #A45CFF 113.3%);border-radius: 100px;font-size: 11px;color: #fff;} .cop-lite > h2::after {content: "LITE "; margin-left:5px; padding: 0 5px;background: linear-gradient(90.52deg, #72aee6 0.44%, #72aee6 113.3%);border-radius: 100px;font-size: 11px;color: #fff;} .pro > th {position: relative;}.pro > th::after {content: "PRO ";position: absolute;top: 23px;right: 0;padding: 0 5px;background: #ff3030;border-radius: 100px;font-size: 11px;color: #fff;} #nav-cop{position:sticky;top:32px;z-index:1020;margin-left:-20px;background:#fff;padding:0 0 0 20px}#nav-cop .nav-menu{display:flex;flex-wrap:wrap;list-style-image:none;list-style-type:none;margin:0;padding:0}#nav-cop .nav-menu .nav-item{margin-bottom:0}#nav-cop .nav-link{border-bottom:3px solid #fff;color:#1e1e1e;display:inline-block;padding:10px 12px 10px;text-decoration:none;white-space:nowrap}#nav-cop .nav-link > span{margin-right:5px;}#nav-cop .nav-link.active{border-bottom-color:#5f3afc}#nav-cop .nav-menu li:hover>a,#nav-cop .nav-menu li>a:focus {background-color: #f9f9f9;border-bottom-color: #5f3afc}.forminp-check{display:flex;align-items:center}.forminp-check input{width:0!important;height:0!important;opacity:0!important;position:absolute}.forminp-check input+label{position:relative;background:silver;width:40px;min-width:40px;height:22px;margin-right:8px;display:inline-flex;align-items:center;border-radius:25px;cursor:pointer;transition:background .2s ease-in-out;text-indent:calc( 40px + 10px)}.forminp-check input+label:after{content:"";background:#fff;width:calc(22px - (3px * 2));height:calc(22px - (3px * 2));position:absolute;top:3px;left:3px;border-radius:50%;transition:left .3s ease-in-out,background .2s ease-in-out}.forminp-check input:checked+label{background:linear-gradient(90.52deg,#3e8bff .44%,#a45cff 113.3%)}.forminp-check input:checked+label:after{left:calc(100% - calc(22px - 3px))}
        </style>
        <?php
        }
    }
    
    public function scripting()
    {
        if ($this->is_on_toplevel_page() || $this->is_on_settings_page() || $this->is_on_parent_page()) {
        ?><script>
                (function($){
                    $('[class^="<?php echo $this->option_name; ?>"]').each(function(){
                        var classList = this.className.split(" "),
                            parentId = classList.find(function(cls) { return cls.startsWith("<?php echo $this->option_name; ?>"); }),
                            parent = $('#' + parentId),
                            children = $(this),
                            childrens = children.find(':input');
                        parent.on('change', function(){
                            if (classList.includes('hidden')) {
                                children.toggleClass('hidden', !this.checked);
                            } else {
                                childrens.prop('disabled', !this.checked);
                            }
                        });

                        if (classList.includes('hidden')) {
                            children.toggleClass('hidden', !parent.is(':checked'));
                        } else {
                            childrens.prop('disabled', !parent.is(':checked'));
                        }
                    });

                    $('.nav-tab-content .tab-content').not(':first').hide();
                    $('.nav-section a').first().addClass('nav-tab-active');
                    $('.nav-section a').on('click', function(e) {
                        e.preventDefault();
                        $('.nav-tab-content .tab-content').hide();
                        var tabId = $(this).data('tab');
                        $('#' + tabId).show();
                        $('.nav-section a').removeClass('nav-tab-active');
                        $(this).addClass('nav-tab-active');
                    });

                })(jQuery);
            </script>
        <?php
        }
    }

    public function get_tab_by_slug($slug)
    {
        foreach ($this->tabs as $tab) {
            if ($tab->slug === $slug) {
                return $tab;
            }
        }

        return false;
    }

    public function get_active_tab()
    {
        $default = $this->tabs[0] ?? false;

        if (isset($_GET['tab'])) {
            return in_array($_GET['tab'], array_map(function ($tab) {
                return $tab->slug;
            }, $this->tabs)) ? $this->get_tab_by_slug($_GET['tab']) : $default;
        }

        return $default;
    }

    public function add_tab($title, $slug = null)
    {
        $tab = new Tab($this, $title, $slug);

        $this->tabs[] = $tab;

        return $tab;
    }

    public function add_section($title, $args = [])
    {
        if (empty($this->tabs)) {
            $tab = $this->add_tab('Unnamed tab');
        } else {
            $tab = end($this->tabs);
        }

        return $tab->add_section($title, $args);
    }

    public function add_option($type, $args = [])
    {
        $tab = end($this->tabs);

        if (! $tab instanceof Tab) {
            return false;
        }

        $section = end($tab->sections);

        if (! $section instanceof Section) {
            return false;
        }

        return $section->add_option($type, $args);
    }

    public function should_make_tabs()
    {
        return count($this->tabs) > 1;
    }

    public function get_url()
    {
        if ($this->parent_slug && strpos($this->parent_slug, '.php') !== false) {
            return \add_query_arg('page', $this->slug, \admin_url($this->parent_slug));
        }

        return \admin_url("admin.php?page=$this->slug");
    }
    
    public function get_full_url()
    {
        $params = [];

        if ($active_tab = $this->get_active_tab()) {
            $params['tab'] = $active_tab->slug;

            if ($active_section = $active_tab->get_active_section()) {
                $params['section'] = $active_section->slug;
            }
        }
        
        /* $url = add_query_arg($params, $this->get_url());

        if (isset($params['tab']) && $params['tab'] == 'tools') {
            return $url . '" enctype="multipart/form-data';
        } else {
            return $url;
        } */
        
        return add_query_arg($params, $this->get_url());
    }

    public function render_tab_menu()
    {
        if (! $this->should_make_tabs()) {
            return;
        }

        view('tab-menu', ['settings' => $this]);
    }

    public function render_active_sections()
    {
        view('sections', ['settings' => $this]);
    }

    public function render()
    {
        Enqueuer::setEnqueueManager(new EnqueueManager);

        do_action('wp_settings_before_render_settings_page');

        Enqueuer::enqueue();

        view('settings-page', ['settings' => $this]);

        do_action('wp_settings_after_render_settings_page');
    }

    public function get_options()
    {
        return get_option($this->option_name, []);
    }

    public function find_option($search_option)
    {
        foreach ($this->tabs as $tab) {
            foreach ($tab->sections as $section) {
                foreach ($section->options as $option) {
                    if ($option->args['name'] == $search_option) {
                        return $option;
                    }
                }
            }
        }

        return false;
    }

    public function save()
    {
        if (! isset($_POST['_wpnonce']) || ! wp_verify_nonce($_POST['_wpnonce'], 'wp_settings_save_'.$this->option_name)) {
            return;
        }

        if (! current_user_can($this->capability)) {
            wp_die(__('What do you think you are doing?'));
        }

        $current_options = $this->get_options();
        $submitted_options = apply_filters('wp_settings_new_options', $_POST[$this->option_name] ?? [], $current_options);
        $new_options = new Dot($current_options);

        foreach ($this->get_active_tab()->get_active_sections() as $section) {
            foreach ($section->options as $option) {
                $value = (new Dot($submitted_options))
                    ->get($option->implementation->get_option_key_path());

                $valid = $option->validate($value);

                if (! $valid) {
                    continue;
                }

                $value = apply_filters('wp_settings_new_options_'.$option->implementation->get_name(), $option->implementation->sanitize($value), $option->implementation);

                $new_options->set($option->implementation->get_option_key_path(), $value);
            }
        }

        update_option($this->option_name, $new_options->pull());

        $this->flash->set('success', __('Changes saved.'));
    }

    /**
     * @deprecated
     */
    public function maybe_unset_options($current_options, $new_options)
    {
        if (! isset($_REQUEST['wp_settings_submitted'])) {
            return $current_options;
        }

        foreach ($_REQUEST['wp_settings_submitted'] as $submitted) {
            if (empty($new_options[$submitted])) {
                unset($current_options[$submitted]);
            }
        }

        return $current_options;
    }

}
