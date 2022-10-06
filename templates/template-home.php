<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>






<?php $arg = array(
    'post_type' => 'slider',
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'posts_per_page' => -1
);
$slider = new WP_Query($arg);
if ($slider->have_posts()) : ?>

    <section class="section slider swiper">
        <div class="swiper-wrapper">
            <?php while ($slider->have_posts()) : $slider->the_post(); ?>
                <?php
                setup_postdata($post);

                $image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'full_hd');
                $desc = get_field('description');
                ?>
                <div class="slider__slide swiper-slide bg-cover"
                     data-desc="<?php echo $desc ? $desc : 'slide' ?>" <?php bg($image, 'full_hd'); ?>>

                    <div class="slider__slide-content">
                        <h3 class="title slider__slide-title"><?php the_title() ?> </h3>
                        <div class="slider__slide-text"><?php the_content(); ?></div>
                        <?php if ($link = get_field('link')): ?>
                            <a class=" button hollow slider__slide-btn"
                               href="<?php echo $link['url'] ?>"><?php echo $link['title'] ?></a>
                        <?php endif; ?>


                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="swiper-pagination">

        </div>
    </section>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
<?php get_footer(); ?>
