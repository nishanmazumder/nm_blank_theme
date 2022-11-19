<?php

/**
 * Page
 *
 * @package NM_THEME
 */

get_header();

do_action('nm_page_title');

if (have_posts()) :
    while (have_posts()) : the_post();
        the_content();
    endwhile;
else :
    _e('Sorry, no posts matched your criteria.', 'nm_theme');
endif;

get_footer();
