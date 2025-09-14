<form method="post" action="<?php echo $settings->get_full_url(); ?>">
    <?php WPVNTeam\WPSettings\view('section-menu', compact('settings')); ?>
    
    <div class="nav-tab-content">
        <?php foreach ($settings->get_active_tab()->get_active_sections() as $section) { ?>
            <?php WPVNTeam\WPSettings\view('section', compact('section')); ?>
        <?php } ?>
    </div>

    <?php wp_nonce_field( 'wp_settings_save_' . $settings->option_name, '_wpnonce' ); ?>
    
    <?php if (strpos(strval($section->slug), '1') === false) { ?>
        <?php submit_button(); ?>
    <?php } ?>
</form>
