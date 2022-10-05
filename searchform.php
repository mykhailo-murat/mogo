<?php
/**
 * Searchform
 *
 * Custom template for search form
 */
?>
<!-- BEGIN of search form -->
<div id="search_wrap">
    <form method="get" class="search" action="<?php echo esc_url(home_url('/')); ?>">
        <input id="search" type="search" name="s" class="search__input" placeholder="<?php _e('Search', 'fxy'); ?>"
               value="<?php echo get_search_query(); ?>" aria-label="<?php _e('Search input', 'fxy'); ?>"/>
        <button id="search_submit" type="submit" name="submit" class="search__submit"
                aria-label="<?php _e('Submit search', 'fxy'); ?>"><?php _e('Search', 'fxy'); ?></button>
    </form>
</div>
<!-- END of search form -->
