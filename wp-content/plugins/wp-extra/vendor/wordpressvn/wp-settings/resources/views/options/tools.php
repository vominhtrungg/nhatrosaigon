<?php if(isset($_POST['tools_reset'])) {
    $option->ToolReset();
} elseif (isset($_POST['tools_import'])) {
    $option->ToolImport($_POST['tools_data']);
}
?>
<tr valign="top">
    <th scope="row" class="titledesc">
        <label><?php _e( 'Reset Default' ); ?></label>
    </th>
    <td class="forminp forminp-text">
        <input type="hidden" name="_wpnonce_reset" value="<?php echo wp_create_nonce('reset_tool_action'); ?>" />
        <input
            name="tools_reset"
            id="<?php echo $option->get_id_attribute(); ?>"
            type="submit"
            value="<?php _e( 'Restore' ); ?>"
            class="button button-secondary">
    </td>
</tr>
<?php if($tools = $option->get_arg('tools')) { ?>
    <tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
        <th scope="row" class="titledesc">
            <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
        </th>
        <td class="forminp forminp-text">
            <textarea
                name="tools_data"
                id="<?php echo $option->get_id_attribute(); ?>"
                rows="8"
                class="large-text code"
                ><?php echo base64_encode(serialize(json_encode(get_option($option->section->tab->settings->option_name, [])))); ?></textarea>
                <br>
            <input type="hidden" name="_wpnonce_import" value="<?php echo wp_create_nonce('import_tool_action'); ?>" />
            <input
                name="tools_import"
                id="<?php echo $option->get_id_attribute(); ?>"
                type="submit"
                value="<?php _e( 'Import' ); ?>"
                class="button button-secondary">
                
            <?php if($description = $option->get_arg('description')) { ?>
                <p class="description"><?php echo $description; ?></p>
            <?php } ?>

            <?php if($error = $option->has_error()) { ?>
                <div class="wps-error-feedback"><?php echo $error; ?></div>
            <?php } ?>
        </td>
    </tr>
<?php } ?>