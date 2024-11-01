<?php

/* ------------------------------------------------------------------------------
 * * File:        class-vs-enqueue-script.php
 * * Class:       VsEnqueueScript
 * * Description: Class VsEnqueueScript handles the all css and js file for Visual Search Plugin. 
 * * Version:     1.0.0
 * *
 * *
 * * Methods:
 * *             vs_admin_CSS()
 * *             vs_admin_scripts()
 * *             vs_front_style_CSS()
 * *             vs_front_scripts_JS()
 * *     
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

class VsEnqueueScript {

    public function __construct() {
        $this->version = time();
        add_action('admin_enqueue_scripts', array($this, 'vs_admin_CSS'));
        add_action('admin_enqueue_scripts', array($this, 'vs_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'vs_front_style_CSS'));
        add_action('wp_enqueue_scripts', array($this, 'vs_front_scripts_JS'), '999');
    }

    //Add admin part custom CSS
    public function vs_admin_CSS() {
        // Register the script like this for a plugin:
        wp_register_style('bootstrap-css', VISUALSEARCH__ASSETS_DIR . 'bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-css');


        wp_enqueue_style('font-awesome-css', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


        wp_register_style('vs-custom-css', VISUALSEARCH__ASSETS_ADMIN_DIR . "/css/vs-admin-style.css", null, $this->version);
        // For either a plugin or a theme, you can then enqueue the script:
        wp_enqueue_style('vs-custom-css');
    }

    //Add admin part custom script
    public function vs_admin_scripts() {

        wp_enqueue_script('jquery');

        wp_enqueue_script('bootstrap-script', VISUALSEARCH__ASSETS_DIR . 'bootstrap/js/bootstrap.min.js');

        wp_enqueue_script('vs-custom-js', VISUALSEARCH__ASSETS_ADMIN_DIR . '/js/vs-admin.js', array('jquery'), $this->version, true);
    }

    public function vs_front_style_CSS() {
        wp_enqueue_style('bootstrap4', VISUALSEARCH__ASSETS_DIR . "bootstrap/css/bootstrap.min.css", array(), 'v4.1.3', 'all');
        wp_enqueue_style('custom-css', VISUALSEARCH__ASSETS_PUBLIC_DIR . "/css/vs-front-style.css", null, $this->version);
    }

    public function vs_front_scripts_JS() {


        wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap4-js', VISUALSEARCH__ASSETS_DIR . 'bootstrap/js/bootstrap.min.js', array('jquery'), '', true);
        wp_enqueue_script('vs-custom-js', VISUALSEARCH__ASSETS_PUBLIC_DIR . '/js/vs-custom.js', array('jquery'), $this->version, true);
    }

}

new VsEnqueueScript();
