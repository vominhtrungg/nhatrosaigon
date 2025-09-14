<div class="cop<?php echo $settings->lite ? ' ' . $settings->lite : ''; ?>">
    <h2><?php echo $settings->title; ?></h2>
    <span><?php echo '✪ '.$settings->version; ?></span>
</div>
<?php $settings->render_tab_menu(); ?>
<div class="wrap">
    <h1 style="display: none;"></h1>
    <?php if ($flash = $settings->flash->has()) { ?>
    <div class="notice notice-<?php echo $flash['status']; ?> is-dismissible">
        <p><?php echo $flash['message']; ?></p>
    </div>
    <?php } ?>
    <?php if( $errors = $settings->errors->get_all() ) { ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e( 'Something went wrong.'); ?></p>
        </div>
    <?php } ?>

    <?php $settings->render_active_sections(); ?>
</div>
