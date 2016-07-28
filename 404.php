<?php
/**
 * The template for displaying 404 pages.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
get_header();
?>
<h1><?php _e('Not Found', 'vero4rtd'); ?></h1>
	<p><?php _e('Apologies, but the page you requested could not be found. Perhaps searching will help.', 'vero4rtd'); ?></p>
	<?php get_search_form(); ?>
<script type="text/javascript">
	// focus on search field after it has loaded
	document.getElementById('s') && document.getElementById('s').focus();
</script>
<?php get_footer(); ?>