<?php

/**

 * Plugin Name: Visual Product Search
 * Plugin URI: https://www.accelx.net/product.php
 * Description: Visual Product Search is a technique to use an image as a query rather than text and search for identical or visually similar images within a given product image collection or inventory. Accelx visual search module deploys sophisticated AI technology which can identify close to 94% accurate identical or similar product images. 

 * Version: 1.0.0
 * Author: Accelx
 * Author URI: http://accelx.net/
 * License: GPL2+
 * Text Domain: visual-search
 * Domain Path: /languages/

 */
if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly
}


define('VISUALSEARCH__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('VISUALSEARCH__PLUGIN_FILE', __FILE__);
define('VISUALSEARCH__PLUGIN_URL', plugin_dir_url(__FILE__));
define('VISUALSEARCH__PLUGIN_UPLOAD', wp_upload_dir()['basedir']);
define('VISUALSEARCH__PLUGIN_PYC_PRODUCT_TXT', plugin_dir_path(__FILE__) . "vspyscript/vsproduct.txt");
define('VISUALSEARCH__PLUGIN_PYC_MASTER_PKL', plugin_dir_path(__FILE__) . "vspyscript/N_master_imagelist.pkl");
define('VISUALSEARCH__PLUGIN_MASTER_TV_PKL', plugin_dir_path(__FILE__) . "vspyscript/master_tv.pkl");
define('VISUALSEARCH__PLUGIN_PYC_TV_TREE', plugin_dir_path(__FILE__) . "vspyscript/master_tv_tree.ann");
define('VISUALSEARCH__PLUGIN_PYC_TEST_TV_PKL', plugin_dir_path(__FILE__) . "vspyscript/tmp_tv_dir/test_tv.pkl");
define('VISUALSEARCH__PLUGIN_PYC_PRODUCT_TXTn', plugin_dir_path(__FILE__) . "vspyscript/vsproduct");
define('VISUALSEARCH__PLUGIN_PYC_MASTER_PKLn', plugin_dir_path(__FILE__) . "vspyscript/N_master_imagelist");
define('VISUALSEARCH__PLUGIN_PYC_TV_TREEn', plugin_dir_path(__FILE__) . "vspyscript/master_tv_tree");
define('VISUALSEARCH__PLUGIN_PYC_TEST_TV_PKLn', plugin_dir_path(__FILE__) . "vspyscript/tmp_tv_dir/test_tv");
define('VISUALSEARCH__PLUGIN_ML_SERVER_URL', "http://api.accelx.net/mls");

//define('VISUALSEARCH__PLUGIN_ML_API_URL', "http://localhost:8080/");
define('VISUALSEARCH__PLUGIN_ML_API_URL', "http://api.accelx.net/vsapptest/");

define('VISUALSEARCH__PLUGIN_ML_API_GET_TOKEN', VISUALSEARCH__PLUGIN_ML_API_URL . "get-token");

define('VISUALSEARCH__PLUGIN_ML_API_GET_SUBSCRIPTION', VISUALSEARCH__PLUGIN_ML_API_URL . "get-user-info");

//define('VISUALSEARCH__PLUGIN_ML_API_CREATE_TV', VISUALSEARCH__PLUGIN_ML_API_URL . "create-master-tv");
define('VISUALSEARCH__PLUGIN_ML_API_CREATE_TV_WP', VISUALSEARCH__PLUGIN_ML_API_URL . "create-master-tv-wp");
define('VISUALSEARCH__PLUGIN_ML_API_MASTER_TV_PROGRESS', VISUALSEARCH__PLUGIN_ML_API_URL . "product-process-count");
define('VISUALSEARCH__PLUGIN_ML_FN_REMOVE_CONFIG', VISUALSEARCH__PLUGIN_ML_API_URL . "remove-configuration");
define('VISUALSEARCH__PLUGIN_ML_FN_SEARCH_CLOSE_IMAGE', VISUALSEARCH__PLUGIN_ML_API_URL . "search-close-image");
define('VISUALSEARCH__PLUGIN_ML_FN_ADD_NEW_PRODUCT', VISUALSEARCH__PLUGIN_ML_API_URL . "add-new-product-images");
define('VISUALSEARCH__PLUGIN_ML_FN_REMOVE_PRODUCT', VISUALSEARCH__PLUGIN_ML_API_URL . "remove-product-images");


define('VISUALSEARCH__PLUGIN_PYC_RESIZE_DIR', plugin_dir_path(__FILE__)  . "setenv/");

define('VISUALSEARCH__PLUGIN_PICTURE_UP_DIR',plugin_dir_path(__FILE__). "searchpictureuploads/");
define('VISUALSEARCH__PLUGIN_PYTHON_FILE_TO_SERVER_URL', plugin_dir_path(__FILE__). "setenv/");
define("VISUALSEARCH__PLUGIN_ML_FN_CLOSE_IMAGE_SEARCH", "close_image_search"); //close_image_search
define("VISUALSEARCH__PLUGIN_ML_FN_NUM_RESULTS", "5"); //num_results
define("VISUALSEARCH__PLUGIN_ML_FN_N_COMPONENTS", "2048"); //nComponents
define("VISUALSEARCH__PLUGIN_ML_FN_GET_TOKEN", "get_token"); //get_token
define("VISUALSEARCH__PLUGIN_ML_FN_MASTER_PKL", "create_master_imagelistfile_from_productlistfile"); //create_master_imagelistfile_from_productlistfile
define("VISUALSEARCH__PLUGIN_ML_FN_MASTER_TV", "create_master_tvfile"); //create_master_tvfile
define("VISUALSEARCH__PLUGIN_ML_FN_MASTER_TREE_FROM_TV_DIR", "create_master_tree_from_tvdir"); //create_master_tree_from_tvdir
define("VISUALSEARCH__PLUGIN_ML_FN_ADD_PRODUCT", "add_product"); //add_product
define("VISUALSEARCH__PLUGIN_ML_FN_REMOVE_PRODUCT", "remove_product"); //remove_product
define("VISUALSEARCH__PLUGIN_ML_FN_GET_SUBSCRIPTION", "get_user_info"); //subscription_statistics_show
define("VISUALSEARCH__PLUGIN_ML_FN_GEO_LOCATION", "1"); //GEO Location
define("VISUALSEARCH__PLUGIN_ML_FN_NUM_THREAD", "1"); //Number of thread
define("VISUALSEARCH__PLUGIN_ML_FN_DISTANCE_THRESHOLD", ".69"); //distance threshold 
define("VISUALSEARCH__PLUGIN_ACTIVE_PRODUCT_COUNTER_CHECK", "false"); //true orginal product false edited product
define("VISUALSEARCH__PLUGIN_ACTIVE_PRODUCT_COUNTER", "10"); //product
define("VISUALSEARCH__PLUGIN_PRODUCT_PICTURE_BASE_FACTOR", "200"); //Product base factor
define("VISUALSEARCH__PLUGIN_FRONT_SHOWING_PRODUCT_NUMBER", "4"); //Front modal product showing number
define("VISUALSEARCH__PLUGIN_FRONT_SHOWING_PRODUCT_FROM", "latest"); //Front modal product showing from
define("VISUALSEARCH__ASSETS_DIR", plugin_dir_url(__FILE__) . "assets/");
define("VISUALSEARCH__ASSETS_ADMIN_DIR", plugin_dir_url(__FILE__) . "assets/admin");
define("VISUALSEARCH__ASSETS_PUBLIC_DIR", plugin_dir_url(__FILE__) . "assets/public");
define('VISUALSEARCH__VERSION', time());

// Include the main VisualSearchInstall class.

if (!class_exists('VisualSearchInstall')) {

    include_once VISUALSEARCH__PLUGIN_DIR . 'includes/class-visualsearchinstall.php';
}

require_once( VISUALSEARCH__PLUGIN_DIR . 'includes/class-vs-visualsearch.php');
require_once VISUALSEARCH__PLUGIN_DIR . 'includes/class-vs-enqueue-script.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-vs-options-setting.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-vs-visualsearch-front.php';



// Include vs-functions.php, use require_once to stop the script if vs-functions.php is not found

require_once VISUALSEARCH__PLUGIN_DIR . 'includes/vs-functions.php';


register_activation_hook(__FILE__, array('VisualSearchInstall', 'vs_pluginActivation'));
register_deactivation_hook(__FILE__, array('VisualSearchInstall', 'vs_pluginDeactivation'));

add_action('template_include', 'my_template_include');

function my_template_include($template) {

    $file = '';

    if (is_page(get_option('vs_search'))) {

        $file = VISUALSEARCH__PLUGIN_DIR . 'templates/public/page-vs_search' . '.php';
    }


    if (file_exists($file)) {

        $template = $file;
    }
    return $template;
}

add_action('init', 'create_initial_pages');

function create_initial_pages() {

    if (get_option('vs_visualsearch_page') == '') {

        create_page_if_null('vs_search');
    }
}

function create_page_if_null($target) {

    $page = get_page_by_title($target);

    if ($page == NULL) {

        //$id = $this->create_pages_fly($target);

        $id = create_pages_fly($target);
    } else {

        $id = $page->ID;
    }
    update_option('vs_visualsearch_page', $id);
}

function create_pages_fly($pageName) {

    $createPage = array(
        'post_title' => $pageName,
        'post_content' => 'Starter content',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'page',
        'post_name' => $pageName
    );

//post_status->published,draft
    //        "show_in_nav_menus"   => false
    // Insert the post into the database

    $id = wp_insert_post($createPage);

    return $id;
}

?>