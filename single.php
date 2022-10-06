<?php
/**
 * Single
 *
 * Loop container for single post content
 */
get_header(); ?>
<?php
customSetPostViews(get_the_ID());
?>
<main class="main-content">

    <!-- BEGIN of post content -->
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

                    <h1 class="page-title entry__title"><?php the_title(); ?></h1>

                    <?php if (has_post_thumbnail()) : ?>
                        <div title="<?php the_title_attribute(); ?>" class="entry__thumb">
                            <?php the_post_thumbnail('blog-img'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry__content clearfix">
                        <?php the_content('', true); ?>
                    </div>

                    <div class="post-views">
                        <?php
                        $post_views_count = get_post_meta(get_the_ID(), 'post_views_count', true);
                        if (!empty($post_views_count)) {
                            echo '<span>' . $post_views_count . '</span>';
                        }
                        ?>
                    </div>
                    <div class="post-comments">
                        <?php echo get_comments_number(get_the_ID()) ?>
                    </div>

                    <?php comments_template(); ?>

                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <!-- END of post content -->

</main>

<?php get_footer(); ?>
