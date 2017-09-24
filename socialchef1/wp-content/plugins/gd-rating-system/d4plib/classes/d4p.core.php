<?php

/*
Name:    d4pLib_Class_Core
Version: v1.9.6
Author:  Milan Petrovic
Email:   milan@gdragon.info
Website: https://www.dev4press.com/libs/d4plib/

== Copyright ==
Copyright 2008 - 2017 Milan Petrovic (email: milan@gdragon.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('d4pCORE')) {
    abstract class d4pCORE {
        public $is_debug;
        public $wp_version;

        function __construct() {
            add_action('plugins_loaded', array($this, 'core'));
            add_action('after_setup_theme', array($this, 'init'));
        }

        public function core() {
            global $wp_version;

            $this->wp_version = substr(str_replace('.', '', $wp_version), 0, 2);

            add_action('widgets_init', array($this, 'widgets_init'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        }

        public function init() {
            $this->is_debug = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;
        }

        public function widgets_init() { }

        public function enqueue_scripts() { }
    }
}
