<?php
class bl_utilities {
    static $bl_customizer_settings; // we keep a instance of bl_customizer_settings here

    static function get_customizer_option($optionName, $default_value = '') {
        // returns empty when the default customizer setting is used
        return self::$bl_customizer_settings->get_setting($optionName, $default_value);
    }
    // reads a theme option from wp
    static function get_option($optionName, $default = 'empty') {
        $newoption = str_replace('bl_', '', $optionName);
        $theme_options = get_option(BL_THEME_OPTIONS);
        if (!empty($theme_options[$optionName])) {
            return $theme_options[$optionName];
        }elseif($default !== 'empty'){
            return $default;
        }else {
            return self::$bl_customizer_settings->get_default($newoption);
        }
    }
    // updates a theme option
    static function update_option($optionName, $newValue) {
        $theme_options = get_option(BL_THEME_OPTIONS);
        $theme_options[$optionName] = $newValue;
        update_option(BL_THEME_OPTIONS, $theme_options);
    }
}