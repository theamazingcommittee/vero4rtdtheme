<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
get_header();
if (have_posts())
	the_post();
?>
<h1><?php
	if (is_day()) :
		printf(__('Daily Archives: %s', 'vero4rtd'), get_the_date());
	elseif (is_month()) :
		printf(__('Monthly Archives: %s', 'vero4rtd'), get_the_date('F Y'));
	elseif (is_year()) :
		printf(__('Yearly Archives: %s', 'vero4rtd'), get_the_date('Y') );
	else :
		_e('Blog Archives', 'vero4rtd');
	endif; ?></h1>
<?php
rewind_posts();
get_template_part( 'loop', 'archive' );
get_sidebar();
get_footer();
?>