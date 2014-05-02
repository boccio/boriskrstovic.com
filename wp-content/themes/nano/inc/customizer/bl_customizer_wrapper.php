<?php

if( class_exists( 'WP_Customize_Control' ) ) {
    class WP_Customize_bl_separator_Control extends WP_Customize_Control {
        public $type = 'bl_label';

        public function render_content() { ?>
            <div class="bl-customizer-separator">
                <span><?php echo $this->label; ?></span>
            </div> <?php
        }
    }
    class WP_Customize_bl_description_Control extends WP_Customize_Control {
        public $type = 'bl_description';

        public function render_content() {  ?>
            <small class="bl-customizer-description">
                <?php echo $this->label; ?>
            </small> <?php
        }
    }
    class WP_Customize_bl_font_Control extends WP_Customize_Control {
        public $type = 'bl_font';

        public function render_content() {  ?>
            <label>
                <span class="customize-control-title"><?php echo $this->label; ?></span>
                <input type="text" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" style="width: 80%; display: inline-block;">
                <a class="thickbox bl_edit_customizer_font button-secondary" data-option="text_font" href="#TB_inline?width=400&height=550&inlineId=mbl_font_select" style="width: 18%; display: inline-block;">Edit</a>
            </label> <?php
        }
    }
    class WP_Customize_bl_icon_Control extends WP_Customize_Control {
        public $type = 'bl_icon';

        public function render_content() {  ?>
            <label>
                <span class="customize-control-title"><?php echo $this->label; ?></span>
                <i class="<?php echo esc_attr( $this->value() ); ?>" style="width: 7%;"></i>
                <input type="text" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" style="width: 70%; display: inline-block;">
                <a class="thickbox bl_edit_customizer_icon button-secondary" href="#TB_inline?width=400&height=550&inlineId=mbl_icon_select" style="width: 18%; display: inline-block;">Edit</a>
            </label> <?php
        }
    }
    class WP_Customize_bl_media_Control extends WP_Customize_Control {
        public $type = 'bl_media';

        public function render_content() {  ?>
            <label>
                <span class="customize-control-title"><?php echo $this->label; ?></span>
                <input type="text" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" style="width: 70%; display: inline-block;">
                <a class="bl_edit_customizer_media button-secondary" href="#">Edit</a>
            </label> <?php
        }
    }
    class WP_Customize_bl_text_area_Control extends WP_Customize_Control {
        public $type = 'bl_text_area';

        public function render_content() {  ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea <?php $this->link(); ?>><?php echo esc_attr( $this->value() ); ?></textarea>
            </label>  <?php
        }
    }
}

class bl_customizer_wrap {

    var $wp_customize;
    var $last_section_id;
    var $last_setting_id;

    var $bl_priority;

