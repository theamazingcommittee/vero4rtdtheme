<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
?>
<footer>
<?php
	get_sidebar( 'footer' );
?>
	<a href="<?php echo home_url('/') ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
	<?php do_action('vero4rtd_credits'); ?>
	<a href="<?php echo esc_url(__('http://wordpress.org/', 'vero4rtd')); ?>" title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'vero4rtd'); ?>" rel="generator"> 
		<?php printf(__('Proudly powered by %s.', 'vero4rtd'), 'WordPress'); ?>
	</a>
</footer>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
?>
</body>
</html>