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

?>

    <li>
        <a href="<?php echo gdrts_list()->item()->url(); ?>"><?php echo gdrts_list()->item()->title(); ?></a>
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
