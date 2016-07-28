<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to starkers_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
if ( post_password_required() ) : ?>
	<p><?php _e('This post is password protected. Enter the password to view any comments.', 'vero4rtd'); ?></p>
<?php
	return;
endif;
// You can start editing here -- including this comment!
if ( have_comments() ) :
	/* STARKERS NOTE: The following h3 id is left intact so that comments can be referenced on the page */ ?>
	<h3 id="comments-title"><?php
	printf(_n('One response to %2$s', '%1$s responses to %2$s', get_comments_number(), 'vero4rtd'),
		number_format_i18n(get_comments_number()), '' . get_the_title() . '');
	?></h3>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<nav>
		<?php
			previous_comments_link(__('&larr; Older Comments', 'vero4rtd'));
			next_comments_link(__('Newer Comments &rarr;', 'vero4rtd'));
		?>
	</nav>
<?php endif; // check for comment navigation
	wp_list_comments(array('style' => 'div', 'callback' => 'vero4rtd_comment', 'end-callback' => 'vero4rtd_comment_close'));
	if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through? ?>
	<nav>
		<?php
			previous_comments_link(__('&larr; Older Comments', 'vero4rtd'));
			next_comments_link(__('Newer Comments &rarr;', 'vero4rtd'));
		?>
	</nav>
<?php
	endif; // check for comment navigation
else : // or, if we don't have comments:
	if (!comments_open()) :
?>
	<p><?php _e('Comments are closed.', 'vero4rtd'); ?></p>
<?php
	endif; // end ! comments_open()
endif; // end have_comments()
comment_form(); ?>