<?php

/*
Name:    d4pLib_Class_Admin
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

if (!class_exists('d4pADMIN')) {
    abstract class d4pADMIN {
        public $is_debug;

        public $page = false;
        public $panel = false;
        public $action = false;

        public $menu_items;

        function __construct() { }

        public function core() {
            $this->is_debug = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG;

            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_init', array($this, 'admin_columns'));
            add_action('admin_menu', array($this, 'admin_meta'));
            add_action('admin_menu', array($this, 'admin_menu'));

            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        }

        public function admin_init() {
            if (isset($_GET['panel']) && $_GET['panel'] != '') {
                $this->panel = trim(sanitize_key($_GET['panel']));
            }
        }

        public function admin_load_hooks() {
            foreach ($this->page_ids as $id) {
                add_action('load-'.$id, array($this, 'load_admin_page'));
            }
        }

        public function admin_meta() { }

        public function admin_columns() { }

        public function enqueue_scripts($hook) { }

        public function admin_menu() { }

        public function load_admin_page() { }

        public function help_tab_sidebar($plugin = '', $title = '') {
            $screen = get_current_screen();

            $screen->set_help_sidebar(
                '<p><strong>'.$title.'</strong></p>'.
                '<p><a target="_blank" href="https://plugins.dev4press.com/'.$plugin.'/">'.__("Home Page", "d4plib").'</a><br/>'.
                '<a target="_blank" href="https://support.dev4press.com/kb/product/'.$plugin.'/">'.__("Knowledge Base", "d4plib").'</a><br/>'.
                '<a target="_blank" href="https://support.dev4press.com/forums/forum/plugins/'.$plugin.'/">'.__("Support Forum", "d4plib").'</a></p>'
            );
        }

        public function help_tab_getting_help($plugin = '') {
            $screen = get_current_screen();

            $screen->add_help_tab(
                array(
                    'id' => 'd4p-help-info',
                    'title' => __("Getting Help", "d4plib"),
                    'content' => '<p>'.__("To get help with this plugin, you can start with Knowledge Base list of frequently asked questions and articles. If you have any questions, or you want to report a bug, or you have a suggestion, you can use support forum. All important links for this are on the right side of this help dialog.", "d4plib").'</p>'
                )
            );
        }
    }
}
