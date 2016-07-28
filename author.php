<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
get_header();
if ( have_posts() )
    the_post();
?>
<h1><?php printf(__('Author Archives: %s', 'vero4rtd'), "<span class='vcard'><a class='url fn n' href='" . get_author_posts_url(get_the_author_meta('ID')) . "' title='" . esc_attr(get_the_author()) . "' rel='me'>" . get_the_author() . "</a></span>"); ?></h1>
<?php
// If a user has filled out their description, show a bio on their entries.
if (get_the_author_meta('description')) :
    echo get_avatar(get_the_author_meta('user_email'), apply_filters('vero4rtd_author_bio_avatar_size', 60)); ?>
    <h2><?php printf(__('About %s', 'vero4rtd'), get_the_author()); ?></h2>
    <?php the_author_meta('description');
endif;
rewind_posts();
get_template_part('loop', 'author');
get_sidebar();
get_footer();
?>