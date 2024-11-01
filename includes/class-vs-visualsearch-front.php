<?php

/* ------------------------------------------------------------------------------
 * * File:        class-vs-visualsearch-front.php
 * * Class:       VsVisualSearchFront
 * * Description: Class VsVisualSearchFront handles the front search related operation for Visual Search Plugin. 
 * * Version:     1.0.0
 * *
 * *
 * * Methods:
 * *             vs_visualSearch_AccelxTokenGeneration()
 * *             vs_visualsearch_front_icon_show()
 * *             vs_custom_my_search_form_btn()
 * *             vs_visualsearch_front_upload_picture_form_save()
 * *             vs_visualsearch_front_picture_url_form_save()
 * *             vs_visualsearch_front_apply_search_form_save()
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

class VsVisualSearchFront {

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


        /**
         * Register the action with WordPress.
         */
        add_action('vs_visualsearch_front_icon', array($this, 'vs_visualsearch_front_icon_show'));

        add_filter('get_product_search_form', array($this, 'vs_custom_my_search_form_btn'), 10, 2);
        add_action('wp_footer', array($this, 'vs_front_upload_modal_container_show'));

        add_action('admin_post_vs_visualsearch_front_upload_picture_form', array($this, 'vs_visualsearch_front_upload_picture_form_save'));
        add_action('admin_post_nopriv_vs_visualsearch_front_upload_picture_form', array($this, 'vs_visualsearch_front_upload_picture_form_save'));


        add_action('admin_post_vs_visualsearch_front_picture_url_form', array($this, 'vs_visualsearch_front_picture_url_form_save'));
        add_action('admin_post_nopriv_vs_visualsearch_front_picture_url_form', array($this, 'vs_visualsearch_front_picture_url_form_save'));

        add_action('admin_post_vs_visualsearch_front_apply_search_form', array($this, 'vs_visualsearch_front_apply_search_form_save'));
        add_action('admin_post_nopriv_vs_visualsearch_front_apply_search_form', array($this, 'vs_visualsearch_front_apply_search_form_save'));




        add_filter('query_vars', array($this, 'add_query_vars_filter'));
    }

    function add_query_vars_filter($vars) {

        $vars[] = "vs_orginalPicName";
        $vars[] = "vs_imageAddress";
        $vars[] = "vs_query";
        return $vars;
    }

    /**
     * Collect accelx user and password from database
     * Then generate Accelx Token for validation
     * 
     * @access public
     * @param string accelx user name
     * @param string accelx user pass
     * @return array
     *
     */
    public static function vs_visualSearch_AccelxTokenGeneration() {



       
       
        $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_GET_TOKEN;
        $ml_server_url_port = VISUALSEARCH__PLUGIN_ML_SERVER_URL;

        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $server_geo_location = VISUALSEARCH__PLUGIN_ML_FN_GEO_LOCATION;

        $vsTokenResponse = '';
        $vsStatus = 0;

        if ($vs_accelx_user != '' && $vs_accelx_pass != '') {




            //for Linux
            //   $cmdX = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $vs_accelx_user . "' '" . $vs_accelx_pass . "' '" . $ml_server_url_port . "' '" . $server_geo_location . "'";
            //for windows
            $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " " . $vs_accelx_user . " " . $vs_accelx_pass . " " . $ml_server_url_port . " " . $server_geo_location;

            $myCmdXOut = shell_exec("$cmdX 2>&1");

            $vsTokenData = json_decode($myCmdXOut);



            if (is_object($vsTokenData)) {
                $vsSuccessStatus = strtolower($vsTokenData->success);
                $vsTokenData = $vsTokenData->token;

                if ($vsSuccessStatus) {

                    if (is_array($vsTokenData)) {
                        $vsTokenResponse = $vsTokenData[0];

                        if (get_option('vs_visualsearch_api_key')) {

                            update_option('vs_visualsearch_api_key', $vsTokenResponse);
                            $vsStatus = 1;
                        } else {
                            add_option('vs_visualsearch_api_key', $vsTokenResponse);
                            $vsStatus = 1;
                        }
                    } else {

                        $vsStatus = 0;
                    }
                } else {

                    $vsStatus = 0;
                }
            } else {

                $vsStatus = 0;
            }
        }



        //  Start yesterday file deletion   

        $vs_dir = VISUALSEARCH__PLUGIN_PICTURE_UP_DIR;

// Open a known directory, and proceed to read its contents
        if (is_dir($vs_dir)) {
            if ($vs_dh = opendir($vs_dir)) {
                while (($vs_FileName = readdir($vs_dh)) !== false) {

                    if (preg_match('/(\.jpg|\.JPG|\.jpeg|\.JPEG|\.png|\.PNG)$/i', $vs_FileName)) {

                        $vs_FileExplode = explode("_", $vs_FileName);
                        $vs_ImgUploadDate = $vs_FileExplode[0];

                        $tahajjatToday = date('Ymd');
                        $tahajjatBeforeToday = date('Ymd', strtotime("-1 days"));

                        if ($tahajjatBeforeToday == $vs_ImgUploadDate) {
                            $vs_UploadFileLink = VISUALSEARCH__PLUGIN_PICTURE_UP_DIR . $vs_FileName;
                            wp_delete_file($vs_UploadFileLink);
                        }
                    }
                }
                closedir($vs_dh);
            }
        }

// End yesterday file deletion   

        $response = array(
            'token' => $vsTokenResponse,
            'status' => $vsStatus,
        );

        //  return $vsTokenResponse;

        return $response;
    }

    /**
     * User for show front Visual Search icon by  
     * this vs_visualsearch_front_icon action hook
     * 
     * 
     * @access public
     * @return string
     *
     */
    function vs_visualsearch_front_icon_show() {

        $vsBtn1 = '';

        $vs_visualSearch_Configuration_SetVal = get_option('vs_visualSearch_Configuration_Start');
        if ($vs_visualSearch_Configuration_SetVal == 1) {

            $vsBtn1 = '<a onclick="vsVisualSearchByImageOption()" title="Search by image" style="cursor: pointer;"><span id="qbi" class="gsst_e search_by_image"></span></a>';
        }
        echo $vsBtn1;
    }

    /**
     * When visual search backend integration complete  
     * this method show Front Visual Search Icon
     * 
     * 
     * @access public
     * @return string
     *
     */
    function vs_custom_my_search_form_btn($form) {


        $vsBtn = '';

        $vs_visualSearch_Configuration_SetVal = get_option('vs_visualSearch_Configuration_Start');
        if ($vs_visualSearch_Configuration_SetVal == 1) {
            $vsBtn = '<button type="button" class="btn btn-primary" onclick="vsShowFormModal()">Visual Search</button>';
            $vsBtn1 = '<a onclick="vsVisualSearchByImageOption()" title="Search by image" style="cursor: pointer;"><span id="qbi" class="gsst_e search_by_image"></span></a>';
        }

        $vsBtn = '';
        //$vsBtn1 = '';
        $form = $vsBtn . $vsBtn1 . $form;


        return $form;
    }

    function vs_front_upload_modal_container_show() {
        require_once VISUALSEARCH__PLUGIN_DIR . "templates/public/vs-front-upload-form.php";
    }

    /**
     * Prepare search result when picture upload from front Visual Search Plugin.
     * 
     * 
     * @access public
     * @param string accelx token
     * @param string uploaded picture
     * @return array
     *
     */
    public function vs_visualsearch_front_upload_picture_form_save() {


        $url =VISUALSEARCH__PLUGIN_ML_FN_SEARCH_CLOSE_IMAGE;

        $homeDomain = get_option('vs_visualsearch_container');
        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $vs_auth_token = get_option('vs_visualsearch_api_key');

        check_admin_referer("vs_visualsearch_front_upload");

        //vs_visualsearch_upload_picture
        if (isset($_POST['vsImgUpbtn'])) {


            $img = sanitize_text_field($_POST['img']);

            $_SESSION['imgXn'] = $img;

            if (strpos($img, 'data:image/jpeg;base64,') === 0) {
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $ext = '.jpg';
            }
            if (strpos($img, 'data:image/png;base64,') === 0) {
                $img = str_replace('data:image/png;base64,', '', $img);
                $ext = '.png';
            }

            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = 'uploads/img' . date("YmdHis") . $ext;


            $rnbrZZZZ = mt_rand(1111111111, mt_getrandmax());



            $tahajjatToday = date('Ymd');
            $name = $tahajjatToday . '_' . $rnbrZZZZ . $ext;  //assign unique name to image



            $targetpath = VISUALSEARCH__PLUGIN_DIR . 'searchpictureuploads/' . $name;




            $target_dir = wp_upload_dir(); // normal format start



            $vs_productArray = array();






            if (file_put_contents($targetpath, $data)) {
                //   echo "<p>The image was saved as $targetpath.</p>";


                $imageAddressX = VISUALSEARCH__PLUGIN_URL . 'searchpictureuploads/' . $name;
                $imageAddress = urlencode($imageAddressX);
                $imglink = $imageAddressX;
                $vs_uploadImglink = $imglink;

                
               
                $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_CLOSE_IMAGE_SEARCH;
                $master_imagelist_file = VISUALSEARCH__PLUGIN_PYC_MASTER_PKL;
                $master_tv_tree_file = VISUALSEARCH__PLUGIN_PYC_TV_TREE;
                $master_tv = VISUALSEARCH__PLUGIN_MASTER_TV_PKL;
                $ml_server_url_port = VISUALSEARCH__PLUGIN_ML_SERVER_URL;

                $ml_auth_user = get_option('vs_visualsearch_accelx_user');
                $ml_auth_token = get_option('vs_visualsearch_api_key');

                if ($ml_auth_token != '') {

                    //   $ml_auth_token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjM0LCJpYXQiOjE1NDQ1MjUxMzAsImV4cCI6MTU0NDUzNTkzMH0.QxWTM1vwKF07OjE8rs1kSn8M1Uoz_Y_a4pcz3NztR1A';

                    $search_image_file = VISUALSEARCH__PLUGIN_PICTURE_UP_DIR . $name;
                    $num_results = VISUALSEARCH__PLUGIN_ML_FN_NUM_RESULTS;
                    $nComponents = VISUALSEARCH__PLUGIN_ML_FN_N_COMPONENTS;

                    $distanceThreshold = VISUALSEARCH__PLUGIN_ML_FN_DISTANCE_THRESHOLD;
                    $geoLocation = VISUALSEARCH__PLUGIN_ML_FN_GEO_LOCATION;

                    //  $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True";
                    //    $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True  " . $ml_auth_user . " " . "'|'";
                    $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $master_tv . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " 'uploaded'  '" . $ml_auth_user . "' '|'";



                    //$command_output = shell_exec("$cmdX 2>&1");


                  //  $vsCommandData = json_decode(trim($command_output));

                        $response = wp_remote_post($url, array(
                            'method' => 'POST',
                            'timeout' => 45,
                            'redirection' => 5,
                            'httpversion' => '1.0',
                            'blocking' => true,
                            'headers' => array(
                                'gatewaykey' => $vs_accelx_user
                            ),
                            'body' => array(
                                'email' => $vs_accelx_user,
                                'password' => $vs_accelx_pass,
                                'domain' => $homeDomain,
                                'gatewaykey' => $vs_accelx_user,
                                'token' => $vs_auth_token,
                                'imageUrl' => $imglink 
                            ),
                            'cookies' => array()
                                )
                        );

                        $vsCommandData = json_decode($response['body']);
                        VsOptionSetting::vs_visualSearchErrorlog($imglink); 
                        VsOptionSetting::vs_visualSearchErrorlog($response['body']);

                    if (is_object($vsCommandData)) {
                        $vsSuccessStatus = strtolower($vsCommandData->status);

                        if ($vsSuccessStatus == 'true' || $vsSuccessStatus == '1') {
                            $closeProductsData = $vsCommandData->mls_response->closeproducts;

                            if ($closeProductsData != '["NoMatch"]') {

                                $vs_responseCode = 1;
                                $vs_responseMessage = "Matching product found";

                                $firstStringRm = substr(trim($closeProductsData), 1); //[
                                $lastStringRm = substr($firstStringRm, 0, -1); //]
                                $expX = explode('], ', $lastStringRm);

                                //product ID index
                                $searchResultProductIndexXn = $expX[0];
                                //product ID 
                                $searchResultProductIndex = $expX[2];

                                $firstStringSearchResultProductIndexRm = substr(trim($searchResultProductIndex), 1); //[
                                $lastStringSearchResultProductIndexRm = substr($firstStringSearchResultProductIndexRm, 0, -1); //]

                                $searchResultProductIndexX = explode(', ', $lastStringSearchResultProductIndexRm);

                                foreach ($searchResultProductIndexX as $srX) {

                                    $srX1 = substr(trim($srX), 1); //"
                                    $srX11 = substr($srX1, 0, -1); //"
                                    $vs_productArray[] = $srX11;
                                }


                                $searchQuery = base64_encode(json_encode($vs_productArray));

                                $fileUrl = 'vs_search/?orginalPicName=' . $name . '&imageAddress=' . $imageAddress . '&icropObj=N&searchPictureQuery=' . $searchQuery;
                            } else {
                                $vs_responseCode = 2;
                                //  $vs_responseMessage = "ERROR: Matching Record NOT FOUND";
                                $vs_responseMessage = "Product not found";
                                $vs_productArray = "";
                            }
                        } else {
                            //false
                            $reGenToken = VsVisualSearchFront ::vs_visualSearch_AccelxTokenGeneration();

                            if ($reGenToken != '') {
                                $reGenTokenStatus = $reGenToken['status'];
                                if ($reGenTokenStatus == 1) {

                                    $reGenerateToeknXn = $reGenToken['token'];
                                    $ml_auth_user = get_option('vs_visualsearch_accelx_user');
                                    //  $ml_auth_token = get_option('vs_visualsearch_api_key');
                                    $ml_auth_token = $reGenerateToeknXn;

                                    //  $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " .$distanceThreshold . " " .$geoLocation . " " . $nComponents;
                                    // $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $reGenerateToeknXn . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True";
                                    //  $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $reGenerateToeknXn . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True  " . $ml_auth_user . " " . "'|'";
                                    $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $master_tv . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " 'uploaded'  '" . $ml_auth_user . "' '|'";

                                    //$command_outputXn = shell_exec("$cmdXXn 2>&1");

                                    $response = wp_remote_post($url, array(
                                        'method' => 'POST',
                                        'timeout' => 45,
                                        'redirection' => 5,
                                        'httpversion' => '1.0',
                                        'blocking' => true,
                                        'headers' => array(
                                            'gatewaykey' => $vs_accelx_user
                                        ),
                                        'body' => array(
                                            'email' => $vs_accelx_user,
                                            'password' => $vs_accelx_pass,
                                            'domain' => $homeDomain,
                                            'gatewaykey' => $vs_accelx_user,
                                            'token' => $vs_auth_token,
                                            'imageUrl' => $imglink 
                                        ),
                                        'cookies' => array()
                                            )
                                    );
            
                                    $vsCommandDataXn = json_decode($response['body']);

                                   
                                    if (is_object($vsCommandDataXn)) {

                                        $closeProductsDataXn = $vsCommandDataXn->mls_response->closeproducts;

                                        if ($closeProductsDataXn != '["NoMatch"]') {

                                            $vs_responseCode = 1;
                                            $vs_responseMessage = "Matching product found";

                                            $firstStringRmXn = substr(trim($closeProductsDataXn), 1); //[
                                            $lastStringRmXn = substr($firstStringRmXn, 0, -1); //]
                                            $expX = explode('], ', $lastStringRmXn);

                                            //product ID index
                                            $searchResultProductIndexXn = $expX[0];
                                            //product ID 
                                            $searchResultProductIndex = $expX[2];

                                            $firstStringSearchResultProductIndexRm = substr(trim($searchResultProductIndex), 1); //[
                                            $lastStringSearchResultProductIndexRm = substr($firstStringSearchResultProductIndexRm, 0, -1); //]

                                            $searchResultProductIndexX = explode(', ', $lastStringSearchResultProductIndexRm);

                                            foreach ($searchResultProductIndexX as $srX) {

                                                $srX1 = substr(trim($srX), 1); //"
                                                $srX11 = substr($srX1, 0, -1); //"
                                                $vs_productArray[] = $srX11;
                                            }

                                            $searchQuery = base64_encode(json_encode($vs_productArray));

                                            $fileUrl = 'vs_search/?orginalPicName=' . $name . '&imageAddress=' . $imageAddress . '&icropObj=N&searchPictureQuery=' . $searchQuery;
                                        } else {
                                            $vs_responseCode = 2;
                                            //  $vs_responseMessage = "ERROR: Matching Record NOT FOUND";
                                            $vs_responseMessage = "Product not found";
                                            $vs_productArray = "";
                                        }
                                    }
                                } //end ::token not null
                                else {
                                    $vs_responseCode = 2;
                                    //  ERROR: Token generation fail from token regeneration ;
                                    $vs_responseMessage = "Product not found";
                                    $vs_productArray = "";
                                }
                            } else {
                                $vs_responseCode = 2;
                                //    ERROR: Token generation problem ;
                                $vs_responseMessage = "Product not found";
                                $vs_productArray = "";
                            }
                        }//end false
                    } else {
                        $vs_responseCode = 2;
                        //  ERROR: Response not in object;
                        $vs_responseMessage = "Product not found";
                        $vs_productArray = "";
                    }
                } else {
                    $vs_responseCode = 2;
                    // ERROR: API token not found;
                    $vs_responseMessage = "Product not found";
                    $vs_productArray = "";
                }


                //   wp_redirect($fileUrl);
            } else {
                // Sorry, there was an error uploading your file;
                $vs_uploadImglink = '';
                $vs_responseCode = 0;
                $vs_responseMessage = "Sorry, there was an error uploading your file.";
            }
        }
        //  $vs_responseMessage = $vs_responseMessage . "::" . $command_output . "::" . $cmdX . "::::ssQQ" . $searchQuery . "::dd status::" . $vsSuccessStatus . ":: New::" . $command_outputXn . " ::::" . $cmdXXn;
        //   $vs_responseMessage = $vs_responseMessage . "::" . $command_output . "::" . $cmdX . "::::ssQQ" . $searchQuery . "::dd status::" . $vsSuccessStatus . ":: New::" . $command_outputXn . " ::::" . $cmdXXn;
        $vs_productArray1 = array(
            'vs_uploadImglink' => $vs_uploadImglink,
            'vs_responseCode' => $vs_responseCode,
            'vs_responseMessage' => $vs_responseMessage,
            'vs_responseData' => $vs_productArray
        );



        $vs_visualsearchQuery = base64_encode(json_encode($vs_productArray1));


        $vs_searchPageId = get_option('vs_visualsearch_page');
        $vs_searchPageParmaLink = get_page_link($vs_searchPageId);



        $queryTH = add_query_arg(array(
            'vs_orginalPicName' => $name,
            'vs_imageAddress' => $imageAddress,
            'vs_query' => $vs_visualsearchQuery
                ), $vs_searchPageParmaLink);



        wp_redirect($queryTH);

        die;
    }

    /**
     * Prepare search result when picture collect from URL front Visual Search Plugin.
     * 
     * 
     * @access public
     * @param string accelx token
     * @param string picture Url
     * @return array
     *
     */
    public function vs_visualsearch_front_picture_url_form_save() {

        check_admin_referer("vs_visualsearch_front_picture_url");

        //vs_visualsearch_upload_picture


        if (isset($_POST['vsUrlUpBtn'])) {


            $vsProdImgZZZ = sanitize_text_field($_POST['vs_visualsearch_upload_url']);



            $info = getimagesize($vsProdImgZZZ);
            $extension = image_type_to_extension($info[2]);
            $url = VISUALSEARCH__PLUGIN_ML_FN_SEARCH_CLOSE_IMAGE;
            $homeDomain = get_option('vs_visualsearch_container');
            $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
            $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
            $vs_auth_token = get_option('vs_visualsearch_api_key');
    
            if (($extension == '.jpeg') OR ( $extension == '.png')) {

                $imageAddressX = $vsProdImgZZZ;
                $imageAddress = urlencode($imageAddressX);
                $imglink = $imageAddressX;
                $vs_uploadImglink = $imglink;

               
               
                $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_CLOSE_IMAGE_SEARCH;
                $master_imagelist_file = VISUALSEARCH__PLUGIN_PYC_MASTER_PKL;
                $master_tv_tree_file = VISUALSEARCH__PLUGIN_PYC_TV_TREE;
                $master_tv = VISUALSEARCH__PLUGIN_MASTER_TV_PKL;
                $ml_server_url_port = VISUALSEARCH__PLUGIN_ML_SERVER_URL;

                $ml_auth_user = get_option('vs_visualsearch_accelx_user');
                $ml_auth_token = get_option('vs_visualsearch_api_key');


                if ($ml_auth_token != '') {


                    $search_image_file = $vsProdImgZZZ;
                    $num_results = VISUALSEARCH__PLUGIN_ML_FN_NUM_RESULTS;
                    $nComponents = VISUALSEARCH__PLUGIN_ML_FN_N_COMPONENTS;

                    $distanceThreshold = VISUALSEARCH__PLUGIN_ML_FN_DISTANCE_THRESHOLD;
                    $geoLocation = VISUALSEARCH__PLUGIN_ML_FN_GEO_LOCATION;

                    //  $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " False";
                    //  $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " False  " . $ml_auth_user . " " . "'|'";
                    $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $master_tv . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " 'download'  " . $ml_auth_user . " " . "'|'";



                   // $command_output = shell_exec("$cmdX 2>&1");


                    //$vsCommandData = json_decode(trim($command_output));
                    $response = wp_remote_post($url, array(
                        'method' => 'POST',
                        'timeout' => 45,
                        'redirection' => 5,
                        'httpversion' => '1.0',
                        'blocking' => true,
                        'headers' => array(
                            'gatewaykey' => $vs_accelx_user
                        ),
                        'body' => array(
                            'email' => $vs_accelx_user,
                            'password' => $vs_accelx_pass,
                            'domain' => $homeDomain,
                            'gatewaykey' => $vs_accelx_user,
                            'token' => $vs_auth_token,
                            'imageUrl' =>$search_image_file
                        ),
                        'cookies' => array()
                            )
                    );
                    if (is_wp_error($response)) {
                        $error_message = $response->get_error_message();

                        $eloginfo = "Image Searching Issues ::  " . $error_message;
                        VsOptionSetting::vs_visualSearchErrorlog($eloginfo); 
                       

                       
                       
                        //VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

                        $vs_responseCode = '21';
                        $vs_responseMessage = 'WP Cound not process request or server not enable';
                    } else {

                        VsOptionSetting::vs_visualSearchErrorlog($url); 
                        
                        VsOptionSetting::vs_visualSearchErrorlog($search_image_file); 
                        VsOptionSetting::vs_visualSearchErrorlog($vs_auth_token);
                        VsOptionSetting::vs_visualSearchErrorlog($vs_accelx_user);
                        VsOptionSetting::vs_visualSearchErrorlog($vs_accelx_pass);
                        $vsCommandData = $response['body'];
                        VsOptionSetting::vs_visualSearchErrorlog($vsCommandData);
                        // $loginfo = "Image Conversion Start :: response  " . $vsCommandData;
                         VsOptionSetting::vs_visualSearchInstalllog($loginfo);
                         $vsCommandData = json_decode($vsCommandData);
                         
                    }
                   
                    if (is_object($vsCommandData)) {
                        $loginfo = "Image Conversion Start :: response Hello from Vs Commandata ".$vsCommandData->mls_response->closeproducts;
                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);
                        $vsSuccessStatus = strtolower($vsCommandData->status);
                        VsOptionSetting::vs_visualSearchInstalllog( $vsSuccessStatus );
                        //VsOptionSetting::vs_visualSearchInstalllog($vsCommandData->mls_response->closeproducts);
                        if ($vsSuccessStatus == "1") {
                            $closeProductsData = $vsCommandData->mls_response->closeproducts;

                            

                            if ($closeProductsData != '["NoMatch"]') {

                                $vs_responseCode = 1;
                                $vs_responseMessage = "Matching product found";


                                $firstStringRm = substr(trim($closeProductsData), 1); //[
                                $lastStringRm = substr($firstStringRm, 0, -1); //]
                                $expX = explode('], ', $lastStringRm);

                                //product ID index
                                $searchResultProductIndexXn = $expX[0];
                                //product ID 
                                $searchResultProductIndex = $expX[2];

                                $firstStringSearchResultProductIndexRm = substr(trim($searchResultProductIndex), 1); //[
                                $lastStringSearchResultProductIndexRm = substr($firstStringSearchResultProductIndexRm, 0, -1); //]

                                $searchResultProductIndexX = explode(', ', $lastStringSearchResultProductIndexRm);

                                foreach ($searchResultProductIndexX as $srX) {

                                    $srX1 = substr(trim($srX), 1); //"
                                    $srX11 = substr($srX1, 0, -1); //"
                                    $vs_productArray[] = $srX11;
                                }


                                $searchQuery = base64_encode(json_encode( $vsCommandData->product_list));

                                $fileUrl = 'vs_search/?orginalPicName=' . $name . '&imageAddress=' . $imageAddress . '&icropObj=N&searchPictureQuery=' . $searchQuery;
                            } else {
                                $vs_responseCode = 2;
                                //  $vs_responseMessage = "ERROR: Matching Record NOT FOUND";
                                $vs_responseMessage = "Product not found";
                                $vs_productArray = "";
                            }
                        } else {


                            $reGenToken = VsVisualSearchFront ::vs_visualSearch_AccelxTokenGeneration();

                            if ($reGenToken != '') {
                                $reGenTokenStatus = $reGenToken['status'];

                                if ($reGenTokenStatus == 1) {

                                    $reGenerateToeknXn = $reGenToken['token'];
                                    $ml_auth_user = get_option('vs_visualsearch_accelx_user');
                                    //  $ml_auth_token = get_option('vs_visualsearch_api_key');
                                    $ml_auth_token = $reGenerateToeknXn;

                                    //  $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " .$distanceThreshold . " " .$geoLocation . " " . $nComponents;
                                    // $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $reGenerateToeknXn . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " False";
                                    // $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $reGenerateToeknXn . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " False  " . $ml_auth_user . " " . "'|'";
                                    $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $master_tv . "' '" . $ml_server_url_port . "' '" . $reGenerateToeknXn . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " 'download'  " . $ml_auth_user . " " . "'|'";

                                    //   $my_commandXn = escapeshellcmd($cmdXXn);
                                    //   $command_outputXn = shell_exec($my_commandXn);

                                  //  $command_outputXn = shell_exec("$cmdXXn 2>&1");


                                    $response = wp_remote_post($url, array(
                                        'method' => 'POST',
                                        'timeout' => 45,
                                        'redirection' => 5,
                                        'httpversion' => '1.0',
                                        'blocking' => true,
                                        'headers' => array(
                                            'gatewaykey' => $vs_accelx_user
                                        ),
                                        'body' => array(
                                            'email' => $vs_accelx_user,
                                            'password' => $vs_accelx_pass,
                                            'domain' => $homeDomain,
                                            'gatewaykey' => $vs_accelx_user,
                                            'token' => $vs_auth_token,
                                            'imageUrl' =>$search_image_file
                                        ),
                                        'cookies' => array()
                                            )
                                    );
                
                                    if (is_wp_error($response)) {
                                        $error_message = $response->get_error_message();
                
                                        $eloginfo = "Image Searching Issues ::  " . $error_message;
                                        VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                                        //VsOptionSetting::vs_visualSearchInstalllog($eloginfo);
                
                                    } else {
                
                                        $vsCommandDataXn = json_decode($response['body']);
                
                                        $loginfo = "Image Conversion Start :: response  " . $vsCommandDataXn;
                                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);
                                    }
                                   

                                   // $vsCommandDataXn = json_decode(trim($command_outputXn));
                                    if (is_object($vsCommandDataXn)) {

                                        $closeProductsData = $vsCommandDataXn->mls_response->closeproducts;

                                        if ($closeProductsData != '["NoMatch"]') {

                                            $vs_responseCode = 1;
                                            $vs_responseMessage = "Matching product found";

                                            $firstStringRm = substr(trim($closeProductsData), 1); //[
                                            $lastStringRm = substr($firstStringRm, 0, -1); //]
                                            $expX = explode('], ', $lastStringRm);

                                            //product ID index
                                            $searchResultProductIndexXn = $expX[0];
                                            //product ID 
                                            $searchResultProductIndex = $expX[2];

                                            $firstStringSearchResultProductIndexRm = substr(trim($searchResultProductIndex), 1); //[
                                            $lastStringSearchResultProductIndexRm = substr($firstStringSearchResultProductIndexRm, 0, -1); //]

                                            $searchResultProductIndexX = explode(', ', $lastStringSearchResultProductIndexRm);

                                            foreach ($searchResultProductIndexX as $srX) {

                                                $srX1 = substr(trim($srX), 1); //"
                                                $srX11 = substr($srX1, 0, -1); //"
                                                $vs_productArray[] = $srX11;
                                            }


                                            $searchQuery = base64_encode(json_encode( $vs_productArray));

                                            $fileUrl = 'vs_search/?orginalPicName=' . $name . '&imageAddress=' . $imageAddress . '&icropObj=N&searchPictureQuery=' . $searchQuery;
                                        } else {
                                            $vs_responseCode = 2;
                                            //  $vs_responseMessage = "ERROR: Matching Record NOT FOUND";
                                            $vs_responseMessage = "Product not found";
                                            $vs_productArray = "";
                                        }
                                    }
                                } //end ::token staus 1
                                else {
                                    $vs_responseCode = 2;
                                    //    $vs_responseMessage = "ERROR: Token generation problem ";
                                    $vs_responseMessage = "Product not found";
                                    $vs_productArray = "";
                                }
                            } //end ::token not null
                            else {
                                $vs_responseCode = 2;
                                //    $vs_responseMessage = "ERROR: Token generation problem ";
                                $vs_responseMessage = "Product not found";
                                $vs_productArray = "";
                            }
                        }//end false
                    } else {
                        $vs_responseCode = 2;
                        //    $vs_responseMessage = "ERROR: Response not in object";
                        $vs_responseMessage = "Product not found";
                        $vs_productArray = "";
                    }
                } else {
                    $vs_responseCode = 2;
                    //   $vs_responseMessage = "ERROR: Token is null ";
                    $vs_responseMessage = "Product not found";
                    $vs_productArray = "";
                }
            } else {
                $vs_responseCode = 2;
                //   $vs_responseMessage = "ERROR: invalid image extention ";
                $vs_responseMessage = "Product not found";
                $vs_productArray = "";
            }
        }
        //  $vs_responseMessage = $vs_responseMessage . "::" . $command_output . "::" . $cmdX . "::::ssQQ" . $searchQuery . "::dd status::" . $vsSuccessStatus . ":: New::" . $command_outputXn . " ::::" . $cmdXXn;
        //   $vs_responseMessage = $vs_responseMessage . "::" . $command_output . "::" . $cmdX . "::::ssQQ" . $searchQuery . "::dd status::" . $vsSuccessStatus . ":: New::" . $command_outputXn . " ::::" . $cmdXXn;
        $vs_productArray1 = array(
            'vs_uploadImglink' => $vs_uploadImglink,
            'vs_responseCode' => $vs_responseCode,
            'vs_responseMessage' => $vs_responseMessage,
            'vs_responseData' => $vs_productArray
        );



        $vs_visualsearchQuery = base64_encode(json_encode($vs_productArray1));


        $vs_searchPageId = get_option('vs_visualsearch_page');
        $vs_searchPageParmaLink = get_page_link($vs_searchPageId);


        $queryTH = add_query_arg(array(
            'vs_orginalPicName' => $name,
            'vs_imageAddress' => $imageAddress,
            'vs_query' => $vs_visualsearchQuery
                ), $vs_searchPageParmaLink);



        wp_redirect($queryTH);

        die;
    }

    /**
     * Prepare search result when picture collect from own server front Visual Search Plugin.
     * 
     * 
     * @access public
     * @param string accelx token
     * @param string picture Url
     * @return array
     *
     */
    public function vs_visualsearch_front_apply_search_form_save() {



        check_admin_referer("vs_visualsearch_front_apply_search");

        //vs_visualsearch_upload_picture
        if (isset($_POST['vsImgUpbtn'])) {

          

            $url = VISUALSEARCH__PLUGIN_ML_FN_SEARCH_CLOSE_IMAGE;
            $homeDomain = get_option('vs_visualsearch_container');
            $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
            $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
            $vs_auth_token = get_option('vs_visualsearch_api_key');

            $vsproductID = sanitize_text_field($_POST["vs_visualsearch_picture_apply_search"]);

            $vsGetHomepath = get_home_path();


            $vspro = new WC_Product($vsproductID);


            $vsgetProductSku = $vspro->get_sku();
            $vsimage_id = $vspro->image_id;
            $vsproductAttachment = wc_get_product_attachment_props($vsimage_id);

            $vsfull_src = $vsproductAttachment['full_src'];

            $vsFullSrcExplode = explode("uploads/", $vsfull_src);
            $vsImgName1 = $vsFullSrcExplode[1];

            $vs_upload_dir = wp_upload_dir();
            $vs_upload_dir_Xn = $vs_upload_dir['basedir'];

            $vsrealRootDirPathOfImage = $vs_upload_dir_Xn . '/' . $vsImgName1;

            $targetpath = $vsrealRootDirPathOfImage;


            $vs_productArray = array();



            $imageAddressX = $vsfull_src;
            $imageAddress = urlencode($imageAddressX);
            $imglink = $imageAddressX;
            $vs_uploadImglink = $imglink;

           
            
            $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_CLOSE_IMAGE_SEARCH;
            $master_imagelist_file = VISUALSEARCH__PLUGIN_PYC_MASTER_PKL;
            $master_tv_tree_file = VISUALSEARCH__PLUGIN_PYC_TV_TREE;
            $master_tv = VISUALSEARCH__PLUGIN_MASTER_TV_PKL;
            $ml_server_url_port = VISUALSEARCH__PLUGIN_ML_SERVER_URL;

            $ml_auth_user = get_option('vs_visualsearch_accelx_user');
            $ml_auth_token = get_option('vs_visualsearch_api_key');

            if ($ml_auth_token != '') {

               // $search_image_file = get_bloginfo('wpurl'). '/wp-content' . $vsImgName1;
                $search_image_file =  $vsfull_src;
                $num_results = VISUALSEARCH__PLUGIN_ML_FN_NUM_RESULTS;
                $nComponents = VISUALSEARCH__PLUGIN_ML_FN_N_COMPONENTS;
                $distanceThreshold = VISUALSEARCH__PLUGIN_ML_FN_DISTANCE_THRESHOLD;
                $geoLocation = VISUALSEARCH__PLUGIN_ML_FN_GEO_LOCATION;

                //  $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True";               
                //  $cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True  " . $ml_auth_user . " " . "'|'";
                //$cmdX = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $master_tv . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " 'existing'  '" . $ml_auth_user . "' '|'";
                


                //  $my_command = escapeshellcmd($cmdX);
                //   $command_output = shell_exec($my_command);
                //$command_output = shell_exec("$cmdX  2>&1");

               // $vsCommandData = json_decode(trim($command_output));

               
               $response = wp_remote_post($url, array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(
                    'gatewaykey' => $vs_accelx_user
                ),
                'body' => array(
                    'email' => $vs_accelx_user,
                    'password' => $vs_accelx_pass,
                    'domain' => $homeDomain,
                    'gatewaykey' => $vs_accelx_user,
                    'token' => $vs_auth_token,
                    'imageUrl' =>$search_image_file
                ),
                'cookies' => array()
                    )
            );

            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();

                $eloginfo = "Image Searching Issues ::  " . $error_message;
                VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                VsOptionSetting::vs_visualSearchErrorlog($search_image_file);
                //VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

            } else {
                VsOptionSetting::vs_visualSearchErrorlog($search_image_file);
                $vsCommandData = json_decode($response['body']);

                $loginfo = "Image Search Existing Product List  " . $response['body'];
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);
            }
           

                if (is_object($vsCommandData)) {
                    $vsSuccessStatus = strtolower($vsCommandData->status);

                    if ($vsSuccessStatus == 'true' || $vsSuccessStatus == '1') {
                        $closeProductsData = $vsCommandData->mls_response->closeproducts;

                        if ($closeProductsData != '["NoMatch"]') {

                            $vs_responseCode = 1;
                            $vs_responseMessage = "Matching product found";

                            $firstStringRm = substr(trim($closeProductsData), 1); //[
                            $lastStringRm = substr($firstStringRm, 0, -1); //]
                            $expX = explode('], ', $lastStringRm);

                            //product ID index
                            $searchResultProductIndexXn = $expX[0];
                            //product ID 
                            $searchResultProductIndex = $expX[2];

                            $firstStringSearchResultProductIndexRm = substr(trim($searchResultProductIndex), 1); //[
                            $lastStringSearchResultProductIndexRm = substr($firstStringSearchResultProductIndexRm, 0, -1); //]

                            $searchResultProductIndexX = explode(', ', $lastStringSearchResultProductIndexRm);

                            foreach ($searchResultProductIndexX as $srX) {

                                $srX1 = substr(trim($srX), 1); //"
                                $srX11 = substr($srX1, 0, -1); //"
                                $vs_productArray[] = $srX11;
                            }



                            $searchQuery = base64_encode(json_encode( $vsCommandData->product_list));

                            $fileUrl = 'vs_search/?orginalPicName=' . $name . '&imageAddress=' . $imageAddress . '&icropObj=N&searchPictureQuery=' . $searchQuery;
                        } else {
                            $vs_responseCode = 2;
                            // $vs_responseMessage = "ERROR: Matching Record NOT FOUND";
                            $vs_responseMessage = "Product not found";
                            $vs_productArray = "";
                        }
                    } else {
                        //false
                        $reGenToken = VsVisualSearchFront ::vs_visualSearch_AccelxTokenGeneration();

                        if ($reGenToken != '') {
                            $reGenTokenStatus = $reGenToken['status'];

                            if ($reGenTokenStatus == 1) {

                                $reGenerateToeknXn = $reGenToken['token'];
                                $ml_auth_user = get_option('vs_visualsearch_accelx_user');
                                //  $ml_auth_token = get_option('vs_visualsearch_api_key');
                                $ml_auth_token = $reGenerateToeknXn;

                                //  $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $reGenerateToeknXn . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True";
                                //  $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $ml_server_url_port . "' '" . $ml_auth_token . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " True  " . $ml_auth_user . " " . "'|'";
                                $cmdXXn = $python . " " . $scriptPath . " " . $commandFuncion . " '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' '" . $master_tv . "' '" . $ml_server_url_port . "' '" . $reGenerateToeknXn . "' '" . $search_image_file . "' " . $num_results . " " . $distanceThreshold . " " . $geoLocation . " " . $nComponents . " 'existing'  '" . $ml_auth_user . "' '|'";

//                        $my_commandXn = escapeshellcmd($cmdXXn);
//                        $command_outputXn = shell_exec($my_commandXn);

                                //$command_outputXn = shell_exec("$cmdXXn  2>&1");
                                $response = wp_remote_post($url, array(
                                    'method' => 'POST',
                                    'timeout' => 45,
                                    'redirection' => 5,
                                    'httpversion' => '1.0',
                                    'blocking' => true,
                                    'headers' => array(
                                        'gatewaykey' => $vs_accelx_user
                                    ),
                                    'body' => array(
                                        'email' => $vs_accelx_user,
                                        'password' => $vs_accelx_pass,
                                        'domain' => $homeDomain,
                                        'gatewaykey' => $vs_accelx_user,
                                        'token' => $vs_auth_token,
                                        'imageUrl' =>$search_image_file
                                    ),
                                    'cookies' => array()
                                        )
                                );
                    
                                $vsCommandDataXn = json_decode($response['body']);

                                //$vsCommandDataXn = json_decode(trim($command_outputXn));
                                if (is_object($vsCommandDataXn)) {

                                    $closeProductsData = $vsCommandDataXn->mls_response->closeproducts;

                                    if ($closeProductsData != '["NoMatch"]') {

                                        $vs_responseCode = 1;
                                        $vs_responseMessage = "Matching product found";

                                        $firstStringRm = substr(trim($closeProductsData), 1); //[
                                        $lastStringRm = substr($firstStringRm, 0, -1); //]
                                        $expX = explode('], ', $lastStringRm);

                                        //product ID index
                                        $searchResultProductIndexXn = $expX[0];
                                        //product ID 
                                        $searchResultProductIndex = $expX[2];

                                        $firstStringSearchResultProductIndexRm = substr(trim($searchResultProductIndex), 1); //[
                                        $lastStringSearchResultProductIndexRm = substr($firstStringSearchResultProductIndexRm, 0, -1); //]

                                        $searchResultProductIndexX = explode(', ', $lastStringSearchResultProductIndexRm);

                                        foreach ($searchResultProductIndexX as $srX) {

                                            $srX1 = substr(trim($srX), 1); //"
                                            $srX11 = substr($srX1, 0, -1); //"
                                            $vs_productArray[] = $srX11;
                                        }


                                        $searchQuery = base64_encode(json_encode( $vsCommandDataXn->product_list));

                                        $fileUrl = 'vs_search/?orginalPicName=' . $name . '&imageAddress=' . $imageAddress . '&icropObj=N&searchPictureQuery=' . $searchQuery;
                                    } else {
                                        $vs_responseCode = 2;
                                        // $vs_responseMessage = "ERROR: Matching Record NOT FOUND";
                                        $vs_responseMessage = "Product not found";
                                        $vs_productArray = "";
                                    }
                                }
                            } //end ::token not null
                            else {
                                $vs_responseCode = 2;
                                //  $vs_responseMessage = "ERROR: Token generation problem ";
                                $vs_responseMessage = "Product not found";
                                $vs_productArray = "";
                            }
                        } //end ::token not null
                        else {
                            $vs_responseCode = 2;
                            //  $vs_responseMessage = "Token generation fail from token regeneration ";
                            $vs_responseMessage = "Product not found";
                            $vs_productArray = "";
                        }
                    }//end false
                } else {
                    $vs_responseCode = 2;
                    //   $vs_responseMessage = "ERROR: Response not in object";
                    $vs_responseMessage = "Product not found";
                    $vs_productArray = "";
                }
            } else {
                $vs_responseCode = 2;
                //  $vs_responseMessage = "ERROR: Token is null";
                $vs_responseMessage = "Product not found";
                $vs_productArray = "";
            }


            //   wp_redirect($fileUrl);
        }
        //  $vs_responseMessage = $vs_responseMessage . "::" . $command_output . "::" . $cmdX . "::::ssQQ" . $searchQuery . "::dd status::" . $vsSuccessStatus . ":: New::" . $command_outputXn . " ::::" . $cmdXXn;
        $vs_productArray1 = array(
            'vs_uploadImglink' => $vs_uploadImglink,
            'vs_responseCode' => $vs_responseCode,
            'vs_responseMessage' => $vs_responseMessage,
            'vs_responseData' => $vs_productArray
        );



        $vs_visualsearchQuery = base64_encode(json_encode($vs_productArray1));


        $vs_searchPageId = get_option('vs_visualsearch_page');
        $vs_searchPageParmaLink = get_page_link($vs_searchPageId);




        $queryTH = add_query_arg(array(
            'vs_orginalPicName' => $name,
            'vs_imageAddress' => $imageAddress,
            'vs_query' => $vs_visualsearchQuery
                ), $vs_searchPageParmaLink);



        wp_redirect($queryTH);

        die;
    }

}

new VsVisualSearchFront();
?>