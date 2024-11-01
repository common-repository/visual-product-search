<div id="vs-plugin-container vs-dash-r-padding15">
    <div id="vs-plugin-msg"></div>



    <div id="vs-plugin-header" class="vs-plugin-header">
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                    <img class="vs-dash-ml-camera-icon-setting" src="<?php echo VISUALSEARCH__PLUGIN_URL . 'assets/admin/images/ml_camera_icon.png'; ?>" alt="Accelx Visual Search">

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
                                        <li class="nav-item"><a class="nav-link vs-navlink active" href="<?php echo admin_url('admin.php?page=vs-setting&settingtab=viewlog'); ?>">Log</a></li>                                          
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane active" id="vs-showUpload-pictureTab">
                                    <div class="card vs-card">
                                        <div class="card-body vs-card-body">

                                            <div class="row vs-dash-t-b-padding5-10" id="installLogContainer">
                                                <div class="col-sm-12">
                                                    <div class="card vs-card vs-setting-up-p-m-padding0-maring0">
                                                        <div class="card-header bg-primary text-white vs-setting-t-b-padding25rem">                                                            
                                                            <?php _e('Log details', 'visual-search'); ?>                                                            
                                                        </div>
                                                        <div class="card-body vs-card-body vs-setting-up-p-h-o-bg-paddingmaring0">
                                                            <?php
                                                            $vsInstallLogTxt1 = VISUALSEARCH__PLUGIN_UPLOAD . '/vspyscript/installlog.txt';
                                                           echo $vsInstallLogTxt1;
                                                            if (file_exists($vsInstallLogTxt1)) {
                                                                $file_lines = file($vsInstallLogTxt1);
                                                                $file_lines = array_reverse($file_lines);
                                                                foreach ($file_lines as $line) {
                                                                    echo '<p class="vs-setting-up-front-color">' . $line . '</p>';
                                                                }
                                                            } else {
                                                                echo '<p class="vs-setting-up-front-color">log file not found<p>';
                                                            }
                                                            ?>
                                                        </div>                                                            
                                                    </div>
                                                </div>
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




