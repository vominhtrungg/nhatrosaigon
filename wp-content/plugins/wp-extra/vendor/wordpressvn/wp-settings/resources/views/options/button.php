<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <?php if($description = $option->get_arg('description')) { ?>
            <label class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $description; ?></label>
        <?php } ?>
    </th>
    <td class="forminp forminp-text">
        <input
            name="<?php echo esc_attr($option->get_name_attribute()); ?>"
            id="<?php echo $option->get_id_attribute(); ?>"
            type="<?php echo $option->get_arg('type', 'text'); ?>"
            value="<?php echo $option->get_label(); ?>"
            class="<?php echo $option->get_input_class_attribute(); ?>">
            <span class="spinner"></span>
            <button id="stop_<?php echo $option->get_id_attribute(); ?>" type="button" class="<?php echo $option->get_input_class_attribute(); ?>"><span style="line-height: 30px;"  class="dashicons dashicons-controls-pause"></span><?php echo esc_html__('Pause'); ?></button>
            <div id="result_<?php echo $option->get_id_attribute(); ?>"></div>


        <?php if($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
