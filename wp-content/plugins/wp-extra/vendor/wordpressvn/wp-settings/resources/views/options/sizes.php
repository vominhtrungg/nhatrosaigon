<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
    </th>
    <td class="forminp forminp-text">
        <?php 
        $additional_sizes = get_intermediate_image_sizes();
        foreach ($additional_sizes as $size_name => $size_data) {
            $key = $size_data;
            $label = str_replace('_', ' ', ucfirst($size_data)); ?>
            <p><label>
                <input type="checkbox" id="<?php echo $option->get_id_attribute(); ?>_<?php echo $key; ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo is_array($option->get_value_attribute()) && in_array($key, $option->get_value_attribute()) ? 'checked' : ''; ?>>
                <?php echo is_array($option->get_value_attribute()) && in_array($key, $option->get_value_attribute()) ? "<del>$label</del>" : $label; ?>
            </label></p>
        <?php } ?>


        <?php if($description = $option->get_arg('description')) { ?>
            <p class="description"><?php echo $description; ?></p>
        <?php } ?>

        <?php if($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
