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
    register_post_type('team',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Team'),
                'singular_name' => __('Team')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'team'),
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
        )
    );
}

// Hooking up our function to theme setup
add_action('init', 'create_posttype');

add_image_size('full_hd', 1920, 0, array('center', 'center'));
add_image_size('blog-img', 380, 240, array('center', 'center'));
add_image_size('team-img', 380, 470, array('center', 'center'));

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
 * Set post views count using post meta
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


function display_svg($img, $class = '', $size = 'medium')
{
    echo return_svg($img, $class, $size);
}

function return_svg($img, $class = '', $size = 'medium')
{
    if (!$img) {
        return '';
    }

    $file_url = is_array($img) ? $img['url'] : $img;

    $file_info = pathinfo($file_url);
    if ($file_info['extension'] == 'svg') {
        $file_path = convert_url_to_path($file_url);

        if (!$file_path) {
            return '';
        }

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $image = file_get_contents($file_path, false, stream_context_create($arrContextOptions));
        if ($class) {
            $image = str_replace('<svg ', '<svg class="' . esc_attr($class) . '" ', $image);
        }
        $image = preg_replace('/^(.*)?(<svg.*<\/svg>)(.*)?$/is', '$2', $image);

    } elseif (is_array($img)) {
        $image = wp_get_attachment_image($img['id'], $size, false, array('class' => $class));
    } else {
        $image = '<img class="' . esc_attr($class) . '" src="' . esc_url($img) . '" alt="' . esc_attr($file_info['filename']) . '"/>';
    };

    return $image;
}

function convert_url_to_path($url)
{
    if (!$url) {
        return false;
    }
    $url = str_replace(array('https://', 'http://'), '', $url);
    $home_url = str_replace(array('https://', 'http://'), '', site_url());
    $file_part = ABSPATH . str_replace($home_url, '', $url);
    $file_part = str_replace('//', '/', $file_part);
    if (file_exists($file_part)) {
        return $file_part;
    }

    return false;
}

function display_team($attr, $num = 3)
{
    ob_start();
    $team_args = array(
        'post_type' => 'team',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => $num
    );
    $team = new WP_Query($team_args);
    $count = wp_count_posts()->publish;
    ?>
    <?php if ($team->have_posts()) : ?>
    <div class="team">
        <div class="row">

            <?php while ($team->have_posts()) :
                $team->the_post();
                setup_postdata($post); ?>

                <div id="post-<?php the_ID(); ?>" class="team__item col-xl-4 col-lg-6">

                    <div class="team__item-inner">

                        <?php if (have_rows('socials')): ?>
                            <div class="team__item-links">
                                <?php while (have_rows('socials')): the_row();
                                    $network = get_sub_field('social_network');
                                    $link = get_sub_field('social_link');
                                    $icon = get_template_directory_uri() . '/assets/images/' . $network . '.svg';
                                    ?>
                                    <a href="<?php echo $link ?>" class="
        <?php echo $network; ?>">
                                        <?php echo display_svg($icon); ?>
                                    </a>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>


                        <div href="<?php the_permalink(); ?>" class="team__item-image">
                            <?php echo wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'team-img', false, array('class' => "of-cover")); ?>
                        </div>
                    </div>

                    <div class="team__item-desc text-center">
                        <h5 class="team__item-title">
                            <?php the_title(); ?>
                        </h5>
                        <?php if ($position = get_field('position')): ?>
                            <p class="team__item-position"> <?php echo $position; ?></p>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
    <?php if ($num > 3): ?>
        <a href="<?php echo get_post_type_archive_link('team'); ?>">more then 3 </a>
    <?php endif; ?>
<?php endif;

    $out = ob_get_clean();
    return $out;
}

add_shortcode('team', 'display_team');