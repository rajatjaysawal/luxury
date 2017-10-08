<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// AUTO GENERATED - Do not modify or remove comment markers above or below:
if ( !function_exists( 'nemi_child_fnc_theme_configurator_css' ) ):
    function nemi_child_fnc_theme_configurator_css() {
        wp_dequeue_style('nemi-style');
        wp_enqueue_style( 'parent-style', trailingslashit( get_template_directory_uri() ). 'css/style.css' );
        wp_enqueue_style( 'theme-style', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css');
    }
endif;
add_action( 'wp_enqueue_scripts', 'nemi_child_fnc_theme_configurator_css', 999 );

// END ENQUEUE PARENT ACTION
