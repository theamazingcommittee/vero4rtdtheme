<?php
/**
 * The loop that displays posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */
/* Display navigation to next/previous pages when applicable */
if ($wp_query->max_num_pages > 1) : ?>
    <nav>
        <?php
	        next_posts_link(__('&larr; Older posts', 'vero4rtd'));
	        previous_posts_link(__('Newer posts &rarr;', 'vero4rtd'));
	    ?>
    </nav>
<?php
endif;
/* If there are no posts to display, such as an empty archive page */
if (!have_posts()) : ?>
        <h1><?php _e('Not Found', 'vero4rtd'); ?></h1>
            <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'vero4rtd'); ?></p>
            <?php get_search_form();
endif;
while ( have_posts() ) : the_post();
/* How to display posts of the Gallery format. The gallery category is the old way. */
if ((function_exists('get_post_format') && 'gallery' == get_post_format($post->ID)) || in_category(_x('gallery', 'gallery category slug', 'vero4rtd'))) : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header>
                <h2><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'vero4rtd'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <?php vero4rtd_posted_on(); ?>
            </header>
<?php
	if (post_password_required()) :
		the_content();
	else :
		$images = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999));
		if ($images) :
        	$total_images = count($images);
			$image = array_shift($images);
			$image_img_tag = wp_get_attachment_image($image->ID, 'thumbnail'); ?>
            <a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
            <p><?php printf(_n('This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'vero4rtd'), 'href="' . get_permalink() . '" title="' . sprintf(esc_attr__('Permalink to %s', 'vero4rtd'), the_title_attribute('echo=0')) . '" rel="bookmark"', number_format_i18n($total_images)); ?></p>
	<?php
		endif;
		the_excerpt();
	endif; ?>
            <footer>
	            <?php if (function_exists('get_post_format') && 'gallery' == get_post_format($post->ID)) : ?>
	            <a href="<?php echo get_post_format_link('gallery'); ?>" title="<?php esc_attr_e('View Galleries', 'vero4rtd'); ?>"><?php _e('More Galleries', 'vero4rtd'); ?></a> | 
	            <?php elseif (in_category(_x('gallery', 'gallery category slug', 'vero4rtd'))) : ?>
	            <a href="<?php echo get_term_link(_x( 'gallery', 'gallery category slug', 'vero4rtd'), 'category'); ?>" title="<?php esc_attr_e('View posts in the Gallery category', 'vero4rtd' ); ?>"><?php _e('More Galleries', 'vero4rtd'); ?></a> | 
	            <?php endif;
		            comments_popup_link(__('Leave a comment', 'vero4rtd'), __('One comment', 'vero4rtd' ), __('% comments', 'vero4rtd'));
		            edit_post_link(__('Edit', 'vero4rtd'), '| ', ''); ?>
            </footer>
        </article>
<?php /* How to display posts of the Aside format. The asides category is the old way. */
	elseif ((function_exists( 'get_post_format' ) && 'aside' == get_post_format( $post->ID ) ) || in_category( _x( 'asides', 'asides category slug', 'vero4rtd'))) : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search.
             the_excerpt();
        else :
        	the_content(__('Continue reading &rarr;', 'vero4rtd'));
        endif; ?>
            <footer>
                <?php vero4rtd_posted_on(); ?> | <?php comments_popup_link(__('Leave a comment', 'vero4rtd'), __('One comment', 'vero4rtd'), __('% comments', 'vero4rtd')); ?> <?php edit_post_link(__( 'Edit', 'vero4rtd' ), '| ', ''); ?>
            </footer>
        </article>
<?php /* How to display all other posts. */
	else : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
                <h2><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'vero4rtd'), the_title_attribute( 'echo=0' )); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <?php vero4rtd_posted_on(); ?>
            </header>
    <?php
	    if (is_archive() || is_search()) : // Only display excerpts for archives and search.
            the_excerpt();
		else :
			the_content(__('Continue reading &rarr;', 'vero4rtd'));
			wp_link_pages( array( 'before' => '<nav>' . __( 'Pages:', 'vero4rtd' ), 'after' => '</nav>' ) );
		endif; ?>
            <footer>
                <?php
	                if (count(get_the_category())) :
	                	printf(__('Posted in %2$s', 'vero4rtd'), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list(', ')); ?> |
                <?php
	                endif;
                    $tags_list = get_the_tag_list('', ', ');
                    if ($tags_list):
                        printf(__('Tagged %2$s', 'vero4rtd'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list); ?> |
                <?php
	                endif;
	                comments_popup_link(__('Leave a comment', 'vero4rtd'), __('One comment', 'vero4rtd'), __('% comments', 'vero4rtd'));
	                edit_post_link(__('Edit', 'vero4rtd'), '| ', ''); ?>
            </footer>
		</article>
            <?php comments_template( '', true );
    endif; // This was the if statement that broke the loop into three parts based on categories.
endwhile; // End the loop. Whew.
/* Display navigation to next/previous pages when applicable */
if (  $wp_query->max_num_pages > 1 ) : ?>
    <nav>
        <?php next_posts_link(__('&larr; Older posts', 'vero4rtd')); ?>
        <?php previous_posts_link(__('Newer posts &rarr;', 'vero4rtd')); ?>
    </nav>
<?php endif; ?>