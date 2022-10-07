<?php
/**
 * Archive
 *
 * Standard loop for the archive page
 */
get_header(); ?>
<main class="main-content">
    <div class="container">
        <div class="row">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
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
            <?php endif; ?>
        </div>
    </div>
</main>


<?php get_footer(); ?>
