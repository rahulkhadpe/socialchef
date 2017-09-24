<?php

if (!defined('ABSPATH')) exit;

class gdrtsWidget_stars_rating_list extends d4pLib_Widget {
    public $widget_base = 'gdrts_stars_rating_list';
    public $widget_domain = 'd4prts_widgets';
    public $cache_prefix = 'd4prts';

    public $defaults = array(
        'title' => 'Top Ratings',
        '_display' => 'all',
        '_hook' => '',
        '_cached' => 0,
        '_tab' => 'global',
        '_class' => '',
        'before' => '',
        'after' => '',
        'type' => 'posts.post',
        'orderby' => 'rating', 
        'order' => 'DESC', 
        'limit' => 5, 
        'rating_min' => 0, 
        'votes_min' => 0, 
        'template' => 'widget',
        'style_type' => '',
        'style_image_name' => '',
        'style_size' => 20,
        'font_color_empty' => '', 
        'font_color_current' => '',
        'style_class' => ''
    );

    function __construct($id_base = false, $name = "", $widget_options = array(), $control_options = array()) {
        $this->widget_description = __("Show Stars Rating list.", "gd-rating-system");
        $this->widget_name = 'GD Rating System: '.__("Stars Rating List", "gd-rating-system");

        parent::__construct($this->widget_base, $this->widget_name, array(), array('width' => 500));
    }

    public function get_tabkey($tab) {
        $key = $this->get_field_id('tab-'.$tab);

        return str_replace(array('_', ' '), array('-', '-'), $key);
    }

    function get_defaults() {
        return apply_filters('gdrts_widget_settings_defaults', $this->defaults, 'stars_rating_list', 'stars-rating');
    }

    function form($instance) {
        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        $_tabs = array(
            'global' => array('name' => __("Global", "gd-rating-system"), 'include' => array('shared-global', 'shared-display')),
            'content' => array('name' => __("Content", "gd-rating-system"), 'include' => array('stars-rating-list-content')),
            'display' => array('name' => __("Display", "gd-rating-system"), 'include' => array('stars-rating-list-display')),
            'extra' => array('name' => __("Extra", "gd-rating-system"), 'include' => array('shared-wrapper'))
        );

        include(GDRTS_PATH.'forms/widgets/shared-loader.php');
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = d4p_sanitize_basic($new_instance['title']);
        $instance['_display'] = d4p_sanitize_basic($new_instance['_display']);
        $instance['_class'] = d4p_sanitize_basic($new_instance['_class']);
        $instance['_tab'] = d4p_sanitize_basic($new_instance['_tab']);
        $instance['_hook'] = d4p_sanitize_key_expanded($new_instance['_hook']);

        if (current_user_can('unfiltered_html')) {
            $instance['before'] = $new_instance['before'];
            $instance['after'] = $new_instance['after'];
        } else {
            $instance['before'] = d4p_sanitize_html($new_instance['before']);
            $instance['after'] = d4p_sanitize_html($new_instance['after']);
        }

        $instance['type'] = d4p_sanitize_basic($new_instance['type']);
        $instance['orderby'] = d4p_sanitize_basic($new_instance['orderby']);
        $instance['order'] = d4p_sanitize_basic($new_instance['order']);

        $instance['limit'] = intval($new_instance['limit']);
        $instance['rating_min'] = intval($new_instance['rating_min']);
        $instance['votes_min'] = intval($new_instance['votes_min']);

        $instance['template'] = d4p_sanitize_basic($new_instance['template']);
        $instance['style_class'] = d4p_sanitize_basic($new_instance['style_class']);
        $instance['style_type'] = d4p_sanitize_basic($new_instance['style_type']);
        $instance['style_image_name'] = d4p_sanitize_basic($new_instance['style_image_name']);
        $instance['style_size'] = intval($new_instance['style_size']);

        $instance['font_color_empty'] = d4p_sanitize_basic($new_instance['font_color_empty']);
        $instance['font_color_current'] = d4p_sanitize_basic($new_instance['font_color_current']);

        return apply_filters('gdrts_widget_settings_save', $instance, $new_instance, 'stars_rating_list', 'stars-rating');
    }

    function render($results, $instance) {
        gdrts()->load_embed();

        $instance = wp_parse_args((array)$instance, $this->get_defaults());

        echo _gdrts_widget_render_header($instance, $this->widget_base);

        echo _gdrts_embed_stars_rating_list($instance);

        echo _gdrts_widget_render_footer($instance);
    }
}
