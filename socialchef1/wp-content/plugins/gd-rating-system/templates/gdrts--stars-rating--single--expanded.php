<?php // GDRTS Template: Default with Distribution // ?>

<div class="<?php gdrtsm_stars_rating()->loop()->render()->classes(); ?>">
    <div class="gdrts-inner-wrapper">

        <?php do_action('gdrts-template-rating-block-before'); ?>

        <?php gdrtsm_stars_rating()->loop()->render()->stars(); ?>

        <div class="gdrts-rating-text">
            <?php

            if (gdrtsm_stars_rating()->loop()->has_votes()) {
                gdrtsm_stars_rating()->loop()->render()->text();

                if (gdrtsm_stars_rating()->loop()->has_distribution()) {

                ?>

                <a class="gdrts-toggle-distribution" href="#" data-show="<?php _e("Show votes.", "gd-rating-system"); ?>" data-hide="<?php _e("Hide votes.", "gd-rating-system"); ?>"><?php _e("Show votes.", "gd-rating-system"); ?></a>

                <?php

                }

            } else {
                _e("No votes yet.", "gd-rating-system");
            }

            ?>
        </div>
        <?php

        if (gdrtsm_stars_rating()->loop()->user()->has_voted()) {

        ?>

            <div class="gdrts-rating-user">
                <?php gdrtsm_stars_rating()->loop()->render()->user_vote(); ?>
            </div>

        <?php

        }

        if (gdrts_single()->is_loop_save()) {

        ?>

            <div class="gdrts-rating-thanks">
                <?php _e("Thanks for your vote!", "gd-rating-system"); ?>
            </div>

        <?php

        }

        if (gdrts_single()->is_loop()) {
            gdrtsm_stars_rating()->loop()->please_wait();
        }

        if (gdrtsm_stars_rating()->loop()->has_distribution()) {

            ?>

            <div class="gdrts-rating-distribution" style="display: none;">
                <?php gdrtsm_stars_rating()->loop()->render()->distribution(); ?>
            </div>

            <?php

        }

        ?>
        
        <?php

        gdrts_single()->json(); 

        do_action('gdrts-template-rating-block-after');
        do_action('gdrts-template-rating-rich-snippet');

        ?>

    </div>
</div>