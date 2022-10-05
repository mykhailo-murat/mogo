<?php
/**
 * Header
 */
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Add external fonts  -->

    <?php wp_head(); ?>
</head>

<body <?php body_class('no-outline'); ?>>
<?php wp_body_open(); ?>


<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="logo">
                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

                    if (has_custom_logo()) {
                        echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
                    } else {
                        echo '<h1>' . get_bloginfo('name') . '</h1>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-8 text-right">

                <?php if (has_nav_menu('header-menu')) : ?>
                    <nav class="navbar navbar-expand-lg ">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse " id="navbarNav">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'header-menu',
                                'menu_class' => 'menu header-menu',
                                'items_wrap' => '<ul id="%1$s" class="%2$s" >%3$s</ul>',
                            )); ?>
                        </div>
                        <a class="header__cart" href="#"></a>
                        <div class="header__search">
                            <?php get_search_form(); ?>
                        </div>
                    </nav>
                <?php endif; ?>
            </div>

        </div>
    </div>

</header>
