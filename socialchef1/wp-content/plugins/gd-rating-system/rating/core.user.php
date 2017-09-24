<?php

if (!defined('ABSPATH')) exit;

class gdrts_core_user {
    public $id = 0;
    public $ip = '';
    public $log = array();

    public $cookie = array();

    public function __construct() {
        if (is_user_logged_in()) {
            $this->id = get_current_user_id();
        }

        $this->ip = d4p_visitor_ip();

        $this->read_cookies();
    }

    public function read_cookies() {
        $key = gdrts()->cookie_key();
        $raw = isset($_COOKIE[$key]) ? $_COOKIE[$key] : '';

        if ($raw != '') {
            $raw = stripslashes($raw);

            $this->cookie = json_decode($raw);

            if (!empty($this->cookie)) {
                $this->cookie = array_map('intval', $this->cookie);
                $this->cookie = array_filter($this->cookie);
            }
        }
    }

    public function update_cookie($log_id) {
        $log_id = intval($log_id);

        if ($log_id > 0 && !in_array($log_id, $this->cookie)) {
            $this->cookie[] = $log_id;

            setcookie(gdrts()->cookie_key(), json_encode($this->cookie), gdrts()->cookie_expiration(), '/', COOKIE_DOMAIN);
        }
    }

    public function load_log($item_id, $method, $series = null) {
        $log_ids = array();

        if ($this->id == 0) {
            $log_ids = $this->cookie;
        }

        $data = gdrts_db()->get_log_item_user_method($item_id, $this->id, $method, $series, $this->ip, $log_ids);

        if (is_null($series) || empty($series)) {
            $this->log[$item_id][$method] = $data;
        } else {
            $this->log[$item_id][$method][$series] = $data;
        }
    }

    public function get_log_item_user_method($item_id, $method, $series = null) {
        if (is_null($series)) {
            if (!isset($this->log[$item_id][$method])) {
                $this->load_log($item_id, $method);
            }

            return $this->log[$item_id][$method];
        } else {
            if (!isset($this->log[$item_id][$method][$series])) {
                $this->load_log($item_id, $method, $series);
            }

            return $this->log[$item_id][$method][$series];
        }
    }
}
