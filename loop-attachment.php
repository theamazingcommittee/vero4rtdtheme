<?php
/**
 * The loop that displays an attachment.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
if ( have_posts() ) while ( have_posts() ) : the_post();
	if ( ! empty( $post->post_parent ) ) : ?>
		<p><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'starkers' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery"><?php /* translators: %s - title of parent post */ printf( __( '&larr; %s', 'starkers' ), get_the_title( $post->post_parent ) ); ?></a></p>
	<?php endif; ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
			<h2><?php the_title(); ?></h2>
<?php
			printf(__('By %2$s', 'vero4rtd'),
				'meta-prep meta-prep-author',
				sprintf('<a href="%1$s" title="%2$s">%3$s</a>',
					get_author_posts_url(get_the_author_meta('ID')),
					sprintf(esc_attr__('View all posts by %s', 'vero4rtd'), get_the_author()),
					get_the_author()
				)
			);
?>
						|
<?php
			printf(__('Published %2$s', 'vero4rtd'),
				'meta-prep meta-prep-entry-date',
				sprintf('<abbr title="%1$s">%2$s</abbr>',
					esc_attr( get_the_time() ),
					get_the_date()
				)
			);
			if (wp_attachment_is_image()) {
				echo ' | ';
				$metadata = wp_get_attachment_metadata();
				printf(__( 'Full size is %s pixels', 'vero4rtd'),
					sprintf('<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
						wp_get_attachment_url(),
						esc_attr(__('Link to full-size image', 'vero4rtd')),
						$metadata['width'],
						$metadata['height']
					)
				);
			}
			edit_post_link(__('Edit', 'vero4rtd'), '', ''); ?>
		</header>
<?php
	if (wp_attachment_is_image()) :
		$attachments = array_values(get_children(array('post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID')));
		foreach ($attachments as $k => $attachment) {
			if ($attachment->ID == $post->ID)
				break;
		}
		$k++;
		// If there is more than 1 image attachment in a gallery
		if (count($attachments) > 1) {
			if (isset( $attachments[$k]))
				// get the URL of the next image attachment
				$next_attachment_url = get_attachment_link($attachments[$k]->ID);
			else
				// or get the URL of the first image attachment
				$next_attachment_url = get_attachment_link($attachments[0]->ID);
		} else {
			// or, if there's only 1 image attachment, get the URL of the image
			$next_attachment_url = wp_get_attachment_url();
		}
?>
				<p><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr(get_the_title()); ?>" rel="attachment"><?php
					$attachment_width  = apply_filters('vero4rtd_attachment_width', 900);
					$attachment_height = apply_filters('vero4rtd_attachment_height', 900);
					echo wp_get_attachment_image($post->ID, array($attachment_width, $attachment_height)); ?></a></p>
				<nav>
					<?php previous_image_link(false); ?>
					<?php next_image_link(false); ?>
				</nav>
<?php else : ?>
				<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr(get_the_title()); ?>" rel="attachment"><?php echo basename(get_permalink()); ?></a>
<?php
	endif;
	if (!empty($post->post_excerpt)) the_excerpt();
	the_content(__('Continue reading &rarr;', 'vero4rtd'));
	wp_link_pages(array('before' => '<nav>' . __('Pages:', 'vero4rtd'), 'after' => '</nav>')); ?>
		<footer><?php
			vero4rtd_posted_in();
			edit_post_link(__('Edit', 'vero4rtd'), ' ', '');
		?></footer>
	</article>
	<?php
		comments_template();
		endwhile; // end of the loop.
?>