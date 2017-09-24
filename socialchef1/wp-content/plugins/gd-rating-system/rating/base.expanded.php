<?php

if (!defined('ABSPATH')) exit;

function gdrts_posts_render_rating($args = array(), $method = array()) {
    $defaults = array(
        'echo' => false,
        'name' => '', 
        'id' => null, 
        'method' => 'stars-rating',
        'series' => null
    );

    $args = wp_parse_args($args, $defaults);

    if (is_null($args['id']) || $args['id'] == 0) {
        $post = get_post();

        if ($post) {
            $args['id'] = get_post()->ID;
            $args['name'] = get_post()->post_type;
        }
    }

    if (empty($args['name'])) {
        $post = get_post($args['id']);

        if ($post) {
            $args['name'] = get_post()->post_type;
        }
    }

    $args['entity'] = 'posts';

    if (!is_null($args['id']) && !empty($args['name'])) {
        return gdrts_render_rating($args, $method);
    } else {
        return '';
    }
}

function gdrts_comments_render_rating($args = array(), $method = array()) {
    $defaults = array(
        'echo' => false,
        'name' => 'comment', 
        'id' => null, 
        'method' => 'stars-rating',
        'series' => null
    );

    $args = wp_parse_args($args, $defaults);

    if (is_null($args['id']) || $args['id'] == 0) {
        $comment = get_comment();

        if ($comment) {
            $args['id'] = $comment->comment_ID;
            $args['name'] = $comment->comment_type == '' ? 'comment' : $comment->comment_type;
        }
    }

    $args['entity'] = 'comments';

    if (!is_null($args['id'])) {
        return gdrts_render_rating($args, $method);
    } else {
        return '';
    }
}
