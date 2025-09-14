<?php

namespace WPEXtra\WPSettings;

use WPVNTeam\WPSettings\Options\OptionAbstract;

class Sizes extends OptionAbstract
{
    public $view = 'sizes';
    
    public function get_name_attribute()
    {
        $name = parent::get_name_attribute();

        return "{$name}[]";
    }

    public function sanitize($value)
    {
        return (array) $value;
    }
    
    public function render()
    {
        ?>
        <tr valign="top" class="<?php echo $this->get_hide_class_attribute(); ?>">
            <th scope="row" class="titledesc">
                <label for="<?php echo $this->get_id_attribute(); ?>" class="<?php echo $this->get_label_class_attribute(); ?>"><?php echo $this->get_label(); ?></label>
            </th>
            <td class="forminp forminp-text">
                <?php 
                $additional_sizes = get_intermediate_image_sizes();
                foreach ($additional_sizes as $size_name => $size_data) {
                    $key = $size_data;
                    $label = str_replace('_', ' ', ucfirst($size_data)); ?>
                    <p><label>
                        <input type="checkbox" id="<?php echo $this->get_id_attribute(); ?>_<?php echo $key; ?>" name="<?php echo esc_attr($this->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo is_array($this->get_value_attribute()) && in_array($key, $this->get_value_attribute()) ? 'checked' : ''; ?>>
                        <?php echo is_array($this->get_value_attribute()) && in_array($key, $this->get_value_attribute()) ? "<del>$label</del>" : $label; ?>
                    </label></p>
                <?php } ?>


                <?php if($description = $this->get_arg('description')) { ?>
                    <p class="description"><?php echo $description; ?></p>
                <?php } ?>

                <?php if($error = $this->has_error()) { ?>
                    <div class="wps-error-feedback"><?php echo $error; ?></div>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}
