<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>


<!--SLIDER-->
<?php $slider_args = array(
    'post_type' => 'slider',
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'posts_per_page' => -1
);
$slider = new WP_Query($slider_args);
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
                        <h2 class="title slider__slide-title"><?php the_title() ?> </h2>
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
<!--END SLIDER-->


<!--LATEST POSTS-->
<?php $blog_args = array(
    'post_type' => 'post',
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'posts_per_page' => 3
);
$blog = new WP_Query($blog_args);
$count = wp_count_posts()->publish;
?>
<?php if ($blog->have_posts()) : ?>
    <section class="section blog">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="section__header">
                        <h3 class="title section__title blog__title"> <?php _e('Our stories', 'default'); ?></h3>
                        <h2 class="section__subtitle blog__subtitle"><?php _e('Latest blog', 'default'); ?> </h2>
                    </div>
                </div>


                <?php while ($blog->have_posts()) : $blog->the_post();
                    setup_postdata($post); ?>
                    <acticle id="post-<?php the_ID(); ?>" class="blog__post col-xl-4 col-lg-6">
                        <a href="<?php the_permalink(); ?>" class="blog__post-image">
                            <?php echo wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'blog-img', false, array('class' => "of-cover")); ?>
                        </a>
                        <div class="blog__post-date">
                            <span class="day"> <?php echo get_the_date('d') ?></span>
                            <span class="mon"> <?php echo get_the_date('M') ?></span>
                        </div>
                        <h5 class="blog__post-title">
                            <?php the_title(); ?>
                        </h5>
                        <div class="blog__post-content">
                            <?php wp_trim_words(the_content(), 80); ?>
                        </div>
                        <div class="blog__post-meta">
                            <div class="post-views">
                                <?php
                                $post_views_count = get_post_meta(get_the_ID(), 'post_views_count', true);
                                if (!empty($post_views_count)) {
                                    echo '<span>' . $post_views_count . '</span>';
                                } else {
                                    echo '0';
                                }
                                ?>
                            </div>
                            <div class="post-comments">
                                <?php echo get_comments_number(get_the_ID()) ?>
                            </div>
                        </div>
                    </acticle>
                <?php endwhile; ?>
                <?php if ($count > 3): ?>
                    <div class="col-12">
                        <a class="blog__link"
                           href="<?php echo get_permalink(get_option('page_for_posts')); ?>"> <?php _e('All Blogs', 'default') ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
<!--END LATEST POSTS-->

<!--SERVICES-->
<section class="section service">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__header text-center">
                    <?php if ($service_title = get_field('service_title')): ?>
                        <h3 class="title section__title"> <?php echo $service_title; ?></h3>
                    <?php endif; ?>
                    <?php if ($service_subtitle = get_field('service_subtitle')): ?>
                        <h2 class="section__subtitle "><?php echo $service_subtitle ?> </h2>
                    <?php endif; ?>

                    <?php if ($service_text = get_field('service_text')): ?>
                        <div class="section__text">
                            <?php echo $service_text; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">

                <?php if ($service_img = get_field('service_img')): ?>
                    <div class="service__img">
                        <?php echo wp_get_attachment_image($service_img['id'], 'full', false, array('class' => 'of-cover')); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-xl-6">
                <?php
                if (have_rows('service_acc')): ?>
                    <div class="accordion" id="accordion-1">
                        <?php while (have_rows('service_acc')): the_row(); ?>
                            <?php $first = get_row_index() == 1;
                            $icon = get_sub_field('service_acc_ico');
                            ?>
                            <div class="card">
                                <div class="card-header" id="<?php echo get_row_index(); ?>">
                                    <h5 class="mb-0">
                                        <a href="#" class="accordion__title <?php echo !$first ? 'collapsed' : ''; ?>" data-toggle="collapse"
                                           data-target="#collapse-<?php echo get_row_index() ?>"
                                           aria-expanded="true"
                                           aria-controls="collapse-<?php echo get_row_index() ?>">
                                            <?php echo wp_get_attachment_image($icon['id'], 'full', false, array('class' => 'accordion__title-ico')); ?>
                                            <?php the_sub_field('service_acc_title') ?>
                                        </a>
                                    </h5>
                                </div>

                                <div id="collapse-<?php echo get_row_index(); ?>"
                                     class="collapse <?php echo $first ? 'show' : ''; ?> "
                                     aria-labelledby="heading-<?php echo get_row_index() ?>"
                                     data-parent="#accordion-1">
                                    <div class="card-body">
                                        <?php the_sub_field('service_acc_text') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</section>
<!--END SERVICES-->

<?php get_footer(); ?>