    function __construct($wp_customize) {
        $this->wp_customize = $wp_customize;
        $this->last_section_id = '';
        $this->bl_priority = 21;
        $this->bl_control_priority = 1;

    }
    function add_section($title, $section_id = '', $priority = false) {
        if (empty($section_id)) {
            $section_id = str_replace(' ', '_', trim(strtolower($title)));
        }
        if ($priority === false) {
            $priority = $this->bl_priority;
        }
        $this->wp_customize->add_section($section_id, array(
            'title' => BL_THEME_NAME . ' : ' . $title,
            'priority' => $priority,
        ));
        $this->last_section_id = $section_id;

        $this->bl_priority++;
    }
    function add_radio($title, $setting_id, $parms) {
        $this->last_setting_id = $setting_id;

        $bl_default_selected_id = '';
        foreach ($parms as $parm_id => $parm_value) {
            $bl_default_selected_id = $parm_id;
            break;
        }
        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default' => $bl_default_selected_id,
            'type' => 'option',
            'capability' => 'edit_theme_options',
        ));
        $this->wp_customize->add_control('tdc_' . $setting_id, array(
            'label' => $title,
            'section' => $this->last_section_id,
            'settings' => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'type' => 'radio',
            'choices' => $parms,
            'priority' => $this->bl_control_priority
        ));


        $this->bl_control_priority++;
    }
    function add_select($title, $setting_id, $parms) {
        $this->last_setting_id = $setting_id;

        $bl_default_selected_id = '';
        foreach ($parms as $parm_id => $parm_value) {
            $bl_default_selected_id = $parm_id;
            break;
        }
        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default' => $bl_default_selected_id,
            'type' => 'option',
            'capability' => 'edit_theme_options',
        ));
        $this->wp_customize->add_control('tdc_' . $setting_id, array(
            'label' => $title,
            'section' => $this->last_section_id,
            'settings' => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'type' => 'select',
            'choices' => $parms,
            'priority' => $this->bl_control_priority
        ));

        $this->bl_control_priority++;
    }
    function add_color($title, $setting_id, $default = '#FFFFFF') {
        //theme color
        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default' => $default,
            'type' => 'option'
        ));

        $this->wp_customize->add_control(new WP_Customize_Color_Control($this->wp_customize, 'bl_' . $setting_id, array(
            'label'   => $title,
            'section' => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function add_input($title, $setting_id, $default = '') {
        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default'       => $default,
            'type'          => 'option'
        ));

        $this->wp_customize->add_control('bl_' . $setting_id, array(
            'label'      => $title,
            'section'    => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'type'       => 'text',
            'priority' => $this->bl_control_priority
        ) );

        $this->bl_control_priority++;
    }
    function add_image_upload($title, $setting_id, $default = '') {
        //custom logo
        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default' => $default,
            'type' => 'option'
        ));

        $this->wp_customize->add_control( new WP_Customize_Image_Control( $this->wp_customize, 'bl_' . $setting_id, array(
            'label'   => $title,
            'section' => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function add_bl_separator($title, $setting_id) {
        //make 1 separator dummy setting :)
        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_separator' . $setting_id . ']', array(
            'default' => '',
            'type' => 'option'
        ));

        //settings separator
        $this->wp_customize->add_control( new WP_Customize_bl_separator_Control( $this->wp_customize, 'bl_' . $setting_id, array(
            'label'   => $title,
            'section' => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_separator' . $setting_id . ']',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function add_bl_description($title, $setting_id) {
        //make 1 separator dummy setting :)
        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_separator' . $setting_id . ']', array(
            'default' => '',
            'type' => 'option'
        ));

        //settings separator
        $this->wp_customize->add_control( new WP_Customize_bl_description_Control( $this->wp_customize, 'bl_' . $setting_id, array(
            'label'   => $title,
            'section' => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_separator' . $setting_id . ']',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function add_bl_font($title, $setting_id, $default = '') {

        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default'       => $default,
            'type'          => 'option'
        ));

        $this->wp_customize->add_control( new WP_Customize_bl_font_Control( $this->wp_customize, 'bl_' . $setting_id, array(
            'label'      => $title,
            'section'    => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'type'       => 'text',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function add_bl_icon($title, $setting_id, $default = '') {

        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default'       => $default,
            'type'          => 'option'
        ));

        $this->wp_customize->add_control( new WP_Customize_bl_icon_Control( $this->wp_customize, 'bl_' . $setting_id, array(
            'label'      => $title,
            'section'    => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'type'       => 'text',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function add_bl_media($title, $setting_id, $default = '') {

        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default'       => $default,
            'type'          => 'option'
        ));

        $this->wp_customize->add_control( new WP_Customize_bl_media_Control( $this->wp_customize, 'bl_' . $setting_id, array(
            'label'      => $title,
            'section'    => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'type'       => 'text',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function add_bl_textarea($title, $setting_id, $default = '') {

        $this->wp_customize->add_setting(BL_THEME_OPTIONS . '[bl_' . $setting_id . ']', array(
            'default'       => $default,
            'type'          => 'option'
        ));

        $this->wp_customize->add_control( new WP_Customize_bl_text_area_Control( $this->wp_customize, 'bl_' . $setting_id, array(
            'label'      => $title,
            'section'    => $this->last_section_id,
            'settings'   => BL_THEME_OPTIONS . '[bl_' . $setting_id . ']',
            'type'       => 'text',
            'priority' => $this->bl_control_priority
        )));

        $this->bl_control_priority++;
    }
    function render($settings_map) {
        foreach ($settings_map as $setting) {
            switch ($setting['command']) {
                case 'add_section':
                    $this->add_section($setting['title'], $setting['section_id'], $setting['priority']);
                    break;
                case 'add_radio':
                    $this->add_radio($setting['title'], $setting['section_id'], $setting['parms']);
                    break;
                case 'add_select':
                    $this->add_select($setting['title'], $setting['section_id'], $setting['parms']);
                    break;
                case 'add_color':
                    $this->add_color($setting['title'], $setting['section_id'], $setting['default']);
                    break;
                case 'add_input':
                    $this->add_input($setting['title'], $setting['section_id'], $setting['default']);
                    break;
                case 'add_image_upload':
                    $this->add_image_upload($setting['title'], $setting['section_id'], $setting['default']);
                    break;
                case 'add_bl_separator':
                    $this->add_bl_separator($setting['title'], $setting['section_id']);
                    break;
                case 'add_bl_description':
                    $this->add_bl_description($setting['title'], $setting['section_id']);
                    break;
                case 'add_bl_font':
                    $this->add_bl_font($setting['title'], $setting['section_id'], $setting['default']);
                    break;
                case 'add_bl_icon':
                    $this->add_bl_icon($setting['title'], $setting['section_id'], $setting['default']);
                    break;
                case 'add_bl_media':
                    $this->add_bl_media($setting['title'], $setting['section_id'], $setting['default']);
                    break;
                case 'add_bl_textarea':
                    $this->add_bl_textarea($setting['title'], $setting['section_id'], $setting['default']);
                    break;
            }
        }
    }
}

// render the customizer panel
function bl_register_customizer($wp_customize) {
    $bl_customizer = new bl_customizer_wrap($wp_customize);
    $bl_customizer->render(bl_utilities::$bl_customizer_settings->get_map());
}
add_action('customize_register', 'bl_register_customizer');
?>