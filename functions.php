<?php
/**
 * Starkers functions and definitions
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers HTML5 3.0
 */

/** Tell WordPress to run starkers_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'vero4rtd_setup' );

if ( ! function_exists( 'vero4rtd_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_setup() {
	add_theme_support('post-formats', array('aside', 'gallery')); // Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support('post-thumbnails'); // This theme uses post thumbnails
	add_theme_support('automatic-feed-links'); // Add default posts and comments RSS feed links to head
	add_theme_support('woocommerce'); // This theme is WooCommerce compatible.
	add_theme_support('aesop-component-styles', array('parallax', 'image', 'quote', 'gallery', 'content', 'video', 'audio', 'collection', 'chapter', 'document', 'character', 'map', 'timeline')); // This theme is compatible with the Aesop Story Engine.

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain('vero4rtd', TEMPLATEPATH . '/languages');

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(array(
		'primary' => __('Primary Navigation', 'vero4rtd'),
	));
}
endif;

if (!function_exists('vero4rtd_menu')):
/**
 * Set our wp_nav_menu() fallback, vero4rtd_menu().
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_menu() {
	echo '<nav><ul><li><a href="'.get_bloginfo('url').'">Home</a></li>';
	wp_list_pages('title_li=');
	echo '</ul></nav>';
}
endif;

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * @since Starkers HTML5 3.2
 */
add_filter('use_default_gallery_style', '__return_false');

/**
 * @since Starkers HTML5 3.0
 * @deprecated in Starkers HTML5 3.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function vero4rtd_remove_gallery_css($css) {
	return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}
// Backwards compatibility with WordPress 3.0.
if (version_compare($GLOBALS['wp_version'], '3.1', '<'))
	add_filter('gallery_style', 'vero4rtd_remove_gallery_css');

if (!function_exists('vero4rtd_comment')):
/**
 * Template for comments and pingbacks.
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __('%s says:', 'vero4rtd'), sprintf( '%s', get_comment_author_link() ) ); ?>
		<?php if ($comment->comment_approved == '0'): ?>
			<?php _e('Your comment is awaiting moderation.', 'vero4rtd'); ?>
			<br />
		<?php endif; ?>

		<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf(__('%1$s at %2$s', 'vero4rtd'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(__('(Edit)', 'vero4rtd'), ' ');
			?>
		<?php comment_text(); ?>
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<article <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<p><?php _e('Pingback:', 'vero4rtd'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'vero4rtd'), ' '); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Closes comments and pingbacks with </article> instead of </li>.
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_comment_close() {
	echo '</article>';
}

/**
 * Adjusts the comment_form() input types for HTML5.
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_fields($fields) {
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');
	$fields =  array(
		'author' => '<p><label for="author">' . __('Name') . '</label> ' . ($req ? '*' : '') .
		'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p><label for="email">' . __('Email') . '</label> ' . ($req ? '*' : '') .
		'<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p><label for="url">' . __('Website') . '</label>' .
		'<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
	);
	return $fields;
}
add_filter('comment_form_default_fields','vero4rtd_fields');

/**
 * Register widgetized areas.
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar(array(
		'name' => __('Primary Widget Area', 'vero4rtd'),
		'id' => 'primary-widget-area',
		'description' => __('The primary widget area', 'vero4rtd'),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar(array(
		'name' => __('Secondary Widget Area', 'vero4rtd'),
		'id' => 'secondary-widget-area',
		'description' => __('The secondary widget area', 'vero4rtd'),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Area 3, located in the footer. Empty by default.
	register_sidebar(array(
		'name' => __('First Footer Widget Area', 'vero4rtd'),
		'id' => 'first-footer-widget-area',
		'description' => __('The first footer widget area', 'vero4rtd'),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Area 4, located in the footer. Empty by default.
	register_sidebar(array(
		'name' => __('Second Footer Widget Area', 'vero4rtd'),
		'id' => 'second-footer-widget-area',
		'description' => __('The second footer widget area', 'vero4rtd'),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __('Third Footer Widget Area', 'vero4rtd'),
		'id' => 'third-footer-widget-area',
		'description' => __('The third footer widget area', 'vero4rtd'),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Area 6, located in the footer. Empty by default.
	register_sidebar(array(
		'name' => __('Fourth Footer Widget Area', 'vero4rtd'),
		'id' => 'fourth-footer-widget-area',
		'description' => __('The fourth footer widget area', 'vero4rtd'),
		'before_widget' => '<li>',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
/** Register sidebars by running starkers_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'vero4rtd_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * @updated Starkers HTML5 3.2
 */
