<?php
/**
 * Plugin Name:     Accessibility Toolbar Lite
 * Description:     Leichtgewichtige Toolbar mit Zoom- und Kontrast-Funktion. Einstellungen im Backend speicherbar.
 * Version:         1.0.0
 * Author:          LinebyLine
 * Author URI:      https://linebyline.de
 * Text Domain:     accessibility-toolbar-lite
 * License:         GPLv2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Tested up to:    6.8
 * Requires PHP:    7.4
 */

defined('ABSPATH') || exit;

// Plugin-Konstanten
if (! defined('ATLITE_VERSION')) define('ATLITE_VERSION', '1.0.0');
if (! defined('ATLITE_URL'    )) define('ATLITE_URL',     plugin_dir_url(__FILE__));
if (! defined('ATLITE_PATH'   )) define('ATLITE_PATH',    plugin_dir_path(__FILE__));

// Übersetzungen laden
add_action('plugins_loaded', function() {
    load_plugin_textdomain(
        'accessibility-toolbar-lite',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
});

// Admin-Einstellungen
require ATLITE_PATH . 'includes/admin-settings.php';

// Frontend-Assets einbinden
add_action('wp_enqueue_scripts', function() {
    if (! wp_script_is('jquery','enqueued')) {
        wp_enqueue_script('jquery');
    }
    wp_enqueue_style(
        'atlite-style',
        ATLITE_URL . 'assets/css/style.css',
        [],
        ATLITE_VERSION
    );
    wp_enqueue_script(
        'atlite-script',
        ATLITE_URL . 'assets/js/script.js',
        ['jquery'],
        ATLITE_VERSION,
        true
    );
    wp_localize_script('atlite-script', 'ATL_Settings', [
        'zoom'     => get_option('atlite_default_zoom', '100'),
        'contrast' => get_option('atlite_default_contrast', 'off'),
        'position' => get_option('atlite_default_position', 'top'),
    ]);
}, 5);

// Fallback im <head> für Page-Builder/Themes ohne wp_footer()
add_action('wp_head', function() {
    if (! wp_script_is('atlite-script','enqueued')) {
        wp_enqueue_style('atlite-style');
        wp_enqueue_script('atlite-script');
    }
}, PHP_INT_MAX);

// Toolbar ausgeben
function atlite_render_toolbar() {
    $pos = get_option('atlite_default_position', 'top');
    printf(
        '<div id="atl-toolbar" role="toolbar" class="atl-position-%s">',
        esc_attr( $pos )
    );
    echo '<button id="atl-zoom-in"      aria-label="'. esc_attr__('Zoom In','accessibility-toolbar-lite') .'">A+</button>';
    echo '<button id="atl-zoom-out"     aria-label="'. esc_attr__('Zoom Out','accessibility-toolbar-lite') .'">A-</button>';
    echo '<button id="atl-toggle-contrast" aria-label="'. esc_attr__('Toggle Contrast','accessibility-toolbar-lite') .'">'. esc_html__('Kontrast','accessibility-toolbar-lite') .'</button>';
    echo '</div>';
}
add_action('wp_body_open', 'atlite_render_toolbar');
add_action('wp_footer',     'atlite_render_toolbar');
