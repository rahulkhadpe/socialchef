<?php // GDRTS Template: Widget // ?>

<div class="<?php gdrtsm_stars_rating()->loop()->render()->classes(); ?>">
    <div class="gdrts-inner-wrapper">

<?php

if (gdrts_list()->have_items()) :
    
?>

<ol>

<?php

    while (gdrts_list()->have_items()) :
        gdrts_list()->the_item();

		$recipe_id = gdrts_list()->item()->id;
		$image_id = get_post_thumbnail_id( $recipe_id );
		$image_src = '';
		if ($image_id > 0) {
			$image_src = SocialChef_Theme_Utils::get_image_src($image_id, 'thumbnail');
		}
?>
    <li>
		<a href="<?php echo gdrts_list()->item()->url(); ?>">
		<figure>
		<?php if (!empty($image_src)) { ?>
			<img src="<?php echo $image_src; ?>" alt="<?php echo esc_attr(gdrts_list()->item()->title()); ?>" />
		<?php } ?>
		</figure>
		</a>
        <h3><a href="<?php echo gdrts_list()->item()->url(); ?>"><?php echo gdrts_list()->item()->title(); ?></a></h3>
        <div class="gdrts-widget-rating"><?php gdrtsm_stars_rating()->loop()->render()->text(); ?></div>
        <div class="gdrts-widget-rating-stars"><?php gdrtsm_stars_rating()->loop()->render()->stars(); ?></div>
    </li>

<?php

    endwhile;

?>

</ol>

<?php

else :

?>

<?php _e("No items found.", "gd-rating-system"); ?>

<?php

endif;

?>


        <?php gdrts_list()->json(); ?>

    </div>
</div>
