<?php
/**
 * The loop that displays a page.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
if (have_posts()) while (have_posts()) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<?php if (is_front_page()) { ?>
			<h2><?php the_title(); ?></h2>
		<?php } else { ?>	
			<h1><?php the_title(); ?></h1>
		<?php } ?>
	</header>
		<?php
			the_content();
			wp_link_pages(array('before' => '<nav>' . __('Pages:', 'vero4rtd'), 'after' => '</nav>'));
		?>
	<footer>
		<?php edit_post_link(__('Edit', 'vero4rtd'), '', ''); ?>
	</footer>
</article>
<?php
comments_template( '', true );
endwhile;
?>