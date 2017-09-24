<?php
	global $post, $sc_recipe_class, $sc_include_edit_link, $sc_theme_globals;
	
	$recipe_id = $post->ID;
	$recipe_obj = new sc_recipe($post);
	$recipe_difficulty = null;
	if ($sc_theme_globals->enable_recipe_meta()) {
		$recipe_difficulty = $recipe_obj->get_difficulty();
	}
	$recipe_comments = get_comments_number( $recipe_id );
	global $current_user;
	if (!isset($current_user)) {
		$current_user = wp_get_current_user();
	} 
	$sc_include_edit_link = $sc_include_edit_link && ($recipe_obj->get_post_author() == $current_user->ID || is_super_admin());
?>
<!--item-->
<div class="entry <?php echo $sc_recipe_class; ?> recipe-item">
	<?php if ($sc_include_edit_link) { ?>
	<a class="edit" href="<?php echo esc_url ( $sc_theme_globals->get_submit_recipes_url() ); ?>?fesid=<?php echo urlencode($recipe_id); ?>" title="<?php _e('Edit recipe', 'socialchef'); ?>"><?php _e('Edit recipe', 'socialchef'); ?></a>
	<?php } ?>
	<figure>
<?php 
	$main_image = $recipe_obj->get_main_image('thumb-image');
	if (!empty( $main_image ) ) { ?>
		<img src="<?php echo esc_url ( $main_image ); ?>" alt="<?php the_title(); ?>" />
		<figcaption><a href="<?php echo esc_url ( $recipe_obj->get_permalink() ); ?>"><i class="icon icon-themeenergy_eye2"></i> <span><?php _e('View recipe', 'socialchef'); ?></span></a></figcaption>
<?php } ?>
	</figure>
	<div class="container">
		<h2>
			<a href="<?php echo esc_url ($recipe_obj->get_permalink() ); ?>"><?php the_title(); ?></a>
		</h2>
		<div class="actions">
			<div>
				<?php if ($recipe_difficulty) { ?>
				<div class="difficulty"><i class="ico i-<?php echo esc_attr($recipe_difficulty->slug); ?>"></i> <?php echo $recipe_difficulty->name; ?></div>
				<?php } ?>
				<!-- <div class="likes"><i class="ico i-likes"></i><a href="#">10</a></div>-->
				<div class="comments"><i class="fa fa-comment"></i><a href="<?php echo esc_url ($recipe_obj->get_permalink() ); ?>#comments"><?php echo $recipe_comments; ?></a></div>
			</div>
		</div>
	</div>
</div>
<!--item-->