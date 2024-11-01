
<div id="vs-plugin-container vs-dash-r-padding15">
    <div id="vs-plugin-msg"></div>



    <div id="vs-plugin-header" class="vs-plugin-header">
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                    <img  src="<?php echo VISUALSEARCH__PLUGIN_URL . 'assets/admin/images/ml_camera_icon.png'; ?>" alt="Accelx Visual Search" class="vs-dash-ml-camera-icon">

                </div>
                <div class="col-md-5">
                    <h2>Visual Search</h2>
                </div>

                <div class="col-md-5">
                    <ul class="nav nav-tabs vs-nav vs-nav-tabs vs-dash-r-padding15">
                        <li class="btn-group btn-group-sm vs-btn-group ml-auto"> 
                            <a href="#vs-plgdboard" data-toggle="tab" class="btn btn-primary active">Dashboard</a>
                            <a href="<?php echo admin_url('admin.php?page=vs-setting'); ?>" class="btn btn-primary">Settings</a>
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


                            <div class="tab-content">
                                <div class="tab-pane active" id="vs-ataglanceTab">

                                    <div class="card vs-card">
                                        <div class="card-body vs-card-body">
                                            <div class="row vs-dash-ai-powered-container">
                                                <div class="col-sm-1"></div>
                                                <div class="col-sm-10">

                                                    <h3>AI Powered Visual Search</h3>
                                                    <a href="http://accelx.net/" target="_blank" class="btn btn-primary vs-linkbtn">more details</a>


                                                </div>
                                            </div>


                                            <?php do_action('vs_visualsearch_subscription_statistics'); ?>



                                        </div>
                                        <!-- .card-body -->
                                    </div>
                                    <div class="card vs-card">
                                        <div class="card-body vs-card-body">
                                            <div class="row vs-dash-t-b-padding10">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <h5>We're here to help</h5>
                                                            <p>Visual Search comes with free email support for all users and additional support plan is also available.</p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <a href="https://www.accelx.net/#contact" class="btn btn-primary vs-linkbtn float-right">Ask a question</a>&emsp;
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <!-- End tab-pane #vs-ataglanceTab-->





                            </div>
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
                        <li class="nav-item"><a class="nav-link" href="#">Visual Search Version 1.0.0</a>
                        <li class="nav-item"><a target="_blank" class="nav-link" href="https://www.accelx.net/term-condition.php">Terms</a>
                        <li class="nav-item"><a target="_blank" class="nav-link" href="https://www.accelx.net/privacy-policy.php">Privacy</a>
                    </ul> 
                </div>
            </div>
        </div>
    </div>
</div>     






