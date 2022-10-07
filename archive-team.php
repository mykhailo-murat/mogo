<?php
/**
 * Archive
 *
 * Standard loop for the archive page
 */
get_header(); ?>

    <main class="main-content team">
        <div class="container">
            <div class="row">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
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
                <?php endif; ?>
            </div>
        </div>
    </main>


<?php get_footer(); ?>