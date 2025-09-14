<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
    </th>
    <td class="forminp forminp-text">
        <?php
        $selected_values = $option->get_value_attribute() ?? [];
        $included_post_type = (array) ($option->get_arg('include') ?? []);
        $exclude_post_type = (array) ($option->get_arg('exclude') ?? []);
        $post_types = get_post_types(['public' => true], 'objects');
        foreach ($post_types as $post_type) {
            if (!empty($included_post_type) && !in_array($post_type->name, $included_post_type)) {
                continue;
            }
            if (!empty($exclude_post_type) && in_array($post_type->name, $exclude_post_type)) {
                continue;
            }
            $key = $post_type->name;
            $label = $post_type->label;
        ?><p><label>
                <input type="checkbox" id="<?php echo $key; ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo in_array($key, $selected_values) ? 'checked' : ''; ?>>
                <?php echo $label; ?>
            </label>
            </p>
        <?php } ?>

        <?php if ($description = $option->get_arg('description')) { ?>
            <p class="description"><?php echo $description; ?></p>
        <?php } ?>

        <?php if ($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
