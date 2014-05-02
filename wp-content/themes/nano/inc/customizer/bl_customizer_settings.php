<?php


class bl_customizer_settings {
    private $customizer_map_array = array();

    private $default_values = array();

    function add_section($title, $section_id = '', $priority = false) {
        $this->customizer_map_array[] = array(
            'command' => 'add_section',
            'title' => $title,
            'section_id' => $section_id,
            'priority' => $priority
        );
    }
    function add_radio($title, $setting_id, $parms) {
        $this->customizer_map_array[] = array(
            'command' => 'add_radio',
            'title' => $title,
            'section_id' => $setting_id,
            'parms' => $parms
        );
    }
    function add_select($title, $setting_id, $parms) {
        $this->customizer_map_array[] = array(
            'command' => 'add_select',
            'title' => $title,
            'section_id' => $setting_id,
            'parms' => $parms
        );
    }
    function add_color($title, $setting_id, $default = '#FFFFFF') {
        $this->customizer_map_array[] = array(
            'command' => 'add_color',
            'title' => $title,
            'section_id' => $setting_id,
            'default' => $default
        );

        $this->default_values[$setting_id] = $default;
    }
    function add_input($title, $setting_id, $default = '') {
        $this->customizer_map_array[] = array(
            'command' => 'add_input',
            'title' => $title,
            'section_id' => $setting_id,
            'default' => $default
        );
        $this->default_values[$setting_id] = $default;
    }
    function add_image_upload($title, $setting_id, $default = '') {
        $this->customizer_map_array[] = array(
            'command' => 'add_image_upload',
            'title' => $title,
            'section_id' => $setting_id,
            'default' => $default
        );
        $this->default_values[$setting_id] = $default;
    }
    function add_bl_separator($title, $setting_id) {
        $this->customizer_map_array[] = array(
            'command' => 'add_bl_separator',
            'title' => $title,
            'section_id' => $setting_id
        );
    }
    function add_bl_description($title, $setting_id) {
        $this->customizer_map_array[] = array(
            'command' => 'add_bl_description',
            'title' => $title,
            'section_id' => $setting_id
        );
    }
    function add_bl_font($title, $setting_id, $default = '') {
        $this->customizer_map_array[] = array(
            'command' => 'add_bl_font',
            'title' => $title,
            'section_id' => $setting_id,
            'default' => $default
        );
        $this->default_values[$setting_id] = $default;
    }
    function add_bl_icon($title, $setting_id, $default = '') {
        $this->customizer_map_array[] = array(
            'command' => 'add_bl_icon',
            'title' => $title,
            'section_id' => $setting_id,
            'default' => $default
        );
        $this->default_values[$setting_id] = $default;
    }
    function add_bl_media($title, $setting_id, $default = '') {
        $this->customizer_map_array[] = array(
            'command' => 'add_bl_media',
            'title' => $title,
            'section_id' => $setting_id,
            'default' => $default
        );
        $this->default_values[$setting_id] = $default;
    }
    function add_bl_textarea($title, $setting_id, $default = '') {
        $this->customizer_map_array[] = array(
            'command' => 'add_bl_textarea',
            'title' => $title,
            'section_id' => $setting_id,
            'default' => $default
        );
        $this->default_values[$setting_id] = $default;
    }
    //used by bl_customizer to generate the panel
    function get_map(){
        return $this->customizer_map_array;
    }
    //returns the default setting by setting id
    function get_default($setting_id) {
        if (!empty($this->default_values[$setting_id])) {
            return $this->default_values[$setting_id];
        } else {
            return '';
        }
    }
    function get_setting($setting_id, $default_value = '') {
        //returns $default_value when the default customizer setting is used
        //it doesn't requiers the tds_ prefix
        if (bl_utilities::get_option('bls_' . $setting_id) == $this->get_default($setting_id)) {
            return $default_value;
        } else {
            return bl_utilities::get_option('bls_' . $setting_id);
        }

    }
}

?>