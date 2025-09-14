<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
    </th>
    <td class="forminp forminp-checkbox">
        <?php if ( $list = $option->get_arg('list')) { ?>
            <?php 
                global $wp_roles;
                $all_roles = $wp_roles->get_names();
                foreach ( $all_roles as $key => $label ) { ?>
                <p><label>
                    <input type="checkbox" id="<?php echo $option->get_id_attribute(); ?>_<?php echo $key; ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo in_array($key, $option->get_value_attribute() ?? []) ? 'checked' : null; ?>>
                    <?php echo in_array($key, $option->get_value_attribute() ?? []) ? "<span style='color:#0e76a8;'>$label</span>" : $label; ?>
                </label></p>
            <?php }
            ?>
        <?php } else { ?>
        <?php if ( $role = $option->get_arg('role') ) {
                $users = get_users(array('role' => $role));
                $one = $option->get_arg('one');
            } else {
                $users = get_users();
                $one = $option->get_arg('one');
            }
            if (!empty($users) && $one) {
            ?>
                <?php foreach ($users as $user) : ?>
                    <p><label>
                            <input type="checkbox" id="<?php echo esc_attr($option->get_id_attribute() . '_' . $user->ID); ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" value="<?php echo esc_attr($user->ID); ?>" <?php echo in_array($user->ID, $option->get_value_attribute() ?? []) ? 'checked' : ''; ?>>
                            <?php echo in_array($user->ID, $option->get_value_attribute() ?? []) ? '<span style="color:#0e76a8;">' . esc_html($user->display_name) . '</span>' : esc_html($user->display_name); ?>
                        </label></p>
                <?php endforeach; ?>
                
        <?php } elseif(!empty($users)) { ?>
                <select id="<?php echo $option->get_id_attribute(); ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" class="<?php echo $option->get_input_class_attribute(); ?>">
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo esc_attr($user->ID); ?>" <?php echo in_array($user->ID, $option->get_value_attribute() ?? []) ? 'selected="selected"' : ''; ?>><?php echo esc_html($user->display_name); ?></option>
                    <?php endforeach; ?>
                </select>
        <?php } ?>
        <?php } ?>
        
        <?php if ($description = $option->get_arg('description')) { ?>
            <p class="description"><?php echo $description; ?></p>
        <?php } ?>

        <?php if ($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
