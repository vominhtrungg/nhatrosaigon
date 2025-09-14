<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
    </th>
    <td class="forminp forminp-text forminp-check">

        <input name="<?php echo esc_attr($option->get_name_attribute()); ?>" id="<?php echo $option->get_id_attribute(); ?>" type="checkbox" value="<?php echo $option->get_value_attribute(); ?>" <?php echo $option->is_checked() ? 'checked' : null; ?> class="<?php echo $option->get_input_class_attribute(); ?>">
        <label for="<?php echo $option->get_id_attribute(); ?>"></label>
        
        <?php if($description = $option->get_arg('description')) { ?>
            <p class="description"><?php echo $option->get_arg('description'); ?></p>
        <?php } ?>

        <input type="hidden" name="wp_settings_submitted[]" value="<?php echo esc_attr($option->get_name()); ?>">

        <?php if($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
