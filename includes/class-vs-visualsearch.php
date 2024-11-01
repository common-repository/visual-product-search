<?php

/* ------------------------------------------------------------------------------
 * * File:        class-vs-visualsearch.php
 * * Class:       VsVisualSearch
 * * Description: Class VsVisualSearch handles plugin textdomain and admin menu for Visual Search Plugin. 
 * * Version:     1.0.0
 * *
 * *
 * * Methods:
 * *             visualsearch_load_textdomain()
 * *             vs_visualsearch_admin_MainMenu()
 * *             vs_visualsearch_dashboard() * *     
 * *     
 * *     
 * * Updated:     25-April-2019
 * * Author:      Mir Tahajjat Hossain
 * * Email :      tahajjat@accelx.net
 * * Homepage:    www.accelx.net 
 * *------------------------------------------------------------------------------
 * * COPYRIGHT (c) 2019 - 2020 Accelx Inc.
 * *
 * * The source code included in this package is free software; you can
 * * redistribute it and/or modify it under the terms of the GNU General Public
 * * License as published by the Free Software Foundation. This license can be
 * * read at:
 * *
 * * http://www.opensource.org/licenses/gpl-license.php
 * *
 * * This program is distributed in the hope that it will be useful, but WITHOUT 
 * * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. 
 * *------------------------------------------------------------------------------ */

//VisualSearch
class VsVisualSearch {

    /**
     * VisualSearch version.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * The single instance of the class.
     *
     * @var VisualSearch
     * 
     */
    protected static $_instance = null;

    /**
     * Main VisualSearch Instance.
     *
     * Ensures only one instance of VisualSearch is loaded or can be loaded.
     *
     * @static
     * @return VisualSearch - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * VisualSearch Constructor.
     */
    public function __construct() {

        add_action('plugins_loaded', array($this, 'visualsearch_load_textdomain'));
        add_action('admin_menu', array($this, 'vs_visualsearch_admin_MainMenu'));
    }

    /**
     * Load language files
     * @action plugins_loaded
     */
    public function visualsearch_load_textdomain() {
        load_plugin_textdomain('visual-search', false, VISUALSEARCH__PLUGIN_DIR . "languages");
    }

    function vs_visualsearch_admin_MainMenu() {


        $page_title = __('Visual Search Plugin Dashboard', 'visual-search');
        $menu_title = __('Visual Search', 'visual-search');
        $capability = 'manage_options';
        $menu_slug = 'vs-dashboard';
        $callbcakfunction = array($this, 'vs_visualsearch_dashboard');
        //  $callbcakfunction ='vs_visualsearch_dashboard';
        $icon_url = 'dashicons-share-alt';
        $position = '';

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $callbcakfunction, $icon_url, $position);


    }

    /**
     * Display callback for the menu dashboard.
     */
    function vs_visualsearch_dashboard() {

        require_once VISUALSEARCH__PLUGIN_DIR . "templates/admin/vs-dashboard.php";
    }

}

new VsVisualSearch();
?>