<tr valign="top" class="<?php echo $option->get_hide_class_attribute(); ?>">
    <th scope="row" class="titledesc">
        <label for="<?php echo $option->get_id_attribute(); ?>" class="<?php echo $option->get_label_class_attribute(); ?>"><?php echo $option->get_label(); ?></label>
    </th>
    <td class="forminp forminp-text">
        <input name="<?php echo esc_attr($option->get_name_attribute()); ?>" id="<?php echo $option->get_id_attribute(); ?>" type="number"
         value="<?php echo $option->get_value_attribute(); ?>" class="small-text <?php echo $option->get_input_class_attribute(); ?>" <?php foreach($option->get_arg('options', []) as $key => $label) { ?><?php echo $key."='".$label."'"; ?><?php } ?>>

        <?php if($description = $option->get_arg('description')) { ?>
            <?php echo $description; ?>
        <?php } ?>

        <?php if($error = $option->has_error()) { ?>
            <div class="wps-error-feedback"><?php echo $error; ?></div>
        <?php } ?>
    </td>
</tr>
