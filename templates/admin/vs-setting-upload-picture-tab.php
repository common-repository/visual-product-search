<div id="vs-plugin-container vs-dash-r-padding15">
    <div id="vs-plugin-msg"></div>



    <div id="vs-plugin-header" class="vs-plugin-header">
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                    <img src="<?php echo VISUALSEARCH__PLUGIN_URL . 'assets/admin/images/accelx_logo.png'; ?>" class="vs-dash-ml-camera-icon-setting" alt="Accelx">

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
                                        <li class="nav-item"><a class="nav-link vs-navlink " href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=option-product-add-remove'); ?>">Manage Product</a></li>
                                        <li class="nav-item"><a class="nav-link vs-navlink active" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=uploadpicture'); ?>">Uploaded Picture</a></li>      
                                        <li class="nav-item"><a class="nav-link vs-navlink" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=viewlog'); ?>">Log</a></li>                                                       
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane active" id="vs-showUpload-pictureTab">
                                    <div class="card vs-card">
                                        <div class="card-body vs-card-body">
                                            <?php
                                            //   $dir = "/images/";
                                            $dir = VISUALSEARCH__PLUGIN_DIR . 'searchpictureuploads/';

                                            // Sort in ascending order - this is default
                                            //   $a = scandir($dir);
                                            // Sort in descending order
                                            $vs_up_pic_desc = scandir($dir, 1);
                                            ?>
                                            <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                                                <?php
                                                

                                                $vspic = 1;
                                                $vs_up_picStr = '';
                                                foreach ($vs_up_pic_desc AS $vs_pic) {

                                                    if (strlen($vs_pic) > 10) {



                                                        $vs_uploadImageLinkX = VISUALSEARCH__PLUGIN_URL . 'searchpictureuploads/' . $vs_pic;

                                                        $vs_uploadImageLinkXz = VISUALSEARCH__PLUGIN_DIR . 'searchpictureuploads/' . $vs_pic;

                                                        $vs_del_arg = "'" . $vspic . "','" . $vs_pic . "','" . $vs_uploadImageLinkX . "'";

                                                        $vs_up_picStr .= '<div class="col-sm-3" id="vs_up_row' . $vspic . '">
                                                        <div class="card">
                                                            <img class="card-img-top vs-setting-up-picture-opt" src="' . $vs_uploadImageLinkX . '">
                                                            <div class="card-body">
                                                                <a onclick="vs_visualSearchSettingsUploadPictureDelete(' . $vs_del_arg . ');" class="btn btn-primary btn-sm text-white" id="vs_visualSearchSettingsUploadPictureDeleteBtn' . $vspic . '">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>';


                                                        if (($vspic % 4) == 0) {
                                                            $vs_up_picStr .= '</div><div class="row vs-setting-b-padding10">';
                                                        }
                                                    }
                                                    $vspic++;
                                                }
                                                echo $vs_up_picStr;
                                                ?>


                                            </div>

                                        </div>
                                    </div>                                    
                                </div>
                                <!--  End #vs-showUpload-pictureTab -->

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




