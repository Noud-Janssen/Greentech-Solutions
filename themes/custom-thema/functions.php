<?php

function my_theme_enqueue_styles() {
    wp_enqueue_style( 'my-theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function custom_enqueue_scripts() {
    // Deregister WordPress's default jQuery
    wp_deregister_script( 'jquery' );

    // Register custom scripts
    wp_register_script( 'jquery', get_template_directory_uri() . '/templates/js/jquery.min.js', array(), null, true );
    wp_register_script( 'breakpoints', get_template_directory_uri() . '/templates/js/breakpoints.min.js', array( 'jquery' ), null, true );
    wp_register_script( 'browser', get_template_directory_uri() . '/templates/js/browser.min.js', array( 'jquery' ), null, true );
    wp_register_script( 'util', get_template_directory_uri() . '/templates/js/util.js', array( 'jquery' ), null, true );
    wp_register_script( 'main', get_template_directory_uri() . '/templates/js/main.js', array( 'jquery', 'breakpoints', 'browser', 'util' ), null, true );

    // Enqueue scripts
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'breakpoints' );
    wp_enqueue_script( 'browser' );
    wp_enqueue_script( 'util' );
    wp_enqueue_script( 'main' );
}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );
