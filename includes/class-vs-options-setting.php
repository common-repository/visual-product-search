<?php

/* ------------------------------------------------------------------------------
 * * File:        class-vs-options-setting.php
 * * Class:       VsOptionSetting
 * * Description: Class VsOptionSetting handles the setting related operation for Visual Search Plugin. 
 * * Version:     1.0.0
 * *
 * *
 * * Methods:
 * *             vs_visualSearchInstalllog()
 * *             vs_visualSearchErrorlog()
 * *             vs_visualSearch_AccelxTokenGenerationAdmin()
 * *             vs_visualsearch_subscription_statistics_show()
 * *             vs_visualSearchProductCollecton_form_save()
 * *             vs_visualSearchHandshakeML_form_save()
 * *             vs_visualSearchImageConversionStart_form_save()
 * *             vs_visualsearch_process_form_save()
 * *             vs_visualsearch_process_configuration_delete()
 * *             vs_create_admin_subMenu_page()
 * *             vs_option_setting_page_content()
 * *             vs_option_setting_page_contentTemplate()
 * *             vs_visualsearch_setting_number_of_thread_form_save()
 * *             vs_visualsearch_setting_setup_environment_form_save()
 * *             vs_visualsearch_setting_setup_environment_check_form_save()
 * *             vs_visualsearch_setting_accelx_credential_form_save()
 * *             vs_visualsearch_setting_configuration_javascript()
 * *             vs_visualSearchSettingsUploadPictureDelete()
 * *             vs_visualsearch_setting_front_suggested_product_form_save()
 * *             vs_visualsearch_new_product_add_form_save()
 * *             vs_visualsearch_install_log_form_save()
 * *             vs_visualsearch_setting_option_form_save()
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

class VsOptionSetting {

    public function __construct() {
        add_action('admin_menu', array($this, 'vs_create_admin_subMenu_page'));

        add_action('vs_visualsearch_subscription_statistics', array($this, 'vs_visualsearch_subscription_statistics_show'));

        add_action('admin_post_vs_visualsearch_setting_number_of_thread_form', array($this, 'vs_visualsearch_setting_number_of_thread_form_save'));

        add_action('admin_post_vs_visualsearch_setting_accelx_credential_form', array($this, 'vs_visualsearch_setting_accelx_credential_form_save'));



        //vs_visualSearchSettingsConfigurationCreatePKLFilePHP
        add_action('admin_post_vs_visualSearchSettingsCreatePKLFilePHP_form', array($this, 'vs_visualSearchSettingsCreatePKLFilePHP_form_save'));




        add_action('admin_footer', array($this, 'vs_visualsearch_setting_configuration_javascript')); // Write our JS below here


        add_action('wp_ajax_vs_visualSearchSettingsConfigurationSetupEnvironment', array($this, 'vs_visualSearchSettingsConfigurationSetupEnvironment'));
        add_action('wp_ajax_vs_visualSearchSettingsConfigurationCreateProductTxtFile', array($this, 'vs_visualSearchSettingsConfigurationCreateProductTxtFile'));
        add_action('wp_ajax_vs_visualSearchSettingsConfigurationCreateMasterImageListFile', array($this, 'vs_visualSearchSettingsConfigurationCreateMasterImageListFile'));
        add_action('wp_ajax_vs_visualSearchSettingsConfigurationCreatePKLFile', array($this, 'vs_visualSearchSettingsConfigurationCreatePKLFile'));
        add_action('wp_ajax_vs_visualSearchSettingsConfigurationRemove', array($this, 'vs_visualSearchSettingsConfigurationRemove'));

        add_action('admin_post_vs_visualsearch_setting_option_form', array($this, 'vs_visualsearch_setting_option_form_save'));

        add_action('wp_ajax_vs_visualSearchSettingsUploadPictureDelete', array($this, 'vs_visualSearchSettingsUploadPictureDelete'));

        add_action('wp_ajax_vs_visualsearchSettingsManageProductCheckNewProduct', array($this, 'vs_visualsearchSettingsManageProductCheckNewProduct'));


        //   vs_visualSearchImageCoversionStartByJS
        add_action('wp_ajax_vs_visualSearchImageCoversionStartByJS', array($this, 'vs_visualSearchImageCoversionStartByJS'));

        add_action('wp_ajax_vs_visualSearchImageProgressBarCheckByJS', array($this, 'vs_visualSearchImageProgressBarCheckByJS'));


        //vs_visualsearch_setting_front_suggested_product_form

        add_action('admin_post_vs_visualsearch_setting_front_suggested_product_form', array($this, 'vs_visualsearch_setting_front_suggested_product_form_save'));

        add_action('admin_post_vs_visualsearch_new_product_add_form', array($this, 'vs_visualsearch_new_product_add_form_save'));

        add_action('admin_post_vs_visualsearch_install_log_form', array($this, 'vs_visualsearch_install_log_form_save'));

        add_action('admin_post_vs_visualsearch_error_log_form', array($this, 'vs_visualsearch_error_log_form_save'));



        add_action('admin_post_vs_visualSearchProductCollecton_form', array($this, 'vs_visualSearchProductCollecton_form_save'));
        add_action('admin_post_vs_visualSearchHandshakeML_form', array($this, 'vs_visualSearchHandshakeML_form_save'));


        add_action('admin_post_vs_visualSearchImageConversionStart_form', array($this, 'vs_visualSearchImageConversionStart_form_save'));
        add_action('admin_post_vs_visualsearch_process_form', array($this, 'vs_visualsearch_process_form_save'));
        add_action('admin_post_vs_visualsearch_process_configuration_delete_form', array($this, 'vs_visualsearch_process_configuration_delete'));
    }

    /**
     * Insall Information Log
     *

     * @access public
     * @param string table name
     * @param array values to update insall log file which we want to put 
     * @param string data
     * @return bool
     * @example $loginfo = "Start :: API::getBloodMyDonationListInfo :: Content request from client  " . $id_client . " and company " . $companyID;
      VsOptionSetting::vs_visualSearchInstalllog($loginfo);
     */
    public static function vs_visualSearchInstalllog($logdata) {

       // $upload_dir   = wp_upload_dir();
       
        $logdirX = VISUALSEARCH__PLUGIN_UPLOAD . '/vspyscript/';
        wp_mkdir_p($logdirX);
        $fileName = $logdirX . 'installlog' . '.txt';
        $logdata1 = date("D d-M-Y h.i A e") . " - " . $logdata;
        if (file_exists($fileName)) {
            $myfile = file_put_contents($fileName, $logdata1 . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            $myfile = fopen($fileName, "w") or die("Unable to open file!");
            $logdata1X = $logdata1 . "\r\n";
            fwrite($myfile, $logdata1X);
        }
        return true;
    }

    /**
     * Error Information Log
     *

     * @access public
     * @param string table name
     * @param array values to update errorlog file which we want to put 
     * @param string data
     * @return bool
     * @example $loginfo = "Start :: API::getBloodMyDonationListInfo :: Content request from client  " . $id_client . " and company " . $companyID;
      VsOptionSetting::vs_visualSearchInstalllog($loginfo);
     */
    public static function vs_visualSearchErrorlog($logdata) {
        $logdirX = VISUALSEARCH__PLUGIN_UPLOAD . '/vspyscript/';
        wp_mkdir_p($logdirX);
        $fileName = $logdirX . 'errorlog' . '.txt';
        $logdata1 = date("D d-M-Y h.i A e") . " - " . $logdata;
        if (file_exists($fileName)) {
            file_put_contents($fileName, '');
            $myfile = file_put_contents($fileName, $logdata1 . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            $myfile = fopen($fileName, "w") or die("Unable to open file!");
            $logdata1X = $logdata1 . "\r\n";
            fwrite($myfile, $logdata1X);
        }
        return true;
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
    public static function vs_visualSearch_AccelxTokenGenerationAdmin() {

        $loginfo = "Start :: Token Generation From Admin :: ";
        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

        $url = VISUALSEARCH__PLUGIN_ML_API_GET_TOKEN;

        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');

        $homeDomain = get_option('vs_visualsearch_container');

        //start Token generation


        $loginfo = "Start :: Regeneate Token :: user  " . $vs_accelx_user . " and pass " . $vs_accelx_pass . " and homeDomain " . $homeDomain;
        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

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
                'gatewaykey' => $vs_accelx_user
            ),
            'cookies' => array()
                )
        );

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            $eloginfo = "Accelx Credential :: WP Cound not process request or server not enable ::  " . $error_message;
            VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
            VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

            $vs_responseCode = '21';
            $vs_responseMessage = 'WP Cound not process request or server not enable';
        } else {

            $myCmdXOut = $response['body'];

            $loginfo = "response ::  " . $myCmdXOut;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);


            $vsTokenData = json_decode($myCmdXOut);

            $vsTokenResponse = '';
            if (is_object($vsTokenData)) {
                $vsSuccessStatus = strtolower($vsTokenData->status);

                if ($vsSuccessStatus == 1) {

                    $vsTokenResponse = $vsTokenData->token;


                    if (get_option('vs_visualsearch_api_key')) {

                        update_option('vs_visualsearch_api_key', $vsTokenResponse);

                        // update_option('vs_visualsearch_accelx_user', sanitize_text_field($_POST['vs_visualsearch_accelx_user']));
                        // update_option('vs_visualsearch_accelx_pass', sanitize_text_field($_POST['vs_visualsearch_accelx_pass']));
                    } else {

                        add_option('vs_visualsearch_api_key', $vsTokenResponse);

                        // update_option('vs_visualsearch_accelx_user', sanitize_text_field($_POST['vs_visualsearch_accelx_user']));
                        // update_option('vs_visualsearch_accelx_pass', sanitize_text_field($_POST['vs_visualsearch_accelx_pass']));
                    }

                    $vs_responseCode = '20';
                    $vs_responseMessage = 'Token generated successfully';
                } else {

                    delete_option('vs_visualsearch_api_key');

                    delete_option('vs_visualsearch_accelx_user');
                    delete_option('vs_visualsearch_accelx_pass');

                    $vs_responseCode = '21';
                    $vs_responseMessage = 'Worng username and password';

                    $eloginfo = "Regeneate Token :: Success Response is not valid::  " . $myCmdXOut;
                    VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                }
            } else {


                $eloginfo = "Regeneate Token :: Response is not Object::  " . $myCmdXOut;
                VsOptionSetting::vs_visualSearchErrorlog($eloginfo);

                delete_option('vs_visualsearch_api_key');

                delete_option('vs_visualsearch_accelx_user');
                delete_option('vs_visualsearch_accelx_pass');

                $vs_responseCode = '21';
                $vs_responseMessage = 'Worng username and password';
            }
        }

        //end token generation
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