function vero4rtd_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'vero4rtd_remove_recent_comments_style' );

if (!function_exists('vero4rtd_posted_on')):
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_posted_on() {
	printf(__('Posted on %2$s by %3$s', 'vero4rtd'),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time datetime="%3$s" pubdate>%4$s</time></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date('Y-m-d'),
			get_the_date()
		),
		sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
			get_author_posts_url(get_the_author_meta('ID')),
			sprintf(esc_attr__('View all posts by %s', 'vero4rtd'), get_the_author()),
			get_the_author()
		)
	);
}
endif;

if (!function_exists('vero4rtd_posted_in')):
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Starkers HTML5 3.0
 */
function vero4rtd_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'vero4rtd');
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'vero4rtd');
	} else {
		$posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'vero4rtd');
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/**
 * WooCommerce compatibility
 *
 *
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
 
add_action('woocommerce_before_main_content', 'vero4rtd_woowrapper_start', 10);
add_action('woocommerce_after_main_content', 'vero4rtd_woowrapper_end', 10);

function vero4rtd_woowrapper_start() {
	// Add content to start the WooCommerce wrapper.
}
function vero4rtd_woowrapper_end() {
	// Add content to end the WooCommerce wrapper.
}

/**
 * WP-Knowledgebase Breadcrumbs function
 * A theme specific version of kbe_breadcrumbs();
 */
function vero4rtd_kbe_breadcrumbs() {
	// TODO: Change code to work better with the theme.
	$parts = array(
		array(
			'text' => __('Home', 'wp-knowledgebase'),
			'href' => home_url(),
		),
		array(
			'text' => ucwords(strtolower(KBE_PLUGIN_SLUG)),
			'href' => home_url(KBE_PLUGIN_SLUG),
		),
	);
	if (is_tax(array('kbe_taxonomy', 'knowledgebase_category', 'kbe_tags', 'knowledgebase_tags'))) {
		$parts[] = array(
			'text' => get_queried_object()->name,
		);
	} elseif (is_search()) {
		$parts[] = array(
			'text' => esc_html($_GET['s']),
		);
	} elseif (is_single()) {
		$kbe_bc_term = get_the_terms(get_the_ID(), KBE_POST_TAXONOMY);
		foreach ($kbe_bc_term as $kbe_tax_term) {
			$parts[] = array(
				'text' => $kbe_tax_term->name,
				'href' => get_term_link($kbe_tax_term->slug, KBE_POST_TAXONOMY),
			);
		}
		$title = strlen(get_the_title()) >= 50 ? substr(get_the_title(), 0, 50) . '&hellip;' : get_the_title();
		$parts[] = array(
		'text' => $title,
		);
	}
	$parts = apply_filters('wp_knowledgebase_breadcrumb_parts', $parts);
	echo '<ol class="breadcrumb">';
	foreach ($parts as $k => $part) {
		$part = wp_parse_args($part, array('text' => '', 'href' => ''));
		echo "<li";
		if ($k === end($keys)) {
			echo ' class="active"';	
		}
		echo ">";
		if ($k !== end($keys)) {
			echo '<a href="' . esc_url($part['href']) . '">' . wp_kses_post($part['text']) . '</a>';
		} else {
			echo wp_kses_post($part['text']);
		}
		echo "</li>";
		$keys = array_keys($parts);
	}
	echo "</ol>";
}
?>