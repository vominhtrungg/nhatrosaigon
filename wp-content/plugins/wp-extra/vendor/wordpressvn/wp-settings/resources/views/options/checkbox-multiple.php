<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
    </th>
    <td class="forminp forminp-checkbox">
        <?php foreach ($option->get_arg('options', []) as $key => $label) { ?>
            <p>
            <label>
                <input type="checkbox" id="<?php echo $option->get_id_attribute(); ?>_<?php echo $key; ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo in_array($key, $option->get_value_attribute() ?? []) ? 'checked' : ''; ?>>
                <?php if($del = $option->get_arg('del')) { ?>
                    <?php echo in_array($key, $option->get_value_attribute() ?? []) ? "<del>$label</del>" : $label; ?>
                <?php } else { ?>
                    <?php echo $label; ?>
                <?php } ?>
            </label>
            </p>
        <?php } ?>
        <?php if($description = $option->get_arg('description')) { ?>
            <p class="description"><?php echo $description; ?></p>
        <?php } ?>
        <?php if($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
