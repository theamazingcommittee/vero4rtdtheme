<?php
/**
 * The loop that displays a single post.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */

if (have_posts()) while (have_posts()) : the_post(); ?>
		<nav>
			<?php previous_post_link( '%link', '' . _x('&larr;', 'Previous post link', 'vero4rtd') . ' %title'); ?>
			<?php next_post_link( '%link', '%title ' . _x('&rarr;', 'Next post link', 'vero4rtd') . ''); ?>
		</nav>		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<h1><?php the_title(); ?></h1>
				<?php vero4rtd_posted_on(); ?>
			</header>
			<?php
				the_content();
				wp_link_pages(array('before' => '<nav>' . __('Pages:', 'vero4rtd'), 'after' => '</nav>'));
				if (get_the_author_meta( 'description')) : // If a user has filled out their description, show a bio on their entries
					echo get_avatar(get_the_author_meta('user_email'), apply_filters( 'starkers_author_bio_avatar_size', 60)); ?>
				<h2><?php printf(esc_attr__('About %s', 'vero4rtd'), get_the_author()); ?></h2>
				<?php the_author_meta('description'); ?>
					<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
						<?php printf(__('View all posts by %s &rarr;', 'vero4rtd'), get_the_author()); ?>
					</a>
			<?php endif; ?>
			<footer>
				<?php vero4rtd_posted_in(); ?>
				<?php edit_post_link(__('Edit', 'vero4rtd'), '', ''); ?>
			</footer>
		</article>
		<nav>
			<?php previous_post_link('%link', '' . _x('&larr;', 'Previous post link', 'vero4rtd') . ' %title'); ?>
			<?php next_post_link('%link', '%title ' . _x('&rarr;', 'Next post link', 'vero4rtd') . ''); ?>
		</nav>
		<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>