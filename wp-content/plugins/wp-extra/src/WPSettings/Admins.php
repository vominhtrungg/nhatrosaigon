<?php

namespace WPEXtra\WPSettings;

use WPVNTeam\WPSettings\Options\OptionAbstract;

class Admins extends OptionAbstract
{
    public $view = 'admins';

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
            <td class="forminp forminp-checkbox">
                <?php if ($list = $this->get_arg('list')) { ?>
                    <?php
                        global $menu;
                        foreach ($menu as $value => $item) {
                            if (preg_match('/wp-menu-separator/', $item[4])) {
                                $item[0] = '<sub style="color:#616A74;">― Separator</sub>';
                            }
                            $key = esc_attr($item[2]);
                            $label = $item[0]; ?>
                            <p><label>
                                <input type="checkbox" name="<?php echo esc_attr($this->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo in_array($key, $this->get_value_attribute() ?? []) ? 'checked' : ''; ?>>
                                <?php echo in_array($key, $this->get_value_attribute() ?? []) ? '<del>'.$label.'</del>' : $label; ?>
                            </label></p>
                            <?php
                        }
                    ?>
                <?php } else { ?>
                    <?php
                    $all_plugins = get_plugins();
                    foreach ($all_plugins as $value => $item) {
                        $thepluginItem = base64_encode(serialize(array(
                            'Name' => esc_attr($item['Name']),
                            'Path' => esc_attr($value)
                        )));
                        $key = esc_attr($value);
                        $label = wp_strip_all_tags($item['Name']);
                        ?>
                        <p><label>
                            <input type="checkbox" name="<?php echo esc_attr($this->get_name_attribute()); ?>" value="<?php echo $key; ?>" <?php echo in_array($key, $this->get_value_attribute() ?? []) ? 'checked' : ''; ?>>
                            <?php echo in_array($key, $this->get_value_attribute() ?? []) ? '<del>'.$label.'</del>' : $label; ?>
                        </label></p>
                        <?php
                    }
                    ?>
                <?php } ?>

                <?php if ($description = $this->get_arg('description')) { ?>
                    <p class="description"><?php echo $description; ?></p>
                <?php } ?>

                <?php if ($error = $this->has_error()) { ?>
                    <div class="wps-error-feedback"><?php echo $error; ?></div>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
}
