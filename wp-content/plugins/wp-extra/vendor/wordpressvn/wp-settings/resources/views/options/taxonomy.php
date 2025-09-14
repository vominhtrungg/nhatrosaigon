<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
    </th>
    <td class="forminp forminp-checkbox">
        <?php 
        $choices = $option->get_arg('choices');
        if ($taxonomy = $option->get_arg('term')) { ?>
            <?php $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
            ]);
            if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $key = $term->term_id;
                    $label = $term->name;
                    $is_child = $term->parent != 0;
                    ?>
                    <p><label>
                        <input type="<?php echo $choices ? 'radio' : 'checkbox'; ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo in_array($key, $option->get_value_attribute() ?? []) ? 'checked' : ''; ?>>
                        <?php echo $is_child ? '-- ' : ''; ?><?php echo $label; ?>
                    </label></p>
                    <?php
                }
            }
        ?>
        <?php } else { ?>
        <?php 
        $included_taxonomies = array();
        if ($include = $option->get_arg('include')) {
            $included_taxonomies = (array) $include;
        }
        $excluded_taxonomies = array();
        if ($exclude = $option->get_arg('exclude')) {
            $excluded_taxonomies = (array) $exclude;
        }
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        foreach ($taxonomies as $taxonomy) {
            if ($include && !in_array($taxonomy->name, $included_taxonomies)) {
                continue;
            }
            if ($exclude && in_array($taxonomy->name, $excluded_taxonomies)) {
                continue;
            }
            $key = $taxonomy->name;
            $label = $taxonomy->label;
            $is_child = $term->parent != 0;
            ?><p>
            <label>
                <input type="<?php echo $choices ? 'radio' : 'checkbox'; ?>" name="<?php echo esc_attr($option->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo in_array($key, $option->get_value_attribute() ?? []) ? 'checked' : ''; ?>>
                <?php echo $is_child ? '-- ' : ''; ?><?php echo $label; ?>
            </label></p>
            <?php
        } ?>
        <?php } ?>

        <?php if ($description = $option->get_arg('description')) { ?>
            <p class="description"><?php echo $description; ?></p>
        <?php } ?>

        <?php if ($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
