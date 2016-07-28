<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
get_header();
if (have_posts()) : ?>
	<h1><?php printf( __( 'Search Results for: %s', 'vero4rtd' ), '' . get_search_query() . '' ); ?></h1>
	<?php get_template_part('loop', 'search');
else : ?>
	<h2><?php _e('Nothing Found', 'vero4rtd'); ?></h2>
	<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'vero4rtd'); ?></p>
	<?php get_search_form();
endif;
get_sidebar();
get_footer();
?>