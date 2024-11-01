<div id="vs-plugin-container vs-dash-r-padding15">
    <div id="vs-plugin-msg"></div>



    <div id="vs-plugin-header" class="vs-plugin-header">
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                    <img src="<?php echo VISUALSEARCH__PLUGIN_URL . 'assets/admin/images/ml_camera_icon.png'; ?>" alt="Accelx Visual Search" class="vs-dash-ml-camera-icon-setting" >

                </div>
                <div class="col-md-5">
                    <h2>Visual Search</h2>
                </div>

                <div class="col-md-5">
                    <ul class="nav nav-tabs vs-nav vs-nav-tabs">
                        <li class="btn-group btn-group-sm vs-btn-group ml-auto"> 
                            <a href="<?php echo admin_url('admin.php?page=vs-dashboard'); ?>" class="btn btn-primary">Dashboard</a>
                            <a href="<?php echo admin_url('admin.php?page=vs-setting'); ?>"  class="btn btn-primary active">Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <div id="vs-plugin-body">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="tab-content">
                        <div class="tab-pane container active" id="vs-plgdboard">
                            <div class="card vs-card vs-dash-l-padding15">
                                <div class="card-body vs-card-body">
                                    <ul class="nav nav-tabs vs-dboard-navtab">
                                        <li class="nav-item"><a class="nav-link vs-navlink active" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=options-setting'); ?>">Settings</a></li>
                                        <li class="nav-item"><a class="nav-link vs-navlink " href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=option-product-add-remove'); ?>">Manage Product</a></li>                                        
                                        <li class="nav-item"><a class="nav-link vs-navlink" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=viewlog'); ?>">Log</a></li>                                                                 
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane active" id="vs-optionSettingTab">

                                    <!--  start Accelx Credential-->                                        
                                    <div class="row" id="credtabXn">
                                        <div class="col-sm-12">
                                            <div id="accordion">
                                                <div class="card vs-accordion-card vs-card vs-margin-bottom-10 ">
                                                    <div class="card-header bg-primary text-white vs-setting-t-b-padding25rem">                                                            
                                                        Accelx <?php _e('Credential', 'visual-search'); ?>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row" style="padding-bottom: 10px;">
                                                            <div class="col-sm-12">
                                                                <?php
                                                                if (isset($_GET['credentialTabOpt'])) {

                                                                    $vs_responseCode = sanitize_key($_GET['vs_response_code']);

                                                                    if ($vs_responseCode == 20) {
                                                                        //  $vs_responseMsg = 'Token generated successfully';
                                                                        $vs_responseMsg = __('Token has been generated successfully', 'visual-search');
                                                                    } else {
                                                                        //   $vs_responseMsg = 'Worng username or password';
                                                                        $vs_responseMsg = __('Authentication failed. Invalid username or password. Try again with valid credentials', 'visual-search');
                                                                    }
                                                                    ?>
                                                                    <div class="notice notice-success is-dismissible"><p><?php _e($vs_responseMsg); ?>.</p></div>
                                                                <?php }; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div id="cover-spin"></div>

                                                            <div class="col-sm-6">
                                                                <form  method="post" action="<?php echo admin_url('admin-post.php') ?>" onsubmit="return vsCheckAccelxCredentialFromSetting();">
                                                                    <input type="hidden" name="action" value="vs_visualsearch_setting_accelx_credential_form">
                                                                    <?php
                                                                    wp_nonce_field('vs_visualsearch_accelx_credential_of_my_action', 'vs_visualsearch_accelx_credential_of_nonce_field');

                                                                    $vs_visualsearch_accelx_user = get_option('vs_visualsearch_accelx_user');
                                                                    $vs_visualsearch_accelx_pass = get_option('vs_visualsearch_accelx_pass');
                                                                    $vs_visualsearch_accelx_credential_set = get_option('vs_visualsearch_accelx_credential_set');
                                                                    if ($vs_visualsearch_accelx_credential_set == 1) {
                                                                        $vs_alx_btn_text = "Update";
                                                                        $vs_others_config_btn_enable_state1 = "";
                                                                    } else {
                                                                        $vs_alx_btn_text = "Save";
                                                                        $vs_others_config_btn_enable_state1 = " disabled";
                                                                    }
                                                                    ?>
                                                                    <div class="row">
                                                                        <label class="col-md-4 form-group control-label text-right" for="vs_visualsearch_accelx_user"><?php _e('Username', 'visual-search'); ?></label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" id="vs_visualsearch_accelx_user" name="vs_visualsearch_accelx_user" value="<?php echo esc_attr($vs_visualsearch_accelx_user); ?>" placeholder="<?php _e('Accelx Username', 'visual-search'); ?>" class="form-group form-control form-control-sm" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-md-4 form-group control-label text-right" for="vs_visualsearch_accelx_pass"><?php _e('Password', 'visual-search'); ?></label>
                                                                        <div class="col-md-8">
                                                                            <input type="password" id="vs_visualsearch_accelx_pass" name="vs_visualsearch_accelx_pass" value="<?php echo esc_attr($vs_visualsearch_accelx_pass); ?>" placeholder="<?php _e('Accelx Password', 'visual-search'); ?>" class="form-group form-control form-control-sm" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-8 offset-md-4">


                                                                            <input type="submit" name="vs_cred_submit" id="vs_cred_submit" class="button button-primary <?php echo $vs_others_config_btn_enable_state; ?>" value="<?php echo $vs_alx_btn_text; ?>" <?php echo $vs_others_config_btn_enable_state; ?>>

                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p>If you don't have an account please <a href="https://account.accelx.net/signup" target="_blank">sign up</a></p>
                                                            </div>
                                                        </div>
                                                        <!--  Start: Api Key Row-->
                                                        <div class="row vs-setting-t-padding10">

                                                            <div class="col-sm-12">

                                                                <form  method="post" action="<?php echo admin_url('admin-post.php') ?>">
                                                                    <input type="hidden" name="action" value="vs_visualsearch_setting_option_form">
                                                                    <?php
                                                                    wp_nonce_field("vs_visualsearch_setting_option");

                                                                    $vs_visualsearch_api_key = get_option('vs_visualsearch_api_key');

                                                                    $vs_visualsearch_close_image_percentage = get_option('vs_visualsearch_close_image_percentage');

                                                                    $vs_visualsearch_uploaded_picture_delete_preiod = get_option('vs_visualsearch_uploaded_picture_delete_preiod');

                                                                    $vs_visualsearch_setting_option_set = get_option('vs_visualsearch_setting_option_set');
                                                                    ?>


                                                                    <input type="hidden" id="vs_visualsearch_close_image_percentage" name="vs_visualsearch_close_image_percentage" value="<?php echo esc_attr($vs_visualsearch_close_image_percentage); ?>" placeholder="<?php _e('Show Close Image Percentage', 'visual-search'); ?>" class="form-group form-control form-control-sm" disabled/>
                                                                    <input type="hidden" id="vs_visualsearch_uploaded_picture_delete_preiod" name="vs_visualsearch_uploaded_picture_delete_preiod" value="<?php echo esc_attr($vs_visualsearch_uploaded_picture_delete_preiod); ?>" placeholder="<?php _e('Remove uploaded picture', 'visual-search'); ?>" class="form-group form-control form-control-sm" disabled/>
                                                                    <div class="row">
                                                                        <label class="col-md-2 form-group control-label text-right" for="visualsearch_api_key"><?php _e('API Key', 'visual-search'); ?></label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" id="vs_visualsearch_api_key" name="vs_visualsearch_api_key" value="<?php echo esc_attr($vs_visualsearch_api_key); ?>" placeholder="<?php _e('Accelx API Key', 'visual-search'); ?>" class="form-group form-control form-control-sm"  disabled/>
                                                                        </div>
                                                                    </div>


                                                                </form>
                                                            </div>

                                                        </div>
                                                        <!--  End: Api Key Row-->
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--  end Accelx Credential-->



                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordion">
                                                <div class="card vs-accordion-card vs-card vs-margin-bottom-10 ">
                                                    <div class="card-header bg-primary text-white vs-setting-t-b-padding25rem">
                                                        <?php _e('Configuration', 'visual-search'); ?>
                                                    </div>

                                                    <?php
                                                    //    $progressBarShown = 1;

                                                    $msgDiplayBoxShowOption = '';

                                                    if (isset($_GET['convMLTabOpt'])) {

                                                        if (isset($_GET['progressBarShown'])) {
                                                            $progressBarShown = sanitize_key($_GET['progressBarShown']);
                                                        } else {
                                                            $progressBarShown = 0;
                                                        }

                                                        if (isset($_GET['convMLSubTabOpt'])) {

                                                            $convMLSubTabOpt = sanitize_key($_GET['convMLSubTabOpt']);

                                                            if ($convMLSubTabOpt == 'product') {
                                                                $vs_responseCode = sanitize_key($_GET['vs_response_code']);

                                                                if ($vs_responseCode == 1) {
                                                                    $vs_responseMsg = __('Products are collected successfully', 'visual-search');
                                                                } elseif ($vs_responseCode == 0) {
                                                                    $vs_responseMsg = __('Error!!! Valid API KEY is required for Product Collection', 'visual-search');
                                                                } else {
                                                                    $vs_responseMsg = __('Error!!! When product image collection', 'visual-search');
                                                                }
                                                            }

                                                            if ($convMLSubTabOpt == 'handshake') {
                                                                $vs_responseCode = sanitize_key($_GET['vs_response_code']);

                                                                if ($vs_responseCode == 1) {
                                                                    $vs_responseMsg = __('Handshake with ML server is established', 'visual-search');
                                                                } elseif ($vs_responseCode == 0) {
                                                                    $vs_responseMsg = __('Error!!! Product Collection is required for Handshake with ML Server', 'visual-search');
                                                                } elseif ($vs_responseCode == 9) {
                                                                    $vs_responseMsg = __('Info !!! Already Handshake with ML server completed', 'visual-search');
                                                                } elseif ($vs_responseCode == 91) {
                                                                    $vs_responseMsg = __('Error!!! Valid API KEY is required for Handshake with ML Server', 'visual-search');
                                                                } else {
                                                                    $vs_responseMsg = __('Error!!! When Handshake with ML server ', 'visual-search');
                                                                }
                                                            }

                                                            if ($convMLSubTabOpt == 'image-Process-start') {
                                                                $vs_responseCode = sanitize_key($_GET['vs_response_code']);
                                                                if ($vs_responseCode == 1) {
                                                                    $vs_responseMsg = __('Product image conversion has already been started', 'visual-search');
                                                                } elseif ($vs_responseCode == 0) {
                                                                    $vs_responseMsg = __('Error!!! Handshake with ML Server is required for Product Image Conversion', 'visual-search');
                                                                } elseif ($vs_responseCode == 9) {
                                                                    $vs_responseMsg = __('Info !!! Already Start Product image conversion', 'visual-search');
                                                                } elseif ($vs_responseCode == 91) {
                                                                    $vs_responseMsg = __('Error!!! Valid API KEY is required for Product Image Conversion', 'visual-search');
                                                                } else {
                                                                    $vs_responseMsg = __('Error!!! When Product Image Conversion ', 'visual-search');
                                                                }
                                                            }

                                                            if ($convMLSubTabOpt == 'image-process') {
                                                                $vs_responseCode = sanitize_key($_GET['vs_response_code']);
                                                                $msgDiplayBoxShowOption = 'display:none';
                                                            }

                                                            if ($convMLSubTabOpt == 'del-config-opt') {
                                                                $vs_responseCode = sanitize_key($_GET['vs_response_code']);

                                                                if ($vs_responseCode == 1) {
                                                                    $vs_responseMsg = __('All configuration data has been removed successfully', 'visual-search');
                                                                } else {
                                                                    $vs_responseMsg = __('Error!!! When Remove configuration ', 'visual-search');
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <div class="row vs-setting-b-padding10" style="<?php echo $msgDiplayBoxShowOption; ?>">
                                                            <div class="col-sm-12" >
                                                                <div class="notice notice-success is-dismissible"><p id="vs_responce_code_message_from_server"><?php _e($vs_responseMsg); ?>.</p></div>
                                                            </div>
                                                        </div>
                                                    <?php }; ?>

                                                    <div class="card-body">



                                                        <div class="row">
                                                            <div class="col-sm-7">

                                                                <?php
                                                                $vs_visualsearch_setup_environmentVal = get_option('vs_visualsearch_setup_environment');
                                                                $vs_visualSearch_Configuration_StartVal = get_option('vs_visualSearch_Configuration_Start');
                                                                if ($vs_visualSearch_Configuration_StartVal == 1) {
                                                                    $vs_config_start_Btn = "btn btn-primary text-white disabled";
                                                                    $vs_config_remove_Btn = "btn btn-danger text-white";
                                                                    $vs_config_test_Btn = "btn btn-info text-white";
                                                                } else {
                                                                    $vs_config_start_Btn = "btn btn-warning text-white";
                                                                    $vs_config_remove_Btn = "btn btn-danger text-white disabled";
                                                                    $vs_config_test_Btn = "btn btn-info text-white disabled";
                                                                }

                                                                $vs_visualSearchProductCollecton_form_saveVal = get_option('vs_visualSearchProductCollecton_form_save');

                                                                $vs_visualsearch_accelx_credential_setValXn = get_option('vs_visualsearch_accelx_credential_set');

                                                                if ($vs_visualSearchProductCollecton_form_saveVal == 1 || $vs_visualsearch_accelx_credential_setValXn != 1) {
                                                                    $vs_btn_ProductCollecton = "disabled";
                                                                } else {
                                                                    $vs_btn_ProductCollecton = "";
                                                                }
                                                                ?>


                                                                <form  method="post" action="<?php echo admin_url('admin-post.php') ?>" onsubmit="return vsCheckAccelxCredentialFromSetting();">
                                                                    <input type="hidden" name="action" value="vs_visualSearchProductCollecton_form">
                                                                    <?php
                                                                    wp_nonce_field('vs_visualsearch_ProductCollecton_of_my_action', 'vs_visualsearch_ProductCollecton_of_nonce_field');
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-4 offset-md-2">
                                                                            <input type="submit" name="vs_ProductCollecton_submit" id="vs_ProductCollecton_submit" class="btn btn-primary btn-sm text-white <?php echo $vs_btn_ProductCollecton; ?>" value="Step-I :: Product Collection " <?php echo $vs_btn_ProductCollecton; ?>>

                                                                        </div>
                                                                    </div>
                                                                </form>


                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p class="text-info"><strong> Step |:</strong> List create from product database</p>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-7">
                                                                <?php
                                                                $vs_visualSearchHandshakeML_form_saveVal = get_option('vs_visualSearchHandshakeML_form_save');


                                                                if ($vs_visualSearchHandshakeML_form_saveVal == 1 || $vs_visualSearchProductCollecton_form_saveVal != 1 || $vs_visualsearch_accelx_credential_setValXn != 1) {
                                                                    $vs_btn_HandshakeXn = "disabled";
                                                                } else {
                                                                    $vs_btn_HandshakeXn = "";
                                                                }
                                                                ?>


                                                                <form  method="post" action="<?php echo admin_url('admin-post.php') ?>" onsubmit="return vsCheckAccelxCredentialFromSetting();">
                                                                    <input type="hidden" name="action" value="vs_visualSearchHandshakeML_form">
                                                                    <?php
                                                                    wp_nonce_field('vs_visualsearch_Handshake_of_my_action', 'vs_visualsearch_Handshake_of_nonce_field');
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-4 offset-md-2">
                                                                            <input type="submit" name="vs_handshake_submit" id="vs_handshake_submit" class="btn btn-primary btn-sm text-white <?php echo $vs_btn_HandshakeXn; ?>" value="Step-II :: Handshake with ML Server " <?php echo $vs_btn_HandshakeXn; ?>>

                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p class="text-info"><strong> Step ||:</strong>Credential verification with Machine leaning server</p>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-7">


                                                                <?php
                                                                $vs_visualSearchImageConversionStartVal = get_option('vs_visualSearchImageConversionStart');

                                                                if ($vs_visualSearchImageConversionStartVal == 2 || $vs_visualSearchHandshakeML_form_saveVal != 1 || $vs_visualSearchProductCollecton_form_saveVal != 1 || $vs_visualsearch_accelx_credential_setValXn != 1) {
                                                                    $vs_btn_ImageConversinStart = "disabled";
                                                                } else {
                                                                    $vs_btn_ImageConversinStart = "";
                                                                }
                                                                ?>

                                                                


                                                            </div>
                                                            <!-- <div class="col-sm-5">
                                                                <p class="text-info"><strong> Step |||:</strong>Product image assessment by Machine learning server</p>
                                                            </div> -->
                                                        </div>



                                                        <div class="row">
                                                            <div class="col-sm-7">


                                                                <?php
                                                                $vs_visualSearchImageConversionStartVal = get_option('vs_visualSearchImageConversionStart');

                                                                if ($vs_visualSearchImageConversionStartVal == 1 || $vs_visualSearchHandshakeML_form_saveVal != 1 || $vs_visualSearchProductCollecton_form_saveVal != 1 || $vs_visualsearch_accelx_credential_setValXn != 1) {
                                                                    $vs_btn_ImageConversinStart = "disabled";
                                                                } else {
                                                                    $vs_btn_ImageConversinStart = "";
                                                                }
                                                                
                                                                $totalActiveProductT = get_option('vs_visualsearch_active_product_counter');


                                                                ?>

                                                                <div class="row">
                                                                    <div class="col-md-10 offset-md-2">
                                                                        <button onclick="vs_visualSearchImageCoversionStart('<?php echo $totalActiveProductT;?>', '0');vs_visualSearchImageProgressBarStart('<?php echo $totalActiveProductT;?>', '0')" name="vs_visualSearchImageCoversionStartBtn" id="vs_visualSearchImageCoversionStartBtn" class="btn btn-primary btn-sm text-white  <?php echo $vs_btn_ImageConversinStart; ?>" style="cursor: pointer;">Step-III :: Product Image Conversion</button>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p class="text-info"><strong> Step |||:</strong>Product image assessment by Machine learning server</p>
                                                            </div>
                                                        </div>


                                                        <?php 
                                                        
                                                        //$progressBarTotalProcessCounter;  of //$totalProductCount;
                                                        ?>



                                                        <div class="row" id="vs_visualSearchImageConversionProgressBarCon" style="display: none;">
                                                            
                                                        </div>





                                                        <div class="row">
                                                            <div class="col-sm-7">


                                                                <div class="row vs-dash-t-b-padding10">
                                                                    <div class="col-sm-12">
                                                                        <form  method="post" action="<?php echo admin_url('admin-post.php') ?>" id="processForm">
                                                                            <input type="hidden" name="action" value="vs_visualsearch_process_form">
                                                                            <?php
                                                                            wp_nonce_field('vs_visualsearch_process_form_of_my_action', 'vs_visualsearch_process_form_of_nonce_field');

                                                                            $vs_visualsearch_procee_number = get_option('vs_visualSearchStepProcess_X');

                                                                            if ($vs_visualsearch_procee_number > 0) {
                                                                                $vs_alx_btn_text_process = "Process Starting " . $vs_visualsearch_procee_number;
                                                                                $vs_alx_btn_text_process1 = "";
                                                                            } else {
                                                                                $vs_alx_btn_text_process = "Process Complete";
                                                                                $vs_alx_btn_text_process1 = " disabled";
                                                                            }
                                                                            ?>

                                                                            <div class="row"> 
                                                                                <input type="hidden" id="vs_visualsearch_procee_number" name="vs_visualsearch_procee_number" value="<?php echo esc_attr($vs_visualsearch_procee_number); ?>"/>

                                                                                <div class="col-md-4 offset-md-2">
                                                                                    <input type="submit" name="vs_procee_submit" id="vs_procee_submit" class="btn btn-primary text-white vs-dash-setting-display-none <?php echo $vs_alx_btn_text_process1; ?>" value="<?php echo $vs_alx_btn_text_process; ?>" <?php echo $vs_alx_btn_text_process1; ?>>

                                                                                </div>
                                                                            </div>
                                                                        </form>


                                                                        <?php
                                                                        $argsX = array(
                                                                            'paginate' => true,
                                                                        );
                                                                        $results = wc_get_products($argsX);
                                                                        $totalProductCount = $results->total;



                                                                        $baseFactor = get_option('vs_visualsearch_product_picture_base_factor');
                                                                        if ($baseFactor == '') {
                                                                            $baseFactor = VISUALSEARCH__PLUGIN_PRODUCT_PICTURE_BASE_FACTOR;
                                                                        }

                                                                        $totalPage = ceil($totalProductCount / $baseFactor);
                                                                        $progressBarTextBelowCounter = $baseFactor * ($totalPage - $vs_visualsearch_procee_number);

                                                                        if ($vs_visualsearch_procee_number > 0) {
                                                                            $progressBarTextBelowCounter = $progressBarTextBelowCounter;
                                                                        } else {
                                                                            $progressBarTextBelowCounter = $totalProductCount;
                                                                        }

                                                                        $progressPercentage = ceil((($baseFactor * ($totalPage - $vs_visualsearch_procee_number)) / $totalProductCount) * 100);

                                                                        $productImageConversionStart = get_option('vs_visualSearchImageConversionStart');




                                                                        if ($productImageConversionStart == 1 || $progressBarShown == 1) {
                                                                            $progressBarDisplayCSS = "";
                                                                        } else {
                                                                            $progressBarDisplayCSS = 'style="display: none;"';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>





                                                                
                                                                <?php
                                                                if ($productImageConversionStart == 1) {
                                                                    if ($vs_visualsearch_procee_number > 0) {

                                                                        //echo '<script type="text/javascript">jQuery(function($){$( "#processForm" ).submit();});</script>';
                                                                    } else {


                                                                       // update_option('vs_visualSearchImageConversionStart', '2');
                                                                    }
                                                                }
                                                                ?>



                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--  end Configuration-->

                                    <?php
                                    $vs_visualsearch_process_configuration_deleteVal = get_option('vs_visualsearch_process_configuration_delete');
                                    if ($vs_visualsearch_process_configuration_deleteVal == 1) {
                                        ?>

                                        <!--  start Delete Configuration l-->                                        
                                        <div class="row" id="deletetabXn">
                                            <div class="col-sm-12">
                                                <div id="accordion">
                                                    <div class="card vs-accordion-card vs-card vs-margin-bottom-10 ">
                                                        <div class="card-header bg-primary text-white vs-setting-t-b-padding25rem">                                                            
                                                            <?php _e('Remove Configuration', 'visual-search'); ?>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="row vs-dash-t-b-padding10">
                                                                <div class="col-sm-2 offset-md-1">                                                                            

                                                                    <form  method="post" action="<?php echo admin_url('admin-post.php') ?>" onsubmit="return confirm('Do you want to delete configuration?');">
                                                                        <input type="hidden" name="action" value="vs_visualsearch_process_configuration_delete_form">
                                                                        <?php
                                                                        wp_nonce_field('vs_visualsearch_configuration_delete_of_my_action', 'vs_visualsearch_configuration_delete_of_nonce_field');
                                                                        ?>

                                                                        <input type="submit" name="vs_configuration_delete_submit" id="vs_configuration_delete_submit" class="btn btn-danger btn-sm text-white" value="Click here">

                                                                    </form>


                                                                </div>
                                                                <div class="col-sm-9">

                                                                    <p class="text-danger vs-setting-t-margin4rem">
                                                                        <strong>Warning!!!</strong> All configurations and settings will be deleted.
                                                                    <p>
                                                                </div>
                                                            </div>



                                                        </div>
                                                        <!--  end #accordion -->
                                                    </div>
                                                </div>
                                                <!--  end .card-body -->
                                            </div>
                                        </div>
                                        <!--  end Delete Configuration-->

                                    <?php } ?>


                                </div>
                            </div>
                            <!--  End #vs-optionsettingTab -->






                        </div>                                


                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="vs-plugin-footer"><hr class="vs-dash-m-bottom0">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <ul class="nav vs-footernav">
                        <li class="nav-item"><a class="nav-link" href="#">Visual Product Search Version 1.0.0</a>
                        <li class="nav-item"><a target="_blank" class="nav-link" href="https://www.accelx.net/term-condition.php">Terms</a>
                        <li class="nav-item"><a target="_blank" class="nav-link" href="https://www.accelx.net/privacy-policy.php">Privacy</a>
                    </ul> 
                </div>
            </div>
        </div>
    </div>
</div>  