//  End yesterday file deletion


        $loginfo = "End :: Token ReGeneration From Admin :: ";
        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

        // return $vsTokenResponse;
        return $vsTokenResponse;
    }

    public function vs_visualsearch_setting_accelx_credential_form_save() {

        $vs_accelx_user = '';
        $vs_accelx_pass = '';

        $url = VISUALSEARCH__PLUGIN_ML_API_GET_TOKEN;


        if (!isset($_POST['vs_visualsearch_accelx_credential_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_accelx_credential_of_nonce_field'], 'vs_visualsearch_accelx_credential_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {
            // process form data


            if ((isset($_POST['vs_visualsearch_accelx_user']) && $_POST['vs_visualsearch_accelx_user'] != '' ) && (isset($_POST['vs_visualsearch_accelx_pass']) && $_POST['vs_visualsearch_accelx_pass'] != '')) {


                if (get_option('vs_visualsearch_accelx_credential_set')) {

                    update_option('vs_visualsearch_accelx_credential_set', 1);
                } else {
                    add_option('vs_visualsearch_accelx_credential_set', 1);
                }


                $vs_accelx_user = sanitize_text_field($_POST['vs_visualsearch_accelx_user']);
                $vs_accelx_pass = sanitize_text_field($_POST['vs_visualsearch_accelx_pass']);


                if (get_option('vs_visualsearch_container')) {
                    $homeDomain = get_option('vs_visualsearch_container');
                } else {
                    $homeDomain1 = home_url();
                    $homeDomain2 = explode("//", $homeDomain1);
                    $homeDomain = $homeDomain2[1] . rand(11, 99);


                    $homeDomain = rand(111111, 99999999);

                    add_option('vs_visualsearch_container', $homeDomain);
                }






                //start Token generation

                $loginfo = "Start :: Geneate Token :: user  " . $vs_accelx_user . " and pass " . $vs_accelx_pass . " and homeDomain " . $homeDomain;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);


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
                        'gatewaykey' => $vs_accelx_user
                    ),
                    'cookies' => array()
                        )
                );



                if (is_wp_error($response)) {
                    $error_message = $response->get_error_message();
                    // echo "Something went wrong: $error_message";

                    $eloginfo = "Accelx Credential :: WP Cound not process request or server not enable ::  " . $error_message;
                    VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                    VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

                    $vs_responseCode = '21';
                    $vs_responseMessage = 'WP Cound not process request or server not enable';
                } else {
                    //  echo 'Response:<pre>';
                    //  print_r($response);
                    //  echo '</pre>';

                    $myCmdXOut = $response['body'];

                    //   echo 'BBBody:<pre>';
                    //     print_r($myCmdXOut);
                    //    echo '</pre>';



                    $loginfo = "response ::  " . $myCmdXOut;
                    VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                    $vsTokenData = json_decode($myCmdXOut);

                    //    echo '<pre>';
                    //     print_r($vsTokenData);
                    //     echo '</pre>';




                    $vsTokenResponse = '';
                    if (is_object($vsTokenData)) {
                        $vsSuccessStatus = strtolower($vsTokenData->status);

                        if ($vsSuccessStatus == 1) {

                            $vsTokenResponse = $vsTokenData->token;






                            if (get_option('vs_visualsearch_api_key')) {

                                update_option('vs_visualsearch_api_key', $vsTokenResponse);

                                update_option('vs_visualsearch_accelx_user', sanitize_text_field($_POST['vs_visualsearch_accelx_user']));
                                update_option('vs_visualsearch_accelx_pass', sanitize_text_field($_POST['vs_visualsearch_accelx_pass']));
                            } else {

                                add_option('vs_visualsearch_api_key', $vsTokenResponse);

                                update_option('vs_visualsearch_accelx_user', sanitize_text_field($_POST['vs_visualsearch_accelx_user']));
                                update_option('vs_visualsearch_accelx_pass', sanitize_text_field($_POST['vs_visualsearch_accelx_pass']));
                            }

                            $vs_responseCode = '20';
                            $vs_responseMessage = 'Token generated successfully';
                        } else {

                            delete_option('vs_visualsearch_api_key');

                            update_option('vs_visualsearch_accelx_user', sanitize_text_field($_POST['vs_visualsearch_accelx_user']));
                            update_option('vs_visualsearch_accelx_pass', sanitize_text_field($_POST['vs_visualsearch_accelx_pass']));



                            $vs_responseCode = '21';
                            $vs_responseMessage = 'Worng username and password';

                            $eloginfo = "Accelx Credential :: Success Response is not valid::  " . $myCmdXOut;
                            VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                        }
                    } else {


                        $eloginfo = "Accelx Credential :: Response is not Object::  " . $myCmdXOut;
                        VsOptionSetting::vs_visualSearchErrorlog($eloginfo);

                        delete_option('vs_visualsearch_api_key');

                        //   delete_option('vs_visualsearch_accelx_user');
                        //    delete_option('vs_visualsearch_accelx_pass');

                        $vs_responseCode = '21';
                        $vs_responseMessage = 'Worng username and password';
                    }
                }//end success response
            }


            $rUrl = 'admin.php?page=vs-setting&credentialTabOpt=1&vs_response_code=' . $vs_responseCode . '&vs_response_msg=' . $vs_responseMessage;
            $loginfo = "End :: Accelx Credential :: code  " . $vs_responseCode . " and message " . $vs_responseMessage;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);
            wp_redirect(admin_url($rUrl));
            //   wp_redirect(admin_url('admin.php?page=vs-setting'));
        }
    }

    public function vs_visualsearch_subscription_statistics_show() {


        $loginfo = "Start :: Subscription Statistics :: ";
        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

        $url = VISUALSEARCH__PLUGIN_ML_API_GET_SUBSCRIPTION;

        $homeDomain = get_option('vs_visualsearch_container');
        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $vs_auth_token = get_option('vs_visualsearch_api_key');

        $eloginfo = "Accelx Subscription Statistics :: homeDomain::  " . $homeDomain . " :: vs_accelx_user :: " . $vs_accelx_user . " :: vs_accelx_pass :: " . $vs_accelx_pass . " :: vs_auth_token :: " . $vs_auth_token;
        VsOptionSetting::vs_visualSearchInstalllog($eloginfo);





        if ($vs_auth_token != '') {


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
                    'token' => $vs_auth_token
                ),
                'cookies' => array()
                    )
            );



            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();

                $eloginfo = "Accelx Credential :: WP Cound not process request or server not enable ::  " . $error_message;
                VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

                $vs_responseCode = '21';
                $vs_responseMessage = 'WP Cound not process request or server not enable';
            } else {

                $myCmdXOut = $response['body'];

                $loginfo = "Subscription Statistics :: response  " . $myCmdXOut;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                $vsCommandData = json_decode($myCmdXOut);

                if (is_object($vsCommandData)) {
                    $vsSuccessStatus = strtolower($vsCommandData->status);

                    if ($vsSuccessStatus == '1') {

                        $vsPlanName = $vsCommandData->plan;
                        $vsMaxLimit = $vsCommandData->max_limit;
                        $vsBillingCycle = $vsCommandData->billing_cycle;
                        $vsClientName = $vsCommandData->name;
                        $vsActiveStatus = $vsCommandData->user_status;
                        $vsApiUsed = $vsCommandData->api_used;
                        $vsApiRemaining = $vsCommandData->api_remaining;
                    }
                }
            }

            $statistics = '<div class="row" style="padding-top: 10px; text-align: center;">
                        <div class="col-sm-12">
                            <h4 style="text-align: left;">Subscription Statistics</h4>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px; padding-bottom: 10px; text-align: center;">                        
                        <div class="col-sm-4">
                            <h6>Max API Limit</h6>
                            <h2>' . $vsMaxLimit . '</h2>
                        </div>
                        <div class="col-sm-4">
                            <h6>Consumed API</h6>
                            <h2>' . $vsApiUsed . '</h2>
                        </div>
                        <div class="col-sm-4">
                            <h6>Remaining API</h6>
                            <h2>' . $vsApiRemaining . '</h2>
                        </div>
                    </div>';
        } else {

            $statistics = '';

            $loginfo = "End :: Subscription Statistics :: API Token not found ";
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);
        }

        $loginfo = "End :: Subscription Statistics :: ";
        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

        echo $statistics;
    }

    public static function vs_visualSearchReSizeImage($file, $w, $h, $crop = FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }

    /**
     * Collect product from database
     * Then generate product.txt file
     * 
     * @access public
     * @return string
     * @return convMLTabOpt,
     * @return convMLSubTabOpt=product
     * @return vs_response_code
     * @return vs_response_msg
     * 
     *
     */
    public function vs_visualSearchProductCollecton_form_save() {

        if (!isset($_POST['vs_visualsearch_ProductCollecton_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_ProductCollecton_of_nonce_field'], 'vs_visualsearch_ProductCollecton_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {


            if (!get_option('vs_visualSearchProductCollecton_form_save')) {

                $vs_api_key = get_option('vs_visualsearch_api_key');


                if ($vs_api_key != "") {

                    $vs_response_code = 1;
                    $vs_response_msg = 'Test';

                    $argsX = array(
                        'paginate' => true,
                    );
                    $results = wc_get_products($argsX);
                    $totalProductCount = $results->total;

                    if (get_option('vs_visualsearch_active_product_counter')) {

                        update_option('vs_visualsearch_active_product_counter', $totalProductCount);
                    } else {
                        add_option('vs_visualsearch_active_product_counter', $totalProductCount);
                    }

                    //  $baseFactor = 500;
                    //  $baseFactor = 100;

                    $baseFactor = get_option('vs_visualsearch_product_picture_base_factor');
                    if ($baseFactor == '') {
                        $baseFactor = VISUALSEARCH__PLUGIN_PRODUCT_PICTURE_BASE_FACTOR;
                    }



                    $totalPage = ceil($totalProductCount / $baseFactor);

                    $loginfo = "Start :: Product Collecton :: Base Factor  " . $baseFactor . " and Total Product " . $totalProductCount . " and Total Pages " . $totalPage;
                    VsOptionSetting::vs_visualSearchInstalllog($loginfo);




                    //add option totalfileCount

                    if (get_option('vs_visualsearch_productTxtFileCounter')) {

                        update_option('vs_visualsearch_productTxtFileCounter', $totalPage);
                    } else {
                        add_option('vs_visualsearch_productTxtFileCounter', $totalPage);
                    }

                    //add option vs_visualSearchStepProcess_X
                    if (get_option('vs_visualSearchStepProcess_X')) {
                        update_option('vs_visualSearchStepProcess_X', $totalPage);
                    } else {
                        add_option('vs_visualSearchStepProcess_X', $totalPage);
                    }



                    $vs_visualsearch_productTxtFileCounterVal = get_option('vs_visualsearch_productTxtFileCounter');


                    $zip = new ZipArchive;

                    if ($totalPage > 1) {

                        $startLimit = $totalProductCount; //3001
                        $endLimit = $startLimit - $baseFactor; //3001- 100  3001-2901

                        $productFilenameZn = '';

                        $vs_active_product_list = array();

                        $vsFolderDirXM = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/';
                        wp_mkdir_p($vsFolderDirXM);

                        $vsFileNameM = $vsFolderDirXM . 'vsproduct' . '.txt';

                        for ($p = 1; $p <= $totalPage; $p++) {


                            $stepProcess = 'vs_visualSearchStepProcess_' . $p;
                            add_option($stepProcess, '1');

                            $vsGetHomepath = get_home_path();
                            //  $vsFolderDirX = VISUALSEARCH__PLUGIN_DIR . '/vspyscript/';
                            $vsFolderDirX = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/';
                            $vsFileName = $vsFolderDirX . 'vsproduct_' . $p . '.txt';
                            $zipPath = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/vsproduct_' . $p . '.zip';

                            $fileName = 'vs_file_name_' . $p;

                            add_option($fileName, '0');

                            $fileNameVal = get_option($fileName);

                            $loginfo = "Test Collecton :: $startLimit  " . $baseFactor . " and offset " . $endLimit;
                            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                            $argsPart = array(
                                'limit' => $baseFactor,
                                'offset' => $endLimit,
                                'order' => 'ASC'
                            );


                            $vsgetProductsPart = wc_get_products($argsPart);

                            foreach ($vsgetProductsPart as $vsgetproPart) {
                                $vsproductID = $vsgetproPart->id;

                                $vs_active_product_list[] = $vsproductID;

                                $vsproductName = $vsgetproPart->name;

                                $vspro = new WC_Product($vsproductID);
                                $vsgetProductImage = $vspro->get_image($size = 'shop_thumbnail');

                                $vsgetProductSku = $vspro->get_sku();
                                $vsimage_id = $vsgetproPart->image_id;
                                $vsproductAttachment = wc_get_product_attachment_props($vsimage_id);

                                $vsfull_src = $vsproductAttachment['full_src'];

                                $vsFullSrcExplode = explode("uploads/", $vsfull_src);
                                $vsImgName1 = $vsFullSrcExplode[1];

                                //check jpeg or png image

                                if (preg_match('/(\.jpg|\.JPG|\.jpeg|\.JPEG|\.png|\.PNG)$/i', $vsImgName1)) {

                                    $vs_upload_dir = wp_upload_dir();
                                    $vs_upload_dir_Xn = $vs_upload_dir['basedir'];

                                    $vsrealRootDirPathOfImage = VISUALSEARCH__PLUGIN_UPLOAD . '/' . $vsImgName1;

                                    $filepath = $vsrealRootDirPathOfImage;


                                    $img = VsOptionSetting ::vs_visualSearchReSizeImage($filepath, 300, 300);
                                   // VsOptionSetting::vs_visualSearchInstalllog( $vs_upload_dir['basedir']);


                                    $prand = rand('111111111', '999999999');
                                    //   $resized_path = VISUALSEARCH__PLUGIN_PYC_RESIZE_DIR . $p . '_' . '.jpg';
                                    //  $relative_path = $p . '_' . '.jpg';
                                    $resized_path = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/'. $prand . '_' . '.jpg';
                                    $relative_path = $prand . '_' . '.jpg';

                                    imagejpeg($img, $resized_path);


                                    $zip->open($zipPath, ZipArchive::CREATE);
                                    $zip->addFile($resized_path, $relative_path);
                                    $zip->close();
                                    wp_delete_file($resized_path);


                                    //  $vsSearchableName = $vsproductID . '|' . $vsgetProductSku . '|' . $vsrealRootDirPathOfImage;
                                    $vsSearchableName = $vsproductID . '||' . $relative_path;


                                    if (file_exists($vsFileName)) {
                                        $vsmyfile = file_put_contents($vsFileName, $vsSearchableName . PHP_EOL, FILE_APPEND | LOCK_EX);
                                    } else {
                                        $vsmyfile = fopen($vsFileName, "w") or die("Unable to open file!");
                                        $vslogdata1X = $vsSearchableName . "\r\n";
                                        fwrite($vsmyfile, $vslogdata1X);
                                    }


                                    if (file_exists($vsFileNameM)) {
                                        $vsmyfileM = file_put_contents($vsFileNameM, $vsSearchableName . PHP_EOL, FILE_APPEND | LOCK_EX);
                                    } else {
                                        $vsmyfileM = fopen($vsFileNameM, "w") or die("Unable to open file!");
                                        $vslogdata1XM = $vsSearchableName . "\r\n";
                                        fwrite($vsmyfileM, $vslogdata1XM);
                                    }
                                } else {
                                    $loginfo = "Start :: Product Collecton :: Piture in not JPEG or PNG :: ProductID ::" . $vsproductID . " and Product Image Name:: " . $vsImgName1;
                                    VsOptionSetting::vs_visualSearchInstalllog($loginfo);
                                }

                                $vs_p_counter++;
                                $vs_b_f_counter++;
                            }


                            $startLimit = $startLimit - $baseFactor;
                            if ($endLimit < $baseFactor) {
                                $baseFactor = $endLimit;
                                $endLimit = 0;
                            } else {
                                $endLimit = $endLimit - $baseFactor;
                            }





                            $productFilenameZn .= ' ' . $vsFileName;
                        }


                        //for add txt file in zip file

                        for ($p = 1; $p <= $totalPage; $p++) {

                            $zipPath = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/vsproduct_' . $p . '.zip';
                            $vsTxtFilePath = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/vsproduct_' . $p . '.txt';
                            $vsTxtFile_Realtive = 'vsproduct_' . $p . '.txt';
                            $zip->open($zipPath, ZipArchive::CREATE);
                            $zip->addFile($vsTxtFilePath, $vsTxtFile_Realtive);
                            $zip->close();

                            wp_delete_file($vsTxtFilePath);
                        }




                        $vs_visualsearch_active_productList = serialize($vs_active_product_list);


                        if (get_option('vs_visualsearch_active_product')) {
                            update_option('vs_visualsearch_active_product', $vs_visualsearch_active_productList);
                        } else {
                            add_option('vs_visualsearch_active_product', $vs_visualsearch_active_productList);
                        }



                        if (get_option('vs_visualSearchProductCollecton_form_save')) {

                            update_option('vs_visualSearchProductCollecton_form_save', '1');
                        } else {
                            add_option('vs_visualSearchProductCollecton_form_save', '1');
                        }

                        // end total page count greater then 1    
                    } else {



                        $productFilenameZn = '';

                        $vs_active_product_list = array();

                        $vsFolderDirXM = VISUALSEARCH__PLUGIN_UPLOAD . '/vspyscript/';
                        $vsFileNameM = $vsFolderDirXM . 'vsproduct' . '.txt';




                        $stepProcess = 'vs_visualSearchStepProcess_1';
                        add_option($stepProcess, '1');

                        $vsGetHomepath = get_home_path();
                        $vsFolderDirX = VISUALSEARCH__PLUGIN_UPLOAD . '/vspyscript/';
                        $vsFileName = $vsFolderDirX . 'vsproduct_1.txt';

                        $fileName = 'vs_file_name_1';

                        add_option($fileName, '0');

                        $fileNameVal = get_option($fileName);

                        $loginfo = "Test Collecton :: " . $baseFactor . " and Total " . $totalProductCount;
                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);



                        $argsPart = array(
                            'limit' => $totalProductCount,
                            'offset' => 0,
                            'order' => 'ASC'
                        );


                        $vsgetProductsPart = wc_get_products($argsPart);

                        foreach ($vsgetProductsPart as $vsgetproPart) {
                            $vsproductID = $vsgetproPart->id;

                            $vs_active_product_list[] = $vsproductID;

                            $vsproductName = $vsgetproPart->name;

                            $vspro = new WC_Product($vsproductID);
                            $vsgetProductImage = $vspro->get_image($size = 'shop_thumbnail');

                            $vsgetProductSku = $vspro->get_sku();
                            $vsimage_id = $vsgetproPart->image_id;
                            $vsproductAttachment = wc_get_product_attachment_props($vsimage_id);

                            $vsfull_src = $vsproductAttachment['full_src'];

                            $vsFullSrcExplode = explode("uploads/", $vsfull_src);
                            $vsImgName1 = $vsFullSrcExplode[1];


                            $vs_upload_dir = wp_upload_dir();
                            $vs_upload_dir_Xn = $vs_upload_dir['basedir'];

                            $vsrealRootDirPathOfImage = $vs_upload_dir_Xn . '/' . $vsImgName1;

                            //check jpeg or png image

                            if (preg_match('/(\.jpg|\.JPG|\.jpeg|\.JPEG|\.png|\.PNG)$/i', $vsImgName1)) {

                                //   $vsSearchableName = $vsproductID . '|' . $vsgetProductSku . '|' . $vsrealRootDirPathOfImage;							
                                //    $vsSearchableName = $vsproductID . '||' . $vsrealRootDirPathOfImage;


                                $vsSearchableName = $vsproductID . '||' . $vsImgName1;

                                if (file_exists($vsFileName)) {
                                    $vsmyfile = file_put_contents($vsFileName, $vsSearchableName . PHP_EOL, FILE_APPEND | LOCK_EX);
                                } else {
                                    $vsmyfile = fopen($vsFileName, "w") or die("Unable to open file!");
                                    $vslogdata1X = $vsSearchableName . "\r\n";
                                    fwrite($vsmyfile, $vslogdata1X);
                                }


                                if (file_exists($vsFileNameM)) {
                                    $vsmyfileM = file_put_contents($vsFileNameM, $vsSearchableName . PHP_EOL, FILE_APPEND | LOCK_EX);
                                } else {
                                    $vsmyfileM = fopen($vsFileNameM, "w") or die("Unable to open file!");
                                    $vslogdata1XM = $vsSearchableName . "\r\n";
                                    fwrite($vsmyfileM, $vslogdata1XM);
                                }
                            } else {
                                $loginfo = "Start :: Product Collecton :: Piture in not JPEG or PNG :: ProductID ::" . $vsproductID . " and Product Image Name:: " . $vsImgName1;
                                VsOptionSetting::vs_visualSearchInstalllog($loginfo);
                            }

                            $vs_p_counter++;
                            $vs_b_f_counter++;
                        }



                        $productFilenameZn .= ' ' . $vsFileName;





                        $vs_visualsearch_active_productList = serialize($vs_active_product_list);


                        if (get_option('vs_visualsearch_active_product')) {
                            update_option('vs_visualsearch_active_product', $vs_visualsearch_active_productList);
                        } else {
                            add_option('vs_visualsearch_active_product', $vs_visualsearch_active_productList);
                        }



                        if (get_option('vs_visualSearchProductCollecton_form_save')) {

                            update_option('vs_visualSearchProductCollecton_form_save', '1');
                        } else {
                            add_option('vs_visualSearchProductCollecton_form_save', '1');
                        }
                    }
                    //end API Key check   
                } else {
                    $vs_response_code = 0;
                    $vs_response_msg = "";
                }
                //end already product collection check
            } else {

                $vs_response_code = 0;
                $vs_response_msg = "Already collection complete";
            }

            $rUrl = 'admin.php?page=vs-setting&convMLTabOpt=1&convMLSubTabOpt=product&vs_response_code=' . $vs_response_code . '&vs_response_msg=' . $vs_response_msg . "#credtabXn";


            $loginfo = "End :: Product Collecton :: Url  " . $rUrl;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            wp_redirect(admin_url($rUrl));
        }
    }

    /**
     * When product.txt file genrated then this function working
     * This function generate product tv file
     * 
     * @access public
     * @return string
     * @return convMLTabOpt,
     * @return convMLSubTabOpt=product
     * @return vs_response_code
     * @return vs_response_msg
     * 
     *
     */
    public function vs_visualSearchHandshakeML_form_save() {

        if (!isset($_POST['vs_visualsearch_Handshake_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_Handshake_of_nonce_field'], 'vs_visualsearch_Handshake_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {

            $chkSHM = get_option('vs_visualSearchHandshakeML_form_save');
            if ($chkSHM != 1) {

                $vs_api_key = get_option('vs_visualsearch_api_key');


                if ($vs_api_key != "") {

                    $vs_productCollectonVal = get_option('vs_visualSearchProductCollecton_form_save');

                    if ($vs_productCollectonVal == 1) {

                        $vs_response_code = 1;
                        $vs_response_msg = 'Test';

                        $vs_visualsearch_FileCounterVal = get_option('vs_visualsearch_productTxtFileCounter');

                        if (get_option('vs_visualSearchHandshakeML_form_save')) {

                            update_option('vs_visualSearchHandshakeML_form_save', '1');
                        } else {
                            add_option('vs_visualSearchHandshakeML_form_save', '1');
                        }
                    } else {
                        $vs_response_code = 0;
                        $vs_response_msg = "";
                    }
                } else {
                    $vs_response_code = 91;
                    $vs_response_msg = "";
                }
            } else {
                $vs_response_code = 9;
                $vs_response_msg = "Already Handshake Complete";
            }

            $rUrl = 'admin.php?page=vs-setting&convMLTabOpt=1&convMLSubTabOpt=handshake&vs_response_code=' . $vs_response_code . '&vs_response_msg=' . $vs_response_msg . "#credtabXn";

            $loginfo = "End :: Handshake ML Server :: Url  " . $rUrl;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualSearchImageConversionStart_form_save() {


        $url = VISUALSEARCH__PLUGIN_ML_API_CREATE_TV_WP;

        $homeDomain = get_option('vs_visualsearch_container');
        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $vs_auth_token = get_option('vs_visualsearch_api_key');



        if (!isset($_POST['vs_visualsearch_ImageConversionStart_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_ImageConversionStart_of_nonce_field'], 'vs_visualsearch_ImageConversionStart_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {

            $chkICS = get_option('vs_visualSearchImageConversionStart');
            if ($chkICS != 1) {
                $vs_api_key = get_option('vs_visualsearch_api_key');


                if ($vs_api_key != "") {

                    $vs_handshakeVal = get_option('vs_visualSearchHandshakeML_form_save');

                    if ($vs_handshakeVal == 1) {



                        $loginfo = "Start :: Image Conversion Start ::";
                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                        if (get_option('vs_visualSearchImageConversionStart')) {

                            update_option('vs_visualSearchImageConversionStart', $nStartProcess);
                        } else {
                            add_option('vs_visualSearchImageConversionStart', $nStartProcess);
                        }


                        $totalZipFile = get_option('vs_visualsearch_productTxtFileCounter');


//$client = new Zend_Http_Client();
                        $nStartProcess = 1;
                        $maxcount = $totalZipFile;
                        for ($p = 1; $p <= $totalZipFile; $p++) {
                            $currentcount = $p;
                            //   $currentcount = 1;

                            $loginfo = "Image Conversion Start :: maxcount  " . $maxcount . " :: currentcount ::" . $currentcount;
                            VsOptionSetting::vs_visualSearchInstalllog($loginfo);


                            //    $zipPath = VISUALSEARCH__PLUGIN_DIR . '/setenv/vsproduct_' . $p . '.zip';
                            $zipPath = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/vsproduct_' . $currentcount . '.zip';

                            //    $fileContent = base64_encode(file_get_contents($zipPath));

                            $file = fopen($zipPath, 'r');
                            $file_size = filesize($zipPath);
                            $file_data = fread($file, $file_size);
                            //  fclose($zipPath);
                            //    $file_data = base64_encode(file_get_contents($zipPath));
//                                'accept' => 'application/json', // The API returns JSON
//                                'content-type' => 'application/binary', // Set content type to binary
//"Content-type" => "application/x-www-form-urlencoded;charset=UTF-8",
//  "Content-type" => "application/json",


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
                                    'maxcount' => $maxcount,
                                    'currentcount' => $currentcount,
                                    'file' => $file_data
                                ),
                                'cookies' => array()
                                    )
                            );


                            if (is_wp_error($response)) {
                                $error_message = $response->get_error_message();

                                $eloginfo = "Image Conversion Start :: WP Cound not process request or server not enable ::  " . $error_message;
                                VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                                VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

                                $vs_responseCode = '21';
                                $vs_responseMessage = 'WP Cound not process request or server not enable';
                            } else {

                                $myCmdXOut = $response['body'];

                                $loginfo = "Image Conversion Start :: response  " . $myCmdXOut;
                                VsOptionSetting::vs_visualSearchInstalllog($loginfo);

//                                $vsCommandData = json_decode($myCmdXOut);
//                                if (is_object($vsCommandData)) {
//                                    $vsSuccessStatus = strtolower($vsCommandData->status);
//                                    if ($vsSuccessStatus != '1') {
//                                        
//                                    }
//                                }
                            }
                            $nStartProcess++;


                            $vs_response_code = 1;
                            $vs_response_msg = "Successfully complete ";
                        }
                    } else {
                        $vs_response_code = 0;
                        $vs_response_msg = "Error";
                    }
                } else {
                    $vs_response_code = 91;
                    $vs_response_msg = "Error";
                }
            } else {
                $vs_response_code = 9;
                $vs_response_msg = "Error";
            }



            $rUrl = 'admin.php?page=vs-setting&convMLTabOpt=1&convMLSubTabOpt=image-process-start&vs_response_code=' . $vs_response_code . '&vs_response_msg=' . $vs_response_msg . "#credtabXn";

            $loginfo = "End :: Image Conversion Start :: Url  " . $rUrl;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualsearch_process_form_save() {


        if (!isset($_POST['vs_visualsearch_process_form_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_process_form_of_nonce_field'], 'vs_visualsearch_process_form_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {
            // process form data


            $loginfo = "Start :: Conversion Process :: ";
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);






            if ((isset($_POST['vs_visualsearch_procee_number']) && $_POST['vs_visualsearch_procee_number'] != '')) {

                $vs_visualsearch_procee_number = sanitize_text_field($_POST['vs_visualsearch_procee_number']);


                $loginfo = "Conversion Process :: process number  " . $vs_visualsearch_procee_number;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);


                //   if ($vs_stepProcess_Xn >= 1) {

                $k = $vs_visualsearch_procee_number;


                
                $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_MASTER_TV;
                $master_imagelist_file = VISUALSEARCH__PLUGIN_PYC_MASTER_PKLn . '_' . $k . '.pkl';
                $master_tv_tree_file = VISUALSEARCH__PLUGIN_PYC_TV_TREEn . '_' . $k . '.ann';
                $ml_server_url_port = VISUALSEARCH__PLUGIN_ML_SERVER_URL;
                $ml_auth_user = get_option('vs_visualsearch_accelx_user');
                $ml_auth_token = get_option('vs_visualsearch_api_key');
                $test_tv_pkl = VISUALSEARCH__PLUGIN_PYC_TEST_TV_PKLn . '_' . $k . '.pkl';
                $prograss = VISUALSEARCH__PLUGIN_DIR . 'vspyscript/prograss.txt';
                $nComponents = VISUALSEARCH__PLUGIN_ML_FN_N_COMPONENTS;
                $server_geo_location = VISUALSEARCH__PLUGIN_ML_FN_GEO_LOCATION;


                //    $ml_server_number_thread = VISUALSEARCH__PLUGIN_ML_FN_NUM_THREAD;

                $vs_visualsearch_number_of_thread = get_option('vs_visualsearch_number_of_thread');
                if ($vs_visualsearch_number_of_thread == '') {
                    $vs_visualsearch_number_of_thread = VISUALSEARCH__PLUGIN_ML_FN_NUM_THREAD;
                }

                $ml_server_number_thread = $vs_visualsearch_number_of_thread;


                //for linux
                // $cmdXn = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' " . $ml_server_url_port . " '" . $ml_auth_token . "' '" . $test_tv_pkl . "' '" . $server_geo_location . "' '" . $ml_server_number_thread . "' " . $nComponents;
                // $cmdXn = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' " . $ml_server_url_port . " '" . $ml_auth_token . "' '" . $test_tv_pkl . "' '" . $server_geo_location . "' '" . $ml_server_number_thread . "' " . $nComponents . " '" . $ml_auth_user . "'";
                $cmdXn = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $master_imagelist_file . "' '" . $master_tv_tree_file . "' " . $ml_server_url_port . " '" . $ml_auth_token . "' '" . $test_tv_pkl . "' '" . $server_geo_location . "' '" . $ml_server_number_thread . "' " . $nComponents . " '" . $ml_auth_user . "' 'uploaded'";
                //for windows
                //  $cmdXn = $python . " " . $scriptPath . " " . $commandFuncion . " " . $master_imagelist_file . " " . $master_tv_tree_file . " " . $ml_server_url_port . " " . $ml_auth_token . " " . $test_tv_pkl . " " . $server_geo_location . " " . $ml_server_number_thread . " " . $nComponents;

                $loginfo = "Conversion Process :: command  " . $cmdXn;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);


                $myCmdXOut1 = shell_exec("$cmdXn 2>&1");








                //update  vs_visualSearchStepProcess_X value

                $nValueProcessX = $vs_visualsearch_procee_number - 1;

                update_option('vs_visualSearchStepProcess_X', $nValueProcessX);
            }


            if ($nValueProcessX == 0) {




              
                $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_MASTER_TREE_FROM_TV_DIR;
                $tem_tv_dir = VISUALSEARCH__PLUGIN_DIR . 'vspyscript/tmp_tv_dir/';
                $master_tv_pkl = VISUALSEARCH__PLUGIN_MASTER_TV_PKL;
                $master_tv_tree = VISUALSEARCH__PLUGIN_PYC_TV_TREE;

                //for linux
                $cmdXmasterTvTree = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $tem_tv_dir . "' 'test_tv' " . $master_tv_pkl . " '" . $master_tv_tree . "'";
                //for windows
                //  $cmdXn = $python . " " . $scriptPath . " " . $commandFuncion . " " . $master_imagelist_file . " " . $master_tv_tree_file . " " . $ml_server_url_port . " " . $ml_auth_token . " " . $test_tv_pkl . " " . $server_geo_location . " " . $ml_server_number_thread . " " . $nComponents;

                $loginfo = "Conversion Process :: command  " . $cmdXmasterTvTree;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);


                $myCmdXmasterTvTreeOut1 = shell_exec("$cmdXmasterTvTree 2>&1");


                $loginfo = "Conversion Process :: Response  " . $myCmdXmasterTvTreeOut1;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);




                if (get_option('vs_visualSearchImageConversionStart')) {

                    update_option('vs_visualSearchImageConversionStart', '2');
                } else {
                    add_option('vs_visualSearchImageConversionStart', '2');
                }

                if (get_option('vs_visualsearch_process_configuration_delete')) {
                    update_option('vs_visualsearch_process_configuration_delete', '1');
                } else {
                    add_option('vs_visualsearch_process_configuration_delete', '1');
                }
            }



            $rUrl = 'admin.php?page=vs-setting&convMLTabOpt=1&convMLSubTabOpt=image-process&step=' . $nValueProcessX . '&vs_response_code=' . $nValueProcessX . '&vs_response_msg=' . $nValueProcessX . '&progressBarShown=1' . "#credtabXn";


            $loginfo = "End :: Conversion Process :: Url  " . $rUrl;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualsearch_process_configuration_delete() {
        // vs_visualsearch_process_form_save
        global $wpdb; // this is how you get access to the database
        $url =VISUALSEARCH__PLUGIN_ML_FN_REMOVE_CONFIG;

        $homeDomain = get_option('vs_visualsearch_container');
        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $vs_auth_token = get_option('vs_visualsearch_api_key');

        if (!isset($_POST['vs_visualsearch_configuration_delete_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_configuration_delete_of_nonce_field'], 'vs_visualsearch_configuration_delete_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {

            $loginfo = "Start :: Delete Configuration ::";
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            delete_option("vs_visualsearch_active_product");
            delete_option("vs_visualsearch_active_product_counter");
            delete_option("vs_visualsearch_productTxtFile");
            delete_option("vs_visualsearch_MasterImageListFile");
            delete_option("vs_visualsearch_PKLFile");
            delete_option("vs_visualSearch_Configuration_Start");

            $vsProductFile = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/vsproduct.txt';
            
            if (file_exists($vsProductFile)) {
                wp_delete_file($vsProductFile);
            }
           

            //Removing Zip file


            $vs_visualsearch_FileCounterValn = get_option('vs_visualsearch_productTxtFileCounter');
            for ($m = 1; $m <= $vs_visualsearch_FileCounterValn; $m++) {

                $vsProductFile = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/vsproduct' . '_' . $m . '.zip';
               
                if (file_exists($vsProductFile)) {
                    wp_delete_file($vsProductFile);
                }
              
            }
           
         

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
                    'token' => $vs_auth_token
                ),
                'cookies' => array()
                    )
            );


            $plugin_options = $wpdb->get_results("SELECT option_name FROM $wpdb->options WHERE   
	option_name LIKE 'vs_visualSearchProductCollecton_form_save%'  
        OR option_name LIKE 'vs_visualSearchHandshakeML_form_save%' 
        OR option_name LIKE 'vs_visualSearchImageConversionStart%' 
        OR option_name LIKE 'vs_visualsearch_productTxtFileCounter%' 	
        OR option_name LIKE 'vs_visualSearchStepProcess_%' 
        OR option_name LIKE 'vs_visualsearch_process_configuration_delete%'");

//        SELECT * FROM `wp_options` WHERE 
//	 option_name LIKE 'vs_visualSearchProductCollecton_form_save%' 
//        OR option_name LIKE 'vs_visualSearchHandshakeML_form_save%'
//        OR option_name LIKE 'vs_visualSearchImageConversionStart%'
//        OR option_name LIKE 'vs_visualsearch_productTxtFileCounter%'	
//        OR option_name LIKE 'vs_visualSearchStepProcess_%'

            foreach ($plugin_options as $option) {
                delete_option($option->option_name);
            }




            delete_option("vs_visualsearch_process_configuration_delete");



            $vs_responseCode = 1;
            $vs_responseMessage = "Removed all configuration successfully";
        }
        $rUrl = 'admin.php?page=vs-setting&convMLTabOpt=1&convMLSubTabOpt=del-config-opt&vs_response_code=' . $vs_responseCode . '&vs_response_msg=' . $vs_responseMessage;

        $loginfo = "End :: Delete Configuration :: Url  " . $rUrl;
        VsOptionSetting::vs_visualSearchInstalllog($loginfo);
        wp_redirect(admin_url($rUrl));
    }

    public function vs_create_admin_subMenu_page() {

        $parent_slug = 'vs-dashboard';
        $page_title = __('Visual Search Setting', 'visual-search');
        $menu_title = __('Settings', 'visual-search');
        $capability = 'manage_options';
        $slug = 'vs-setting';
        $callback = array($this, 'vs_option_setting_page_contentTemplate');

        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $slug, $callback);
    }

    public function vs_option_setting_page_content() {
        require_once VISUALSEARCH__PLUGIN_DIR . "templates/admin/vs-setting-form.php";
    }

    public function vs_option_setting_page_contentTemplate() {



        if (isset($_GET['page']) && $_GET['page'] != '') {
            $pageName = sanitize_key($_GET['page']);
        } else {
            $pageName = '';
        }
        if (isset($_GET['settingtab']) && $_GET['settingtab'] != '') {
            $settingtabName = sanitize_key($_GET['settingtab']);
        } else {
            $settingtabName = '';
        }
        if ($pageName == 'vs-setting' && ($settingtabName == '' || $settingtabName == 'options-setting')) {
            require_once VISUALSEARCH__PLUGIN_DIR . "templates/admin/vs-setting-form.php";
        } else if ($pageName == 'vs-setting' && $settingtabName == 'option-product-add-remove') {
            require_once VISUALSEARCH__PLUGIN_DIR . "templates/admin/vs-setting-manage-product-tab.php";
        } elseif ($pageName == 'vs-setting' && $settingtabName == 'uploadpicture') {
            require_once VISUALSEARCH__PLUGIN_DIR . "templates/admin/vs-setting-upload-picture-tab.php";
        } elseif ($pageName == 'vs-setting' && $settingtabName == 'viewlog') {
            require_once VISUALSEARCH__PLUGIN_DIR . "templates/admin/vs-setting-view-log-tab.php";
        } else {
            require_once VISUALSEARCH__PLUGIN_DIR . "templates/admin/vs-setting-form.php";
        }
    }

    public function vs_visualsearch_setting_number_of_thread_form_save() {

      
        $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_GET_TOKEN;
        $ml_server_url_port = VISUALSEARCH__PLUGIN_ML_SERVER_URL;
        $server_geo_location = VISUALSEARCH__PLUGIN_ML_FN_GEO_LOCATION;



        if (!isset($_POST['vs_visualsearch_number_of_thread_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_number_of_thread_of_nonce_field'], 'vs_visualsearch_number_of_thread_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {

            if (isset($_POST['vs_visualsearch_number_of_thread']) && $_POST['vs_visualsearch_number_of_thread'] != '') {
                if (is_numeric($_POST['vs_visualsearch_number_of_thread'])) {

                    $thdval = sanitize_text_field($_POST['vs_visualsearch_number_of_thread']);
                    if (1 <= $thdval && $thdval <= 10) {

                        update_option('vs_visualsearch_number_of_thread', sanitize_text_field($_POST['vs_visualsearch_number_of_thread']));
                        $vs_responseCode = '1';
                        $vs_responseMessage = 'Number of thread updated';
                    } else {
                        $vs_responseCode = '0';
                        $vs_responseMessage = 'Error!!! Number of thread must be below 10 ';
                    }
                } else {
                    $vs_responseCode = '0';
                    $vs_responseMessage = 'Error!!! Number of thread must be numaric or  below 10 ';
                }
            }



            $rUrl = 'admin.php?page=vs-setting&envNbrThrdTabOpt=1&vs_response_code=' . $vs_responseCode . '&vs_response_msg=' . $vs_responseMessage;
            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualsearch_setting_download_environment_check_form_save() {

        global $wpdb; // this is how you get access to the database

        $dwnFromFileLink = VISUALSEARCH__PLUGIN_PYTHON_FILE_FROM_SERVER_URL;
        $dwnToFileLink = VISUALSEARCH__PLUGIN_PYTHON_FILE_TO_SERVER_URL;

      



        if (!isset($_POST['vs_visualsearch_download_environment_check_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_download_environment_check_of_nonce_field'], 'vs_visualsearch_download_environment_check_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {


            $cmdX = $python . " --version ";
            //  echo $cmdX;

            $myCmdXOut = shell_exec("$cmdX 2>&1");



            if (trim($myCmdXOut) == "Python 3.6.3") {

                $libraryFileName = VISUALSEARCH__PLUGIN_PYTHON_FILE_TO_SERVER_URL . 'python-3.6.3.zip';



                if (file_exists($libraryFileName)) {
                    wp_delete_file($libraryFileName);
                }


                $vs_responseCode = 1;

                $vs_responseMessage = "Setup Environment is OK";
                add_option('vs_visualsearch_download_environment_set', 1);
            } else {
                delete_option('vs_visualsearch_download_environment_set');
                $vs_responseCode = 0;
                $vs_responseMessage = "Problem when setup environment";
            }


            $rUrl = 'admin.php?page=vs-setting&envSetupTabOpt=1&vs_response_code=' . $vs_responseCode . '&vs_response_msg=' . $vs_responseMessage;

            // wp_redirect(admin_url('admin.php?page=vs-setting'));

            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualsearch_setting_configuration_javascript() {
        ?>
        <script type="text/javascript" >

            var jvVS = jQuery.noConflict();
            function vs_visualSearchImageCoversionStart(agr1, agr2) {

                console.log("OK:::vs_visualSearchImageCoversionStart ::" + agr1 + " :: " + agr2);
                jvVS("#vs_visualSearchImageCoversionStartBtn").html("Loading");

                //     document.getElementById("myBtn").disabled = true;
                //  jvVS("#vs_visualSearchImageConversionStart" + agr1).html("Loading");
                var responseMsg;
                var data = {
                    'action': 'vs_visualSearchImageCoversionStartByJS',
                    'totalProductCount': agr1,
                    'productSeession': agr2
                };
                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function (response) {

                    console.log(response);
                    if (response.vs_responseCode == 1) {
                        responseMsg = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Success!</strong>  ' + response.vs_responseMessage + '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                        jvVS("#vs_up_row" + agr1).html('<td colspan="3">' + responseMsg + '</td>');
                        jvVS("#vs_visualsearch_notice_info").append(responseMsg);
                    } else {
                        responseMsg = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Error!</strong>  ' + response.vs_responseMessage + '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                        jvVS("#vs_up_row" + agr1).html('<td colspan="3">' + responseMsg + '</td>');
                    }
                }, "json");
                // });

            }


            function vs_visualSearchImageProgressBarStart(totalcount, processcount) {

                console.log("OK:::vs_visualSearchImageProgressBarStart ::" + totalcount + " :: " + processcount);
                //  jvVS("#vs_visualSearchImageCoversionStartBtn" + agr1).html("Loading");
                var progressBar, progressBarText, progressBarWidth, argrument;
                // 


        //                jvVS("#vs_visualSearchImageConversionProgressBarCon").show();
        //                progressBar = '<div class="col-md-10 offset-md-1">'
        //                        + '<div class="progress vs-setting-progress-h-m">'
        //                        + '<div id="vs_visualSearchProductConversionProgressBar" class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">'
        //                        + '<span> 100 of 1000 Image processing completed</span>'
        //                        + '</div>'
        //                        + '</div>'
        //                        + '</div>';

                if (processcount == 0) {

                    argrument = "'" + totalcount + "','" + processcount + "'";
                    progressBarText = processcount + ' of ' + totalcount + ' Image processing completed';
                    progressBarWidth = "0";
                    progressBar = '<div class="col-md-10 offset-md-1">'
                            + '<div class="progress vs-setting-progress-h-m">'
                            + '<div id="vs_visualSearchProductConversionProgressBar" class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressBarWidth + '%;">'
                            + '<span>' + progressBarText + '</span>'
                            + '</div>'
                            + '</div>'
                            + '</div>';
                    jvVS("#vs_visualSearchImageConversionProgressBarCon").html(progressBar).show();
                    vs_visualSearchImageProgressBarCheck(totalcount,processcount);

                    //jvVS("#vs_visualSearchImageCoversionStartBtn").html("Step-III :: Product Image ConversionTestt");
                    document.getElementById("vs_visualSearchImageCoversionStartBtn").disabled = true;
                    jvVS("#vs_responce_code_message_from_server").text("Product image conversion has already been started");

                } else {

                    if (totalcount == processcount) {

                        argrument = "'" + totalcount + "','" + processcount + "'";
                        progressBarText = processcount + ' of ' + totalcount + ' Image processing completed';
                        progressBarWidth = "100";
                        progressBar = '<div class="col-md-10 offset-md-1">'
                                + '<div class="progress vs-setting-progress-h-m">'
                                + '<div id="vs_visualSearchProductConversionProgressBar" class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressBarWidth + '%;">'
                                + '<span>' + progressBarText + '</span>'
                                + '</div>'
                                + '</div>'
                                + '</div>';

                        jvVS("#vs_visualSearchImageCoversionStartBtn").html("Step-III :: Product Image Conversion");
                        //document.getElementById("vs_visualSearchImageCoversionStartBtn").disabled = true;
                        jvVS("#vs_visualSearchImageConversionProgressBarCon").html(progressBar).show();
                        
                        jvVS("#vs_visualSearchImageCoversionStartBtn").attr("disabled", "disabled");
                        //jvVS("#deletetabXn").show();
                        window.location.reload()
                        jvVS("#vs_responce_code_message_from_server").text("Product image conversion has been completed");


                        
                    } else {

                        argrument = "'" + totalcount + "','" + processcount + "'";
                        progressBarText = processcount + ' of ' + totalcount + ' Image processing completed';
                        progressBarWidth = Math.ceil((Number(processcount) / Number(totalcount)) * 100);
                        //    $progressPercentage = ceil((($baseFactor * ($totalPage - $vs_visualsearch_procee_number)) / $totalProductCount) * 100);

                        progressBar = '<div class="col-md-10 offset-md-1">'
                                + '<div class="progress vs-setting-progress-h-m">'
                                + '<div id="vs_visualSearchProductConversionProgressBar" class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: ' + progressBarWidth + '%;">'
                                + '<span>' + progressBarText + '</span>'
                                + '</div>'
                                + '</div>'
                                + '</div>';
                        jvVS("#vs_visualSearchImageConversionProgressBarCon").html(progressBar).show();
                        vs_visualSearchImageProgressBarCheck(totalcount,processcount);
                    }
                }
            }



            function vs_visualSearchImageProgressBarCheck(totalcount, processcount) {

                console.log("OK:::vs_visualSearchImageProgressBarCheck ::" + totalcount + " :: " + processcount + " :::OK");
                //   jvVS("#vs_visualSearchImageCoversionStartBtn" + agr1).html("Loading");
                var responseMsg, productProcessCount, totalProductCount;
                var data = {
                    'action': 'vs_visualSearchImageProgressBarCheckByJS',
                    'totalProductCount': totalcount,
                    'productProcessCount': processcount
                };

                //   "vs_responseCode" => $vs_responseCode,
                // "totalProductCount" => $vs_totalProductCount,
                //   "productProcessCount" => $vs_productProcessCount,
                //   "vs_responseMessage" => $vs_responseMessage
                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function (response) {
                    console.log("vs_visualSearchImageProgressBarCheck :: Response");
                    console.log(response);
                    if (response.vs_responseCode != 1) {
                        totalProductCount = response.totalProductCount;
                        productProcessCount = response.productProcessCount;

                        console.log("response:totalProductCoun :: " + response.totalProductCount);
                        console.log("response:productProcessCount :: " + response.productProcessCount);

                        vs_visualSearchImageProgressBarStart(totalProductCount, productProcessCount);
                    }
                }, "json");
                // });

            }





            function vs_visualSearchSettingsUploadPictureDelete(agr1, agr2, agr3) {

                console.log("OK:::vs_visualSearchSettingsUploadPictureDelete ::" + agr1 + " :: " + agr2);
                jvVS("#vs_visualSearchSettingsUploadPictureDeleteBtn" + agr1).html("Loading");
                var responseMsg;
                var data = {
                    'action': 'vs_visualSearchSettingsUploadPictureDelete',
                    'uploadedPictureRowID': agr1,
                    'uploadedPictureName': agr2,
                    'uploadedPictureLink': agr3
                };
                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function (response) {

                    if (response.vs_responseCode == 1) {
                        responseMsg = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Success!</strong>  ' + response.vs_responseMessage + '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                        jvVS("#vs_up_row" + agr1).html('<td colspan="3">' + responseMsg + '</td>');
                        jvVS("#vs_visualsearch_notice_info").append(responseMsg);
                    } else {
                        responseMsg = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Error!</strong>  ' + response.vs_responseMessage + '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                        jvVS("#vs_up_row" + agr1).html('<td colspan="3">' + responseMsg + '</td>');
                    }
                }, "json");
                // });

            }

        </script> 
        <?php

    }

    public function vs_visualSearchImageCoversionStartByJS() {


        $url = VISUALSEARCH__PLUGIN_ML_API_CREATE_TV_WP;

        $homeDomain = get_option('vs_visualsearch_container');
        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $vs_auth_token = get_option('vs_visualsearch_api_key');


        $totalProductCount = sanitize_text_field($_POST['totalProductCount']);
        $productSeession = sanitize_text_field($_POST['productSeession']);

        $chkICS = get_option('vs_visualSearchImageConversionStart');
        if ($chkICS != 1) {
            $vs_api_key = get_option('vs_visualsearch_api_key');


            if ($vs_api_key != "") {

                $vs_handshakeVal = get_option('vs_visualSearchHandshakeML_form_save');

                if ($vs_handshakeVal == 1) {



                    $loginfo = "Start :: Image Conversion Start ::";
                    VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                    // if (get_option('vs_visualSearchImageConversionStart')) {

                    //     update_option('vs_visualSearchImageConversionStart', $nStartProcess);
                    // } else {
                    //     add_option('vs_visualSearchImageConversionStart', $nStartProcess);
                    // }


                    $totalZipFile = get_option('vs_visualsearch_productTxtFileCounter');


//$client = new Zend_Http_Client();
                    $nStartProcess = 1;
                    $maxcount = $totalZipFile;
                    for ($p = 1; $p <= $totalZipFile; $p++) {
                        $currentcount = $p;
                        //   $currentcount = 1;

                        $loginfo = "Image Conversion Start :: maxcount  " . $maxcount . " :: currentcount ::" . $currentcount;
                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);


                        //    $zipPath = VISUALSEARCH__PLUGIN_DIR . '/setenv/vsproduct_' . $p . '.zip';
                        $zipPath = VISUALSEARCH__PLUGIN_UPLOAD . '/setenv/vsproduct_' . $currentcount . '.zip';

                        //    $fileContent = base64_encode(file_get_contents($zipPath));

                        $file = fopen($zipPath, 'r');
                        $file_size = filesize($zipPath);
                        $file_data = fread($file, $file_size);
                        //  fclose($zipPath);
                        //    $file_data = base64_encode(file_get_contents($zipPath));
//                                'accept' => 'application/json', // The API returns JSON
//                                'content-type' => 'application/binary', // Set content type to binary
//"Content-type" => "application/x-www-form-urlencoded;charset=UTF-8",
//  "Content-type" => "application/json",


                        $response = wp_remote_post($url, array(
                            'method' => 'POST',
                            'timeout' => 4500,
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
                                'maxcount' => $maxcount,
                                'currentcount' => $currentcount,
                                'file' => $file_data
                            ),
                            'cookies' => array()
                                )
                        );


                        if (is_wp_error($response)) {
                            $error_message = $response->get_error_message();

                            $eloginfo = "Image Conversion Start :: WP Cound not process request or server not enable ::  " . $error_message;
                            VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
                            VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

                            $vs_responseCode = '21';
                            $vs_responseMessage = 'WP Cound not process request or server not enable';
                        } else {

                            $myCmdXOut = $response['body'];

                            $loginfo = "Image Conversion Start :: response  " . $myCmdXOut;
                            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

//                                $vsCommandData = json_decode($myCmdXOut);
//                                if (is_object($vsCommandData)) {
//                                    $vsSuccessStatus = strtolower($vsCommandData->status);
//                                    if ($vsSuccessStatus != '1') {
//                                        
//                                    }
//                                }
                        }
                        $nStartProcess++;
                    }

                    if (get_option('vs_visualSearchImageConversionStart')) {

                        update_option('vs_visualSearchImageConversionStart', '1');
                    } else {
                        add_option('vs_visualSearchImageConversionStart', '1');
                    }

                    $vs_response_code = 1;
                    $vs_response_msg = "Successfully complete ";
                } else {
                    $vs_response_code = 0;
                    $vs_response_msg = "Error";
                }
            } else {
                $vs_response_code = 91;
                $vs_response_msg = "Error";
            }
        } else {
            $vs_response_code = 9;
            $vs_response_msg = "Error";
        }



        //   $rUrl = 'admin.php?page=vs-setting&convMLTabOpt=1&convMLSubTabOpt=image-process-start&vs_response_code=' . $vs_response_code . '&vs_response_msg=' . $vs_response_msg . "#credtabXn";

        $loginfo = "End :: Image Conversion Start :: Url  " . $rUrl;
        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

        //    wp_redirect(admin_url($rUrl));



        $data = array(
            "vs_responseCode" => $vs_response_code,
            "vs_responseMessage" => $vs_response_msg
        );
        echo json_encode($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function vs_visualSearchImageProgressBarCheckByJS() {
        global $wpdb; // this is how you get access to the database


        $url = VISUALSEARCH__PLUGIN_ML_API_MASTER_TV_PROGRESS;

        $homeDomain = get_option('vs_visualsearch_container');
        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $vs_auth_token = get_option('vs_visualsearch_api_key');
        // 'totalProductCount': totalcount,
        // 'productProcessCount': processcount

        $totalProductCount = sanitize_text_field($_POST['totalProductCount']);
        $productSeession = sanitize_text_field($_POST['productProcessCount']);

        $maxcount = get_option('vs_visualsearch_productTxtFileCounter');


        $response = wp_remote_post($url, array(
            'method' => 'POST',
            'timeout' => 4500,
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
                'maxcount' => $maxcount
            ),
            'cookies' => array()
                )
        );


        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();

            $eloginfo = "Image Conversion Check :: Cound not process request or server not enable ::  " . $error_message;
            VsOptionSetting::vs_visualSearchErrorlog($eloginfo);
            VsOptionSetting::vs_visualSearchInstalllog($eloginfo);

            $vs_responseCode = '1';
            $vs_responseMessage = 'WP Cound not process request or server not enable';
            $vs_productProcessCount = 0;
        } else {

            $myCmdXOut = $response['body'];

            $loginfo = "Image Conversion Check :: response  " . $myCmdXOut;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            $vsCommandData = json_decode($myCmdXOut);
            if (is_object($vsCommandData)) {
                $vsSuccessStatus = strtolower($vsCommandData->status);
                if ($vsSuccessStatus) {
                    $vs_productProcessCount = $vsCommandData->totalProcessImages;
                } else {
                    $vs_productProcessCount = 0;
                    $vs_responseCode = '1';
                    $vs_responseMessage = 'Status code is worng';
                }
            } else {
                $vs_productProcessCount = 0;
                $vs_responseCode = '1';
                $vs_responseMessage = 'Response in not object';
            }
        }



        //totalProductCount = response.totalProductCount;
        // productProcessCount = response.productProcessCount;

        $vs_totalProductCount = get_option('vs_visualsearch_active_product_counter');
        if($vs_totalProductCount ==  $vs_productProcessCount)
        {
            if (get_option('vs_visualsearch_process_configuration_delete')) {
                update_option('vs_visualsearch_process_configuration_delete', '1');
            } else {
                add_option('vs_visualsearch_process_configuration_delete', '1');
            }
            if (get_option('vs_visualSearch_Configuration_Start')) {
                update_option('vs_visualSearch_Configuration_Start', '1');
            } else {
                add_option('vs_visualSearch_Configuration_Start', '1');
            }
        }

        $data = array(
            "vs_responseCode" => $vs_responseCode,
            "totalProductCount" => $vs_totalProductCount,
            "productProcessCount" => $vs_productProcessCount,
            "vs_responseMessage" => $vs_responseMessage
        );
        echo json_encode($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function vs_visualSearchSettingsUploadPictureDelete() {

        global $wpdb; // this is how you get access to the database

        $uploadedPictureRowID = sanitize_text_field($_POST['uploadedPictureRowID']);
        $uploadedPictureName = sanitize_text_field($_POST['uploadedPictureName']);
        $uploadedPictureLink = sanitize_text_field($_POST['uploadedPictureLink']);

        $uploadedPictureNameLink = VISUALSEARCH__PLUGIN_UPLOAD . 'searchpictureuploads/' . $uploadedPictureName;

        if (file_exists($uploadedPictureNameLink)) {

            wp_delete_file($uploadedPictureNameLink);

            $vs_responseCode = 1;
            $vs_responseMessage = "Delete uploaded picture successfully";
        } else {
            $vs_responseCode = 0;
            $vs_responseMessage = "Picture cannot be deleted due to an error";
        }


        $data = array(
            "vs_responseCode" => $vs_responseCode,
            "vs_responseMessage" => $vs_responseMessage
        );
        echo json_encode($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function vs_visualsearch_setting_front_suggested_product_form_save() {


        if (!isset($_POST['vs_visualsearch_front_suggested_product_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_front_suggested_product_of_nonce_field'], 'vs_visualsearch_front_suggested_product_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {




            if ((isset($_POST['vs_visualsearch_front_number_of_product']) && $_POST['vs_visualsearch_front_number_of_product'] != '')) {
                $vs_visualsearch_front_number_of_product = sanitize_text_field($_POST['vs_visualsearch_front_number_of_product']);
            }

            if ((isset($_POST['vs_visualsearch_optradio']) && $_POST['vs_visualsearch_optradio'] != '')) {
                $vs_visualsearch_optradio = sanitize_text_field($_POST['vs_visualsearch_optradio']);
            }

            $loginfo = "Start :: Front Suggested Product :: Product Number " . $vs_visualsearch_front_number_of_product . " Product Showing From " . $vs_visualsearch_optradio;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);



            if ((isset($_POST['vs_visualsearch_front_number_of_product']) && $_POST['vs_visualsearch_front_number_of_product'] != '' ) && (isset($_POST['vs_visualsearch_optradio']) && $_POST['vs_visualsearch_optradio'] != '')) {


                if (get_option('vs_visualsearch_front_number_of_product')) {

                    update_option('vs_visualsearch_front_number_of_product', $vs_visualsearch_front_number_of_product);
                } else {
                    add_option('vs_visualsearch_front_number_of_product', $vs_visualsearch_front_number_of_product);
                }

                if (get_option('vs_visualsearch_front_showing_of_product')) {

                    update_option('vs_visualsearch_front_showing_of_product', $vs_visualsearch_optradio);
                } else {
                    add_option('vs_visualsearch_front_showing_of_product', $vs_visualsearch_optradio);
                }

                $vs_responseCode = 1;
                $vs_responseMessage = "Success!!! Suggested option updated successfully";
                $vs_responseMessageHtml = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Success!</strong> ' . $vs_responseMessage . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
            } else {
                $vs_responseCode = 0;
                $vs_responseMessage = "Error!!! When suggested option update";
                $vs_responseMessageHtml = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Info!</strong> No new product found</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
            }

            $rUrl = 'admin.php?page=vs-setting&settingtab=option-product-add-remove&settingMPTSubTabOpt=product-front-suggested&vs_response_code=' . $vs_responseCode . '&vs_response_msg=' . $vs_responseMessage;

            $loginfo = "End :: Front Suggested Product :: :: Url  " . $rUrl;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualsearch_new_product_add_form_save() {


        

        $homeDomain = get_option('vs_visualsearch_container');
        $vs_accelx_user = get_option('vs_visualsearch_accelx_user');
        $vs_accelx_pass = get_option('vs_visualsearch_accelx_pass');
        $vs_auth_token = get_option('vs_visualsearch_api_key');


       
        $commandFuncion = VISUALSEARCH__PLUGIN_ML_FN_ADD_PRODUCT;
        $commandFuncionRemove = VISUALSEARCH__PLUGIN_ML_FN_REMOVE_PRODUCT;
        $master_imagelist_file = VISUALSEARCH__PLUGIN_PYC_MASTER_PKL;
        $master_tv_tree_file = VISUALSEARCH__PLUGIN_PYC_TV_TREE;
        $ml_server_url_port = VISUALSEARCH__PLUGIN_ML_SERVER_URL;
        $ml_auth_user = get_option('vs_visualsearch_accelx_user');
        $ml_auth_token = get_option('vs_visualsearch_api_key');

        $test_tv_pkl = VISUALSEARCH__PLUGIN_MASTER_TV_PKL;
        $nComponents = VISUALSEARCH__PLUGIN_ML_FN_N_COMPONENTS;


        if (!isset($_POST['vs_visualsearch_new_product_add_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_new_product_add_of_nonce_field'], 'vs_visualsearch_new_product_add_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {




            if ((isset($_POST['vs_visualsearch_enable_product_number']) && $_POST['vs_visualsearch_enable_product_number'] != '')) {
                $vs_visualsearch_enable_product_number = sanitize_text_field($_POST['vs_visualsearch_enable_product_number']);
            }

            $loginfo = "Start :: Database Synce :: Enable Product  " . $vs_visualsearch_enable_product_number;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);





            $argsXforTotal = array(
                'paginate' => true,
            );
            $results = wc_get_products($argsXforTotal);
            $totalCurrentProductCounter = $results->total;

            $totalOldProductCount = get_option('vs_visualsearch_active_product_counter');



            $loginfo = "Start :: Database Synce :: Total current Product  " . $totalCurrentProductCounter . " Total prvious Product " . $totalOldProductCount;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            //previous array

            $oldActiveProductArray = unserialize(get_option('vs_visualsearch_active_product'));

            //current array

            $newActiveProductArray = array();



            $argsPart = array(
                'limit' => $totalCurrentProductCounter,
                'offset' => 0,
            );

            $vsgetProductsPart = wc_get_products($argsPart);

            foreach ($vsgetProductsPart as $vsgetproPart) {
                $vsproductID = $vsgetproPart->id;

                $newActiveProductArray[] = $vsproductID;
            }



            $vs_add_diff_productArray = array();
            $vs_add_diff_productArray = array_diff($newActiveProductArray, $oldActiveProductArray);


            $vs_rmv_diff_productArray = array();
            $vs_rmv_diff_productArray = array_diff($oldActiveProductArray, $newActiveProductArray);





            $addProCount = 0;
            $rmvProCount = 0;


            if (empty($vs_add_diff_productArray) && empty($vs_rmv_diff_productArray)) {
                // list is empty.
                //no new product found

                $vs_responseCode = 0;
                $vs_addrmproductCouter = "";
                $vs_addProCounter = "0";
                $vs_rmvProCounter = "0";
                $vs_responseMessage = "Not found new product";
                $vs_responseMessageHtml = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Info!</strong> No new product found</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
            } else {



                //add or remove product found

                if (!empty($vs_add_diff_productArray)) {
                    //add product command

                    $vsGetHomepath = get_home_path();

                    foreach ($vs_add_diff_productArray as $adProduct) {

                        $vsproductID = $adProduct;



                        $vspro = new WC_Product($vsproductID);




                        $vsgetProductImage = $vspro->get_image($size = 'shop_thumbnail');





                        $vsgetProductSku = $vspro->get_sku();
                        //  $vsimage_id = $vsgetpro->image_id;
                        $vsimage_id = $vspro->image_id;

                        //      echo "vsimage_id :: " . $vsimage_id."<br>";

                        $vsproductAttachment = wc_get_product_attachment_props($vsimage_id);



                        $vsfull_src = $vsproductAttachment['full_src'];

                        $vsFullSrcExplode = explode("uploads/", $vsfull_src);
                        $vsImgName1 = $vsFullSrcExplode[1];



                        //check jpeg or png image

                        if (preg_match('/(\.jpg|\.JPG|\.jpeg|\.JPEG|\.png|\.PNG)$/i', $vsImgName1)) {


                            $vs_upload_dir = wp_upload_dir();
                            $vs_upload_dir_Xn = $vs_upload_dir['basedir'];

                            $vsrealRootDirPathOfImage = $vs_upload_dir_Xn . '/' . $vsImgName1;

                            $vsSearchableName = $vsproductID . '||' . $vsrealRootDirPathOfImage;


                            $vs_NewProductID = $vsproductID;
                            //  $vs_NewProductSKU = $vsgetProductSku;
                            $vs_NewProductImageDirPath = $vsfull_src;



                            // $cmdX = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $master_imagelist_file . "' '" . $test_tv_pkl . "' '" . $master_tv_tree_file . "' '" . $vs_NewProductID . "' '" . $vs_NewProductSKU . "' '" . $vs_NewProductImageDirPath . "' " . $ml_server_url_port . " '" . $ml_auth_token . "' True  " . $nComponents . " " . "'|'";
                            // $cmdX = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $master_imagelist_file . "' '" . $test_tv_pkl . "' '" . $master_tv_tree_file . "' '" . $vs_NewProductID . "' '" . $vs_NewProductSKU . "' '" . $vs_NewProductImageDirPath . "' " . $ml_server_url_port . " '" . $ml_auth_token . "' True  " . $nComponents . " " . "'|'" . " " . $ml_auth_user;
                            //  $cmdX = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $master_imagelist_file . "' '" . $test_tv_pkl . "' '" . $master_tv_tree_file . "' '" . $vs_NewProductID . "' '' '" . $vs_NewProductImageDirPath . "' " . $ml_server_url_port . " '" . $ml_auth_token . "' True  " . $nComponents . " " . "'|'" . " " . $ml_auth_user;
                          //  $cmdX = $python . " '" . $scriptPath . "' '" . $commandFuncion . "' '" . $master_imagelist_file . "' '" . $test_tv_pkl . "' '" . $master_tv_tree_file . "' '" . $vs_NewProductID . "' '' '" . $vs_NewProductImageDirPath . "' " . $ml_server_url_port . " '" . $ml_auth_token . "' True  " . $nComponents . " " . "'|'" . " '" . $ml_auth_user . "' 'uploaded'";


                            $loginfo = "Database Synce :: Add Product IMAGE Path :: Command  " . $vs_NewProductImageDirPath;
                            VsOptionSetting::vs_visualSearchInstalllog($loginfo);


                            //     exit();

                            //$myCmdXOut = shell_exec("$cmdX 2>&1");

                            $url = VISUALSEARCH__PLUGIN_ML_FN_ADD_NEW_PRODUCT;
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
                                    'productId' => $vs_NewProductID,
                                    'imageUrl' => $vs_NewProductImageDirPath

                                ),
                                'cookies' => array()
                                    )
                            );


                            $loginfo = "Database Synce ::  Add Product :: response ::  " . response['body'];
                            VsOptionSetting::vs_visualSearchInstalllog($loginfo);
                        } else {
                            $loginfo = "Start :: Product Collecton :: Piture in not JPEG or PNG :: ProductID ::" . $vsproductID . " and Product Image Name:: " . $vsImgName1;
                            VsOptionSetting::vs_visualSearchInstalllog($loginfo);
                        }


                        $addProCount++;
                    }//end diff array loop
                }

                $loginfo = "Database Synce :: Product Add :: Counter ::  " . $addProCount;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);


                if (!empty($vs_rmv_diff_productArray)) {
                    //remove product command

                    $commandFuncionRemove = "remove_product";

                    foreach ($vs_rmv_diff_productArray as $rmProduct) {
                        $removeProductId = $rmProduct;

                        //  echo "hhh -> ::" . $removeProductId."<br>";

                        $loginfo = "Database Synce :: Product Remove :: product ID ::  " . $removeProductId;
                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);




                        $cmdX = $python . " '" . $scriptPath . "' '" . $commandFuncionRemove . "' '" . $master_imagelist_file . "' '" . $test_tv_pkl . "' '" . $master_tv_tree_file . "' '" . $removeProductId . "' True '|'";

                        $loginfo = "Database Synce :: Product Remove :: Command  " . $cmdX;
                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                        $url = VISUALSEARCH__PLUGIN_ML_FN_REMOVE_PRODUCT;
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
                                'productId' => $removeProductId
                            ),
                            'cookies' => array()
                                )
                        );
                        $loginfo = "Database Synce :: Product Remove :: response ::  " . $response['body'];
                        VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                        $rmvProCount++;
                    }
                }

                $loginfo = "Database Synce :: Product Remove :: Counter ::  " . $rmvProCount;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                //   End Remove
                //create new product txt after add/remove Opteration

                $vs_active_product_listN = array();

                $vsProductFileRm = VISUALSEARCH__PLUGIN_UPLOAD . '/vspyscript/vsproduct.txt';

                if (file_exists($vsProductFileRm)) {
                    wp_delete_file($vsProductFileRm);
                }

                $vsFolderDirXM = VISUALSEARCH__PLUGIN_UPLOAD . '/vspyscript/';
                $vsFileNameM = $vsFolderDirXM . 'vsproduct' . '.txt';


                $loginfo = "Database Synce :: After Generate Product Collecton :: and Total " . $totalCurrentProductCounter;
                VsOptionSetting::vs_visualSearchInstalllog($loginfo);

                $argsXforTotalAfterAddRmv = array(
                    'paginate' => true,
                );
                $resultsAfterAddRmv = wc_get_products($argsXforTotalAfterAddRmv);
                $totalProductCounterAfterAddRmv = $resultsAfterAddRmv->total;

                $argsPart = array(
                    'limit' => $totalProductCounterAfterAddRmv,
                    'offset' => 0,
                    'order' => 'ASC'
                );


                $vsgetProductsPart = wc_get_products($argsPart);

                foreach ($vsgetProductsPart as $vsgetproPart) {
                    $vsproductID = $vsgetproPart->id;

                    $vs_active_product_listN[] = $vsproductID;

                    $vsproductName = $vsgetproPart->name;

                    $vspro = new WC_Product($vsproductID);
                    $vsgetProductImage = $vspro->get_image($size = 'shop_thumbnail');

                    $vsgetProductSku = $vspro->get_sku();
                    $vsimage_id = $vsgetproPart->image_id;
                    $vsproductAttachment = wc_get_product_attachment_props($vsimage_id);

                    $vsfull_src = $vsproductAttachment['full_src'];

                    $vsFullSrcExplode = explode("uploads/", $vsfull_src);

                    $vsImgName1 = $vsFullSrcExplode[1];
                    $vs_upload_dir = wp_upload_dir();
                    $vs_upload_dir_Xn = $vs_upload_dir['basedir'];
                    $vsrealRootDirPathOfImage = $vs_upload_dir_Xn . '/' . $vsImgName1;


                    $vsSearchableName = $vsproductID . '|' . $vsgetProductSku . '|' . $vsrealRootDirPathOfImage;


                    if (file_exists($vsFileNameM)) {
                        $vsmyfileM = file_put_contents($vsFileNameM, $vsSearchableName . PHP_EOL, FILE_APPEND | LOCK_EX);
                    } else {
                        $vsmyfileM = fopen($vsFileNameM, "w") or die("Unable to open file!");
                        $vslogdata1XM = $vsSearchableName . "\r\n";
                        fwrite($vsmyfileM, $vslogdata1XM);
                    }


                    $vs_p_counter++;
                    $vs_b_f_counter++;
                }



                //update current product array
                $vs_visualsearch_active_productListN = serialize($vs_active_product_listN);
                update_option('vs_visualsearch_active_product', $vs_visualsearch_active_productListN);


                //update current product counter
                update_option('vs_visualsearch_active_product_counter', $totalProductCounterAfterAddRmv);



                $vs_responseCode = 1;
                $vs_addrmproductCouter = $rmProductCounter;
                $vs_addProCounter = $addProCount;
                $vs_rmvProCounter = $rmvProCount;
                $vs_responseMessage = "Database Sync Successfully";
                $vs_responseMessageHtml = '<div class="notice notice-info is-dismissible" style="background-color:#f9f9f9;"><p><strong>Success!</strong> ' . $vs_responseMessage . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
            }




            $rUrl = 'admin.php?page=vs-setting&settingtab=option-product-add-remove&settingMPTSubTabOpt=product-add&vs_response_code=' . $vs_responseCode . '&vs_addrmproductCouter=' . $vs_addrmproductCouter . '&vs_addProCounter=' . $vs_addProCounter . '&vs_rmvProCounter=' . $vs_rmvProCounter . '&vs_response_msg=' . $vs_responseMessage;

            $loginfo = "End :: New Product Add :: Url  " . $rUrl;
            VsOptionSetting::vs_visualSearchInstalllog($loginfo);

            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualsearch_install_log_form_save() {


        if (!isset($_POST['vs_visualsearch_install_log_of_nonce_field']) || !wp_verify_nonce($_POST['vs_visualsearch_install_log_of_nonce_field'], 'vs_visualsearch_install_log_of_my_action')) {
            print 'Sorry, your nonce did not verify.';
            exit;
        } else {

            if ((isset($_POST['vs_visualsearch_install_log_show']) && $_POST['vs_visualsearch_install_log_show'] != '')) {
                $vs_visualsearch_install_log_show = sanitize_text_field($_POST['vs_visualsearch_install_log_show']);
            } else {
                $vs_visualsearch_install_log_show = "iLogHide";
            }

            $rUrl = 'admin.php?page=vs-setting&settingtab=viewlog&settingVLSubTabOpt=' . $vs_visualsearch_install_log_show;
            wp_redirect(admin_url($rUrl));
        }
    }

    public function vs_visualsearch_setting_option_form_save() {
//  check_admin_referer("visualsearchsetting");
        check_admin_referer("vs_visualsearch_setting_option");
        if (isset($_POST['vs_visualsearch_api_key'])) {
            update_option('vs_visualsearch_api_key', sanitize_key($_POST['vs_visualsearch_api_key']));
        }
        if (isset($_POST['vs_visualsearch_close_image_percentage'])) {
            update_option('vs_visualsearch_close_image_percentage', sanitize_text_field($_POST['vs_visualsearch_close_image_percentage']));
        }
        if (isset($_POST['vs_visualsearch_uploaded_picture_delete_preiod'])) {
            update_option('vs_visualsearch_uploaded_picture_delete_preiod', sanitize_text_field($_POST['vs_visualsearch_uploaded_picture_delete_preiod']));
        }

//	wp_redirect('admin.php?page=optionsdemopage');
        wp_redirect(admin_url('admin.php?page=vs-setting'));
    }

}

new VsOptionSetting();
?>