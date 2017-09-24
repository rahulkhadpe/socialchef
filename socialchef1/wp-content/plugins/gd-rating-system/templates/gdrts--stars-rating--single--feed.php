<?php // GDRTS Template: Feed // ?>

<div class="<?php gdrtsm_stars_rating()->loop()->render()->classes(); ?>">
    <div class="gdrts-inner-wrapper">

        <?php do_action('gdrts-template-rating-block-before'); ?>

        <div class="gdrts-rating-text">
            <?php

            if (gdrtsm_stars_rating()->loop()->has_votes()) {
                gdrtsm_stars_rating()->loop()->render()->text();
            } else {
                _e("No votes yet.", "gd-rating-system");
            }

            ?>
        </div>

        <?php do_action('gdrts-template-rating-block-after'); ?>
        <?php do_action('gdrts-template-rating-rich-snippet'); ?>

    </div>
</div>
