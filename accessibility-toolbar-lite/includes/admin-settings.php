<?php
/**
 * Admin-Einstellungen für Accessibility Toolbar Lite
 */
defined('ABSPATH') || exit;

// Menüpunkt
add_action('admin_menu', function() {
    add_options_page(
        __('Accessibility Toolbar','accessibility-toolbar-lite'),
        __('Accessibility Toolbar','accessibility-toolbar-lite'),
        'manage_options',
        'atlite_settings',
        'atlite_options_page'
    );
});

// Einstellungen registrieren mit Sanitization
add_action('admin_init', function() {
    register_setting(
        'atlite_group',
        'atlite_default_zoom',
        ['sanitize_callback' => 'absint']
    );
    register_setting(
        'atlite_group',
        'atlite_default_contrast',
        ['sanitize_callback' => 'sanitize_key']
    );
    register_setting(
        'atlite_group',
        'atlite_default_position',
        ['sanitize_callback' => 'sanitize_key']
    );

    add_settings_section(
        'atlite_section',
        __('Standard-Einstellungen','accessibility-toolbar-lite'),
        function() {
            esc_html_e('Legen Sie hier Default-Zoom, Kontrast und Position fest.','accessibility-toolbar-lite');
        },
        'atlite_settings'
    );

    add_settings_field(
        'atlite_default_zoom',
        __('Default Zoom','accessibility-toolbar-lite'),
        function() {
            $v = get_option('atlite_default_zoom','100');
            echo '<select name="atlite_default_zoom">'
               . '<option value="100" '. selected($v,'100',false) .'>100%</option>'
               . '<option value="110" '. selected($v,'110',false) .'>110%</option>'
               . '<option value="120" '. selected($v,'120',false) .'>120%</option>'
               . '</select>';
        },
        'atlite_settings','atlite_section'
    );
    add_settings_field(
        'atlite_default_contrast',
        __('Default Kontrast','accessibility-toolbar-lite'),
        function() {
            $v = get_option('atlite_default_contrast','off');
            echo '<select name="atlite_default_contrast">'
               . '<option value="off" '. selected($v,'off',false) .'>'. esc_html__('Aus','accessibility-toolbar-lite') .'</option>'
               . '<option value="on"  '. selected($v,'on',false)  .'>'. esc_html__('An','accessibility-toolbar-lite')  .'</option>'
               . '</select>';
        },
        'atlite_settings','atlite_section'
    );
    add_settings_field(
        'atlite_default_position',
        __('Default Position','accessibility-toolbar-lite'),
        function() {
            $v = get_option('atlite_default_position','top');
            echo '<select name="atlite_default_position">'
               . '<option value="top"    '. selected($v,'top',false)   .'>'. esc_html__('Oben','accessibility-toolbar-lite')  .'</option>'
               . '<option value="bottom" '. selected($v,'bottom',false) .'>'. esc_html__('Unten','accessibility-toolbar-lite') .'</option>'
               . '</select>';
        },
        'atlite_settings','atlite_section'
    );
});

// Optionsseite ausgeben
function atlite_options_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Accessibility Toolbar Einstellungen','accessibility-toolbar-lite'); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('atlite_group');
            do_settings_sections('atlite_settings');
            submit_button(__('Speichern','accessibility-toolbar-lite'));
            ?>
        </form>
    </div>
    <?php
}
