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

        wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', null, null);

        wp_enqueue_script('jquery');

        wp_enqueue_script('bootstrap.bundle.min', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', null, '4.6', true);
        wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, '8.4', true);


        //main javascript
        wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', null, null, true);
    }
});

add_theme_support('custom-logo');

function custom_logo_setup()
{
    $defaults = array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
        'unlink-homepage-logo' => true,
    );

    add_theme_support('custom-logo', $defaults);
}

add_action('after_setup_theme', 'custom_logo_setup');

register_nav_menus(array(
    'header-menu' => 'Header Menu',
));

/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

add_theme_support('post-thumbnails');

// Our custom post type function
function create_posttype()
{

    register_post_type('slider',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Slider'),
                'singular_name' => __('Slide')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'slider'),
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
        )
    );
}

// Hooking up our function to theme setup
add_action('init', 'create_posttype');

add_image_size('full_hd', 1920, 0, array('center', 'center'));
add_image_size('blog-img', 380, 240, array('center', 'center'));

/**
 * Output background image style
 *
 * @param array|string $img Image array or url
 * @param string $size Image size to retrieve
 * @param bool $echo Whether to output the the style tag or return it.
 *
 * @return string|void String when retrieving.
 */
function bg($img = '', $size = '', $echo = true)
{

    if (empty($img)) {
        return false;
    }

    if (is_array($img)) {
        $url = $size ? $img['sizes'][$size] : $img['url'];
    } else {
        $url = $img;
    }

    $string = 'style="background-image: url(' . $url . ')"';

    if ($echo) {
        echo $string;
    } else {
        return $string;
    }
}


/*
 * Set post views count using post meta//functions.php
 */
function customSetPostViews($postID)
{
    $countKey = 'post_views_count';
    $count = get_post_meta($postID, $countKey, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $countKey);
        add_post_meta($postID, $countKey, '1');
    } else {
        $count++;
        update_post_meta($postID, $countKey, $count);
    }
}
