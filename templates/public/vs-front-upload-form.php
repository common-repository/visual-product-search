<div class="modal fade vsFormModalzIndex" id="vsFormModal" data-backdrop=""> <!-- The Modal -->
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header vsFrmModalHearderPaddig">
                <h5 class="modal-title vsFrmModalTitle"></h5>
                <a class="close" data-dismiss="modal">&times;</a>
            </div>

            <!-- Modal body -->
            <div class="modal-body vsFrmModalBodyPadding">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#imgupload">Upload an Image</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#imgurl">Paste Image URL</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane vs-tab-pane active container" id="imgupload">

                        <div id="cover-spin"></div>


                        <form class="vs-upimgform" action="<?php echo admin_url('admin-post.php') ?>" method="post" enctype="multipart/form-data" onsubmit="return vsCheckUplaodProductFromFront();">

                            <input type="hidden" name="action" value="vs_visualsearch_front_upload_picture_form">
                            <?php
                            wp_nonce_field("vs_visualsearch_front_upload");
                            ?>
                            <div class="row">
                                <div class="col-sm-8 vs-front-frm-r-padding0">
                                    <div class="form-group vsFormModalFormGroupBottomMargin">
                                        <input type="file"  name="vs_visualsearch_upload_picture" id="vs_visualsearch_upload_picture" required>
                                        <input id="inp_img" name="img" type="hidden" value="">
                                    </div>
                                    <span id="vs_visualsearch_upload_pictureErr"></span>
                                </div>
                                <div class="col-sm-4 vs-front-frm-l-padding0">
                                    <button type="submit" class="btn btn-primary vs-front-frm-t-b-l-r-padding3-75rem" id="vsImgUpbtn" name="vsImgUpbtn">
                                        <img  title="Search By Upload Image" src="<?php echo VISUALSEARCH__ASSETS_DIR; ?>public/images/ml_camera_icon_w.png" class="vs-front-from-ml-icon-mx-width" />

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane vs-tab-pane container" id="imgurl">


                        <div id="cover-spinURL"></div>

                        <form class="vs-upimgform" action="<?php echo admin_url('admin-post.php') ?>" method="post" enctype="multipart/form-data" onsubmit="return vsCheckURLProductFromFront();">
                            <input type="hidden" name="action" value="vs_visualsearch_front_picture_url_form">
                            <?php
                            wp_nonce_field("vs_visualsearch_front_picture_url");
                            ?>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group vsFormModalFormGroupBottomMargin">
                                        <input type="text" name="vs_visualsearch_upload_url" id="vs_visualsearch_upload_url" class="form-control" placeholder="Image URL" required>
                                    </div>
                                    <span id="vs_visualsearch_upload_urlErr"></span>
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary vs-front-frm-t-b-l-r-padding4-75rem" id="vsUrlUpBtn" name="vsUrlUpBtn">
                                        <img  title="Search By URL Image" src="<?php echo VISUALSEARCH__ASSETS_DIR; ?>public/images/ml_camera_icon_w.png" class="vs-front-from-ml-icon-mx-width-flex" />
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="tab-content1">
                    <p class="vs-title-front-suggested"><strong>Suggested Product Search</strong></p>
                    <hr class="vsFormModalHrMargin">
                    <ul class="vs_recentProductContainer">

                        <div id="cover-spinClick"></div>
                        <?php
                        $vs_visualsearch_front_number_of_product = get_option('vs_visualsearch_front_number_of_product');

                        if ($vs_visualsearch_front_number_of_product == '') {
                            $vs_visualsearch_front_number_of_product = VISUALSEARCH__PLUGIN_FRONT_SHOWING_PRODUCT_NUMBER;
                        }

                        $vs_visualsearch_front_showing_of_product = get_option('vs_visualsearch_front_showing_of_product');
                        if ($vs_visualsearch_front_showing_of_product == '') {
                            $vs_visualsearch_front_showing_of_product = VISUALSEARCH__PLUGIN_FRONT_SHOWING_PRODUCT_FROM;
                        }

                        if ($vs_visualsearch_front_showing_of_product == "latest") {
                            $argsX = array(
                                'limit' => $vs_visualsearch_front_number_of_product,
                                'orderby' => 'modified',
                                'order' => 'DESC',
                            );
                        }

                        if ($vs_visualsearch_front_showing_of_product == "random") {

                            $argsX = array(
                                'limit' => $vs_visualsearch_front_number_of_product,
                                'orderby' => 'rand',
                            );
                        }

                        if ($vs_visualsearch_front_showing_of_product == "bestselling") {



                            $argsX = array(
                                'limit' => $vs_visualsearch_front_number_of_product,
                                'meta_key' => 'total_sales', // our custom query meta_key                                
                                'orderby' => array('meta_value_num' => 'DESC', 'title' => 'ASC'), // order from highest to lowest of top sellers
                            );
                        }



                        $vsgetProducts = wc_get_products($argsX);

                        if ($vsgetProducts) {

                            $vsproincreament = 1;



                            $vs_active_product_list = array();
                            $vs_p_counter = 1;
                            foreach ($vsgetProducts as $vsgetpro) {
                                $vsproductID = $vsgetpro->id;

                                $vspro = new WC_Product($vsproductID);
                                $vsgetProductImage = $vspro->get_image($size = 'shop_thumbnail');
                                ?>
                                <li>

                                    <form action="<?php echo admin_url('admin-post.php') ?>" method="post" enctype="multipart/form-data" onsubmit="return vsCheckClickProductFromFront();">

                                        <input type="hidden" name="action" value="vs_visualsearch_front_apply_search_form">
        <?php
        wp_nonce_field("vs_visualsearch_front_apply_search");
        ?>

                                        <input type="hidden" value="<?php echo $vsproductID; ?>" name="vs_visualsearch_picture_apply_search">

                                        <?php echo $vsgetProductImage; ?>
                                        <button title="Search similar item" type="submit" id="vsImgUpbtn<?php echo $vsproductID; ?>" name="vsImgUpbtn" class="qbi-apply-search1 vsFrmModalSuggestedSearchImagePadding">
                                            <span class="vs_fron_pro_icon"><image src="<?php echo VISUALSEARCH__ASSETS_DIR; ?>public/images/ml_camera_icon.png" alt="Search similer product" > </span>
                                        </button>

                                    </form>
                                </li>
        <?php
    }
}
?>

                    </ul>

                </div>
            </div>

            <p class="vsFrmModalBottomAcclexText">Powered by <a href="https://www.accelx.net/" target="_blank"><img class="vs-front-from-ml-icon-logo-width" src="<?php echo VISUALSEARCH__ASSETS_PUBLIC_DIR; ?>/images/accelx_logo.png" alt="Accelx"></a></p>
        </div>
    </div>
</div><!-- End .The Modal -->

