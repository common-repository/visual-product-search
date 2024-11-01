<div id="vs-plugin-container vs-dash-r-padding15">
    <div id="vs-plugin-msg"></div>



    <div id="vs-plugin-header" class="vs-plugin-header">
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                    <img src="<?php echo VISUALSEARCH__PLUGIN_URL . 'assets/admin/images/ml_camera_icon.png'; ?>" alt="Accelx Visual Search" style="width:58px;">

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
                                        <li class="nav-item"><a class="nav-link vs-navlink" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=options-setting'); ?>">Settings</a></li>
                                        <li class="nav-item"><a class="nav-link vs-navlink active" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=option-product-add-remove'); ?>">Manage Product</a></li>                                             
                                        <li class="nav-item"><a class="nav-link vs-navlink" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=viewlog'); ?>">Log</a></li>                                                       
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane active" id="vs-optionProductAddRemoveTab">


                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordion">
                                                <div class="card vs-accordion-card vs-card vs-margin-bottom-10 ">
                                                    <div class="card-header bg-primary text-white vs-setting-t-b-padding25rem">                                                            
                                                        <?php _e('Front Suggested Product', 'visual-search'); ?>
                                                    </div>
                                                    <div class="card-body">


                                                        <?php
                                                        global $wpdb;

                                                        $vs_visualsearch_process_configuration_deleteVal = get_option('vs_visualsearch_process_configuration_delete');
                                                        
                                                        ?>

                                                        <?php
                                                        $msgDiplayBoxShowOptMPT01 = ' display:none';
                                                        if (isset($_GET['settingtab'])) {
                                                            
                                                            $settingMPTSubTabOpt = sanitize_key($_GET['settingMPTSubTabOpt']);
                                                            
                                                            if ($settingMPTSubTabOpt == 'product-front-suggested') {
                                                                
                                                                $vs_responseCode = sanitize_key($_GET['vs_response_code']);
                                                                
                                                                if ($vs_responseCode == 1) {
                                                                    $vs_responseMsg = __('Product type and number of product has been changed', 'visual-search');
                                                                } else {
                                                                    $vs_responseMsg = __('Error!!! When suggested option update', 'visual-search');
                                                                }

                                                                $msgDiplayBoxShowOptMPT01 = '';
                                                            }
                                                            ?>
                                                            <div class="row vs-setting-b-padding10" style="<?php echo $msgDiplayBoxShowOptMPT01; ?>">
                                                                <div class="col-sm-12">
                                                                    <div class="notice notice-success is-dismissible"><p><?php _e($vs_responseMsg); ?>.</p></div>
                                                                </div>
                                                            </div>
                                                        <?php }; ?>

                                                        <div class="row">
                                                            <div class="col-sm-7">                                                              

                                                                <form  method="post" action="<?php echo admin_url('admin-post.php') ?>">
                                                                    <input type="hidden" name="action" value="vs_visualsearch_setting_front_suggested_product_form">
                                                                    <?php
                                                                    wp_nonce_field('vs_visualsearch_front_suggested_product_of_my_action', 'vs_visualsearch_front_suggested_product_of_nonce_field');

                                                                    $vs_visualsearch_front_number_of_product = get_option('vs_visualsearch_front_number_of_product');

                                                                    if ($vs_visualsearch_front_number_of_product == '') {
                                                                        $vs_visualsearch_front_number_of_product = VISUALSEARCH__PLUGIN_FRONT_SHOWING_PRODUCT_NUMBER;
                                                                    }


                                                                    $vs_visualsearch_front_showing_of_product = get_option('vs_visualsearch_front_showing_of_product');
                                                                    if ($vs_visualsearch_front_showing_of_product == '') {
                                                                        $vs_visualsearch_front_showing_of_product = VISUALSEARCH__PLUGIN_FRONT_SHOWING_PRODUCT_FROM;
                                                                    }


                                                                    if ($vs_visualsearch_front_number_of_product == 4) {
                                                                        $vsProductNumberSelected4 = " selected";
                                                                    } else {
                                                                        $vsProductNumberSelected4 = "";
                                                                    }
                                                                    if ($vs_visualsearch_front_number_of_product == 8) {
                                                                        $vsProductNumberSelected8 = " selected";
                                                                    } else {
                                                                        $vsProductNumberSelected8 = "";
                                                                    }
                                                                    if ($vs_visualsearch_front_number_of_product == 12) {
                                                                        $vsProductNumberSelected12 = " selected";
                                                                    } else {
                                                                        $vsProductNumberSelected12 = "";
                                                                    }
                                                                    if ($vs_visualsearch_front_number_of_product == 16) {
                                                                        $vsProductNumberSelected16 = " selected";
                                                                    } else {
                                                                        $vsProductNumberSelected16 = "";
                                                                    }


                                                                    if ($vs_visualsearch_front_showing_of_product == "latest") {
                                                                        $vsFromShowingCheckedLatest = " checked";
                                                                    } else {
                                                                        $vsFromShowingCheckedLatest = "";
                                                                    }

                                                                    if ($vs_visualsearch_front_showing_of_product == "random") {
                                                                        $vsFromShowingCheckedRandom = " checked";
                                                                    } else {
                                                                        $vsFromShowingCheckedRandom = "";
                                                                    }

                                                                    if ($vs_visualsearch_front_showing_of_product == "bestselling") {
                                                                        $vsFromShowingCheckedBest = " checked";
                                                                    } else {
                                                                        $vsFromShowingCheckedBest = "";
                                                                    }
                                                                    ?>
                                                                    <div class="row form-group">
                                                                        <label class="col-md-4 control-label text-right vs-setting-r-padding0" for="vs_visualsearch_number_of_product" ><?php _e('Number of Product', 'visual-search'); ?></label>
                                                                        <div class="col-md-4 vs-setting-r-padding0">                                                                            
                                                                            <select id="vs_visualsearch_front_number_of_product" name="vs_visualsearch_front_number_of_product" class="form-group form-control form-control-sm">
                                                                                <option value="4" <?php echo $vsProductNumberSelected4; ?>>4</option>
                                                                                <option value="8" <?php echo $vsProductNumberSelected8; ?>>8</option>
                                                                                <option value="12" <?php echo $vsProductNumberSelected12; ?>>12</option>
                                                                                <option value="16" <?php echo $vsProductNumberSelected16; ?>>16</option>
                                                                            </select>
                                                                            <span id="errVSSearchNbrProduct"></span>

                                                                        </div>
                                                                    </div>

                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p class="text-info">Number of products to be shown in front modal view when visual search is used</p>                                                                 
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-7">                                                              


                                                                <div class="row form-group">
                                                                    <label class="col-md-4 control-label text-right vs-setting-r-padding0" for="vs_visualsearch_front_number_of_product"><?php _e('Product Show', 'visual-search'); ?></label>
                                                                    <div class="col-md-8 vs-setting-r-padding0"> 

                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="vs_visualsearch_optradio" value="latest" <?php echo $vsFromShowingCheckedLatest; ?>>
                                                                            Latest
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="vs_visualsearch_optradio"  value="random" <?php echo $vsFromShowingCheckedRandom; ?>> 
                                                                            Random
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="vs_visualsearch_optradio" value="bestselling"  <?php echo $vsFromShowingCheckedBest;?>>
                                                                            Best Selling
                                                                        </label>

                                                                        <span id="errVSSearchNbrShowing"></span>

                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-8 offset-md-4">
                                                                        <input type="submit" name="vs_front_of_product_submit" id="vs_front_of_product_submit" class="button button-primary" value="Update">

                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <p class="text-info">Type of products to be shown in front modal view when visual search is used.</p>                                                                 
                                                            </div>
                                                        </div>




                                                    </div>
                                                    <!-- card body -->
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <!--  end Front Suggested Product -->


                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="accordion">
                                                <div class="card vs-accordion-card vs-card vs-margin-bottom-10 ">
                                                    <div class="card-header bg-primary text-white vs-setting-t-b-padding25rem">                                                            
                                                        <?php _e('Add/Remove Product', 'visual-search'); ?>
                                                    </div>

                                                    <div class="card-body">

                                                        <?php
                                                        global $wpdb;

                                                        $vs_visualsearch_process_configuration_deleteVal = get_option('vs_visualsearch_process_configuration_delete');
                                                        if ($vs_visualsearch_process_configuration_deleteVal == 1) {
                                                            
                                                        }
                                                        ?>

                                                        <?php
                                                        $msgDiplayBoxShowOptionMPT = ' display:none';

                                                        if (isset($_GET['settingtab'])) {


                                                            $settingMPTSubTabOpt = sanitize_key($_GET['settingMPTSubTabOpt']);

                                                            if ($settingMPTSubTabOpt == 'productAdd') {
                                                                $vs_responseCode = sanitize_key($_GET['vs_response_code']);
                                                                $vs_addrmproductCouter = sanitize_key($_GET['vs_addrmproductCouter']);
                                                                if ($vs_responseCode == 1) {
                                                                    $vs_responseMsg = __('Success!!! ' . $vs_addrmproductCouter . '  product sync successfully', 'visual-search');
                                                                } elseif ($vs_responseCode == 2) {
                                                                    $vs_responseMsg = __('Success!!! ' . $vs_addrmproductCouter . ' product remove successfully', 'visual-search');
                                                                } else {
                                                                    $vs_responseMsg = __('No new product has been added after last sync', 'visual-search');
                                                                }

                                                                $msgDiplayBoxShowOptionMPT = '';
                                                            }
                                                            ?>
                                                            <div class="row vs-setting-b-padding10" style="<?php echo $msgDiplayBoxShowOptionMPT; ?>">
                                                                <div class="col-sm-12">
                                                                    <div class="notice notice-success is-dismissible"><p><?php _e($vs_responseMsg); ?>.</p></div>
                                                                </div>
                                                            </div>
                                                        <?php }; ?>


                                                        <div class="row vs-dash-t-b-padding10">


                                                            <div class="col-md-2 offset-md-1">

                                                                <?php
                                                                $totalActiveProductCountForManageProduct = get_option('vs_visualsearch_active_product_counter');
                                                                ?>



                                                                <form  method="post" action="<?php echo admin_url('admin-post.php') ?>" id="processForm">
                                                                    <input type="hidden" name="action" value="vs_visualsearch_new_product_add_form">
                                                                    <?php
                                                                    wp_nonce_field('vs_visualsearch_new_product_add_of_my_action', 'vs_visualsearch_new_product_add_of_nonce_field');
                                                                    ?>


                                                                    <input type="hidden" id="vs_visualsearch_remove_product_number" name="vs_visualsearch_remove_product_number" value="<?php echo esc_attr($vs_linecount); ?>"/>


                                                                    <input type="submit" name="vs_remove_product_submit" id="vs_remove_product_submit" class="btn btn-primary btn-sm text-white " value="Sync Database"/>


                                                                </form>

                                                            </div>
                                                            <div class="col-md-9">
                                                                <p class="text-info"><strong>1.Add a new product:</strong> first add the new product in the e-Commerce database then click this button. 
                                                                    <br/><strong>2.Remove a product : </strong>first remove a product in e-Commerce database then click this button.</p>
                                                            </div>
                                                        </div>





                                                    </div>
                                                    <!-- end card Body-->
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <!--  end Product Add Remove Option-->

                                </div>
                                <!--  End #vs-optionProductAddRemoveTab -->

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

    
