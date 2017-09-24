<?php

if (!defined('ABSPATH')) exit;

class gdrts_engine_single {
    private $_suppress_filters = false;
    private $_loop_status = 'none';

    private $_args;
    private $_item;
    private $_user;

    private $_method_args;

    public $abort = false;

    public function __construct() {}

    public function set_method_args($args) {
        $this->_method_args = $args;
    }

    public function do_suppress_filters($suppress = true) {
        $this->_suppress_filters = $suppress;
    }

    public function do_loop_status($status = 'loop') {
        $this->_loop_status = $status;
    }

    public function is_suppress_filters() {
        return $this->_suppress_filters;
    }

    public function is_loop() {
        return $this->_loop_status == 'loop';
    }

    public function is_loop_save() {
        return $this->_loop_status == 'save';
    }

    public function render($args, $method) {
        do_action('gdrts_single_render_pre_process', $args, $method);

        $this->loop($args, $method);

        if ($this->abort) {
            return '';
        }

        $render = apply_filters('gdrts_engine_single_rendering_override', false, $this->_args, $this->_method_args);

        if ($render === false) {
            $templates = array();

            if (!$this->is_suppress_filters()) {
                $templates = apply_filters('gdrts_render_single_templates_pre', $templates, $this->_item);
            }

            if (empty($templates)) {
                switch ($this->_args['method']) {
                    case 'stars-rating':
                        $templates = gdrtsm_stars_rating()->loop()->templates_single($this->_item);
                        break;
                    default:
                        $templates = apply_filters('gdrts_render_single_templates_'.$this->_args['method'], array(), $this->_item);
                        break;
                }
            }

            if (!$this->is_suppress_filters()) {
                $templates = apply_filters('gdrts_render_single_templates', $templates, $this->_item);
            }

            $render = gdrts_return_template($templates);
        }

        if ($this->_args['echo']) {
            echo $render;
        }

        return $render;
    }

    public function loop($args, $method) {
        $defaults = apply_filters('gdrts_single_block_render_defaults', array(
            'echo' => false, 
            'entity' => null, 
            'name' => null, 
            'item_id' => null,
            'id' => null,
            'method' => 'stars-rating',
            'series' => null
        ));

        $this->_args = wp_parse_args($args, $defaults);

        $this->abort = false;

        if (gdrts_is_method_loaded($this->_args['method'])) {
            if ($this->_loop_status == 'none') {
                $this->do_loop_status();
            }

            $this->_item = gdrts_get_rating_item($this->_args);

            switch ($this->_args['method']) {
                case 'stars-rating':
                    gdrtsm_stars_rating()->prepare_loop_single($method, $this->_args);
                    break;
                default:
                    do_action('gdrts_loop_single_method_'.$this->_args['method'].'_prepare', $method, $this->_args);
                    break;
            }
        } else {
            $this->abort = true;
        }
    }

    /** @return gdrts_rating_item */
    public function item() {
        return $this->_item;
    }

    /** @return gdrts_core_user */
    public function user() {
        return $this->_user;
    }

    public function user_init() {
        $this->_user = new gdrts_core_user();
        $this->_user->load_log($this->item()->item_id, $this->args('method'), $this->args('series'));
    }

    public function args($arg) {
        return isset($this->_args[$arg]) ? $this->_args[$arg] : null;
    }

    public function set_arg($arg, $value) {
        $this->_args[$arg] = $value;
    }

    public function loop_arg($name) {
        if (isset($this->_args[$name])) {
            return $this->_args[$name];
        } else {
            return null;
        }
    }

    public function json() {
        $data = apply_filters('gdrts_loop_single_json_data', array(
            'item' => $this->_item->item_data(),
            'render' => array(
                'args' => $this->_args,
                'method' => array()
            )
        ), $this->_args['method']);

        echo '<script class="gdrts-rating-data" type="application/json">';
        echo json_encode($data);
        echo '</script>';
    }
}

global $_gdrts_engine_single;

$_gdrts_engine_single = new gdrts_engine_single();

function gdrts_single() {
    global $_gdrts_engine_single;
    return $_gdrts_engine_single;
}
