<?php

/* ------------------------------------------------------------------------------
 * * File:        class-visualsearchinstall.php
 * * Class:       VisualSearchInstall
 * * Description: Class VisualSearchInstall handles the install and deactivation related operation for Visual Search Plugin. 
 * * Version:     1.0.0
 * *
 * *
 * * Methods:
 * *             vs_pluginActivation()
 * *             vsCompanyInfoAdd()
 * *             vsCompanyInfoDataInsertOption()
 * *             vsCompanyPlanInfoAdd()
 * *             vsStatisticsInfoAdd()
 * *             vsProductInfoAdd()
 * *             vs_pluginDeactivation()
 * *             vsPluginDropAllTables()
 * *             vsPluginRemoveProductTxtFile()()
 * *             vsPluginRemovePostAndPage()
 * *             vsPluginDropAllOption()
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

class VisualSearchInstall {

    public static function vs_pluginActivation() {
        // do not generate any output here
        VisualSearchInstall::vsCompanyInfoAdd();
        VisualSearchInstall::vsCompanyInfoDataInsertOption();
        VisualSearchInstall::vsCompanyPlanInfoAdd();
        VisualSearchInstall::vsStatisticsInfoAdd();
        VisualSearchInstall::vsProductInfoAdd();
    }

    public static function vsCompanyInfoAdd() {
        global $wpdb;

        $table_name = $wpdb->prefix . "vs_visualsearch_company";


        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		add_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		text text NOT NULL,
		company_logo varchar(100) DEFAULT '' NOT NULL,
		company_url varchar(100) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);

        
    }

    public static function vsCompanyInfoDataInsertOption() {
        global $wpdb;
        $welcome_name = 'Accelx';
        $welcome_text = 'Congratulations, you just completed the installation!';
        $company_url = 'https://accelx.net';
        $company_logo = 'accelx.png';

        $table_name = $wpdb->prefix . 'vs_visualsearch_company';

        $wpdb->insert(
                $table_name, array(
            'add_date' => current_time('mysql'),
            'name' => $welcome_name,
            'text' => $welcome_text,
            'company_url' => $company_url,
            'company_logo' => $company_logo
                )
        );
    }

    public static function vsCompanyPlanInfoAdd() {
        global $wpdb;

        $table_name = $wpdb->prefix . "vs_visualsearch_plan";


        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		plan_name tinytext NOT NULL,
		plan_type varchar(100) DEFAULT '' NOT NULL,
		act_key varchar(300) DEFAULT '' NOT NULL,
		text text NOT NULL,
		url varchar(55) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);


    }

    public static function vsStatisticsInfoAdd() {
        global $wpdb;

        $table_name = $wpdb->prefix . "vs_visualsearch_statistics";


        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		search_count varchar(100) DEFAULT '' NOT NULL,
		text text NOT NULL,
		ipaddress varchar(55) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);


    }

    public static function vsProductInfoAdd() {
        global $wpdb;

        $table_name = $wpdb->prefix . "vs_visualsearch_product";


        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		product_id INT(10) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);


    }

    public static function vs_pluginDeactivation() {

        VisualSearchInstall::vsPluginDropAllTables();
        VisualSearchInstall::vsPluginRemovePostAndPage();
        VisualSearchInstall::vsPluginRemoveProductTxtFile();
        VisualSearchInstall::vsPluginDropAllOption();
    }

    public static function vsPluginDropAllTables() {
        global $wpdb;


        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}vs_visualsearch_company");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}vs_visualsearch_plan");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}vs_visualsearch_statistics");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}vs_visualsearch_product");
    }

    public static function vsPluginRemoveProductTxtFile() {

        $vsFolderDirX = VISUALSEARCH__PLUGIN_DIR . '/vspyscript/';

        


        $vsFileName = VISUALSEARCH__PLUGIN_PYC_PRODUCT_TXT;
        $vsFileNameMasterPKL = VISUALSEARCH__PLUGIN_PYC_MASTER_PKL;
        $vsFileNameMasterTree = VISUALSEARCH__PLUGIN_PYC_TV_TREE;
        $vsFileNameTestPKL = VISUALSEARCH__PLUGIN_PYC_TEST_TV_PKL;



        wp_delete_file($vsFileName);
        wp_delete_file($vsFileNameMasterPKL);
        wp_delete_file($vsFileNameMasterTree);
        wp_delete_file($vsFileNameTestPKL);

        //remove txt ann and pkl files


        $vs_visualsearch_FileCounterValn = get_option('vs_visualsearch_productTxtFileCounter');
        for ($m = 1; $m <= $vs_visualsearch_FileCounterValn; $m++) {


            $vsProductFile = VISUALSEARCH__PLUGIN_PYC_PRODUCT_TXTn . '_' . $m . '.txt';
            $master_imagelist_file = VISUALSEARCH__PLUGIN_PYC_MASTER_PKLn . '_' . $m . '.pkl';
            $master_tv_tree_file = VISUALSEARCH__PLUGIN_PYC_TV_TREEn . '_' . $m . '.ann';
            $test_tv_pkl = VISUALSEARCH__PLUGIN_PYC_TEST_TV_PKLn . '_' . $m . '.pkl';




            if (file_exists($vsProductFile)) {
                wp_delete_file($vsProductFile);
            }
            if (file_exists($master_imagelist_file)) {
                wp_delete_file($master_imagelist_file);
            }
            if (file_exists($master_tv_tree_file)) {
                wp_delete_file($master_tv_tree_file);
            }

            if (file_exists($test_tv_pkl)) {
                wp_delete_file($test_tv_pkl);
            }
        }
    }

    public static function vsPluginRemovePostAndPage() {

        
        $vs_search_page_id = get_option('vs_visualsearch_page');
        wp_delete_post($vs_search_page_id, true);
    }

    public static function vsPluginDropAllOption() {
        global $wpdb;
       

        $plugin_options = $wpdb->get_results("SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'vs_%'");

        foreach ($plugin_options as $option) {
            delete_option($option->option_name);
        }

        $plugin_optionsX = $wpdb->get_results("SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'visualsearch_%'");

        foreach ($plugin_optionsX as $optionX) {
            delete_option($optionX->option_name);
        }
    }

}

?>