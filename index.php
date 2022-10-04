<?php
/**
 * Index
 *
 * Standard loop for the front-page
 */
get_header(); ?>
    <main class="main-content">
        <div class="grid-container">
            <div class="grid-x grid-margin-x posts-list">
                <!-- BEGIN of main content -->
                <div class="large-8 medium-8 small-12 cell">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) :
                            the_post(); ?>
                            <?php get_template_part('parts/loop', 'post'); // Post item?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <!-- END of main content -->
            </div>
        </div>
    </main>

<?php get_footer(); ?><?php
