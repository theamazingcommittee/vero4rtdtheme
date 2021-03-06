<?php
get_header('knowledgebase');

// load the style and script
wp_enqueue_style('kbe_theme_style');
if(KBE_SEARCH_SETTING == 1){
    wp_enqueue_script('kbe_live_search');
}

// Classes For main content div
if(KBE_SIDEBAR_INNER == 0) {
    $kbe_content_class = 'class="kbe_content_full"';
} elseif(KBE_SIDEBAR_INNER == 1) {
    $kbe_content_class = 'class="kbe_content_right"';
} elseif(KBE_SIDEBAR_INNER == 2) {
    $kbe_content_class = 'class="kbe_content_left"';
}

// Classes For sidebar div
if(KBE_SIDEBAR_INNER == 0) {
	$kbe_sidebar_class = 'kbe_aside_none';
} elseif(KBE_SIDEBAR_INNER == 1) {
	$kbe_sidebar_class = 'kbe_aside_left';
} elseif(KBE_SIDEBAR_INNER == 2) {
	$kbe_sidebar_class = 'kbe_aside_right';
}

// Query for tags
$kbe_tag_slug = get_queried_object()->slug;
$kbe_tag_name = get_queried_object()->name;

$kbe_tag_post_args = array(
	'post_type' => KBE_POST_TYPE,
	'posts_per_page' => 999,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'tax_query' => array(
		array(
			'taxonomy' => KBE_POST_TAGS,
			'field' => 'slug',
			'terms' => $kbe_tag_slug
		)
	)
);
$kbe_tag_post_qry = new WP_Query($kbe_tag_post_args);
?>
<div id="kbe_container">
<?php
	// Breadcrumb
	if(KBE_BREADCRUMBS_SETTING == 1){
		vero4rtd_kbe_breadcrumbs();
	}
	// search field
	if(KBE_SEARCH_SETTING == 1){
		kbe_search_form();
	}
	// content
?>
	<div id="kbe_content" <?php echo $kbe_content_class; ?>>
		<?php // leftcol ?>
		<div class="kbe_leftcol">
			<?php // <articles> ?>
			<div class="kbe_articles">
				<h2><strong>Tag: </strong><?php echo $kbe_tag_name; ?></h2>
				<ul>
<?php
				if($kbe_tag_post_qry->have_posts()) :
					while($kbe_tag_post_qry->have_posts()) :
						$kbe_tag_post_qry->the_post();
?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
					endwhile;
				endif;
?>
				</ul>
			</div>
		</div>
	</div>
	<?php // aside ?>
	<div class="kbe_aside <?php echo $kbe_sidebar_class; ?>">
	<?php
	if((KBE_SIDEBAR_INNER == 2) || (KBE_SIDEBAR_INNER == 1)){
		dynamic_sidebar('kbe_cat_widget');
	}
	?>
	</div>
</div>
<?php
get_footer('knowledgebase');
?>