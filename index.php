<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Vero4RTD
 */
get_header();
get_template_part( 'loop', 'index' );
get_sidebar();
get_footer();
?>