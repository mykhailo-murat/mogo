<?php
/**
 * Functions
 */
add_action('wp_enqueue_scripts', function () {
    if (!is_admin()) {
        // Disable gutenberg built-in styles
        // wp_dequeue_style('wp-block-library');
        wp_enqueue_style('normalize', get_template_directory_uri() . '/assets/css/normalize.css', null, null);
        wp_enqueue_style('bootstrap.min', get_template_directory_uri() . '/assets/css/bootstrap.min.css', null, '4.6');
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css', null, null);
        wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', null, null);

        wp_enqueue_script('jquery');

        wp_enqueue_script('bootstrap.bundle.min', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', null, '4.6', true);


        //main javascript
        wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', null, null, true);
    }
});

add_theme_support( 'custom-logo' );

function custom_logo_setup() {
    $defaults = array(
        'height'               => 100,
        'width'                => 400,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => true,
    );

    add_theme_support( 'custom-logo', $defaults );
}

add_action( 'after_setup_theme', 'custom_logo_setup' );

register_nav_menus( array(
    'header-menu' => 'Header Menu',
) );

/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );