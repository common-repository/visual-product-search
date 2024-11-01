<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<?php
get_header();
?>

<?php
if (get_query_var('vs_imageAddress')) {

    $searchImageAddress = get_query_var('vs_imageAddress');
} else {
    $searchImageAddress = '';
}

if (get_query_var('vs_query')) {
    $vs_querySearch = get_query_var('vs_query');
    $vs_querySearch1 = base64_decode($vs_querySearch);

    $vs_productArrayX = json_decode($vs_querySearch1);
}
?>





<!-- Start : image search result area-->
<div class="vs_search_img_view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <img src="<?php echo esc_url($searchImageAddress); ?>" class="vs-front-search-image-front-opt-mx-width299" alt=""/>

            </div>
        </div>
    </div>
</div>

<div class="vs_result_area">
    <div class="container">
        <div class="row">                        
            <div class="col-md-9">
                
                
                <div id="cover-spinAfterClick"></div>

                <h3>Search results:</h3>




                <?php
                if (is_object($vs_productArrayX)) {

                    
                    $vs_responseCode = $vs_productArrayX->vs_responseCode;
                    $vs_responseMessage = $vs_productArrayX->vs_responseMessage;
                    $vs_responseData = $vs_productArrayX->vs_responseData;
                    //print_r($vs_responseData);
                    ?>

                    <?php
                    if ($vs_responseCode == 1) {

                        $totalProduct = count($vs_responseData);
                        ?>
                        <p> Showing all <?php echo $totalProduct; ?> results</p>
                        <br>
                        <div class="row">

                            <?php
                            for ($n = 0; $n < $totalProduct; $n++) {

                                $vsproductID = $vs_responseData[$n];
                                $vspro = new WC_Product($vsproductID);

                                $vs_productName = $vspro->get_name();


                                $vs_getProductImage = $vspro->get_image($size = 'shop_thumbnail');


                                $vs_getProductSku = $vspro->get_sku();


                                $vs_getProductUrl = $vspro->get_permalink();


                                $vs_getProductPrice = $vspro->get_price_html();
                                ?>  
                                <div class="col-md-4 text-center">
                                    <a href="<?php echo $vs_getProductUrl; ?>"><?php echo $vs_getProductImage; ?></a>
                                    <a href="<?php echo $vs_getProductUrl; ?>"><h5><?php echo $vs_productName; ?></h5></a>
                                    <p><?php echo $vs_getProductPrice; ?></p>
                                    <a href="<?php echo $vs_getProductUrl; ?>" class="btn btn-info btn-sm vs_details_btn">View Details</a>


                                    <form action="<?php echo admin_url('admin-post.php') ?>" method="post" enctype="multipart/form-data" onsubmit="return vsCheckClickProductAfterSearchFromFront();">

                                        <input type="hidden" name="action" value="vs_visualsearch_front_apply_search_form">
                                        <?php
                                        wp_nonce_field("vs_visualsearch_front_apply_search");
                                        ?>

                                        <input type="hidden" value="<?php echo $vsproductID; ?>" name="vs_visualsearch_picture_apply_search">

                                        <button title="Search similar item" type="submit" id="vsImgUpbtn<?php echo $vsproductID; ?>" name="vsImgUpbtn" class="vs-qbi-apply-search"></button>

                                    </form>



                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    } else {
                        echo '<p "woocommerce-info">' . $vs_responseMessage . '</p>';
                    }
                } else {
                    echo '<p "woocommerce-info">No product found</p>';
                }
                ?>
            </div>

            <div class="col-md-3">

                <?php get_sidebar(); ?>

                <div class="recentComments vs_widget_tp_padding">
                    <p class="lead">Recent Comments</p><hr>
                </div>

                <div class="recentComments vs_widget_tp_padding">
                    <p class="lead">Archives</p><hr>
                </div>

                <div class="recentComments vs_widget_tp_padding">
                    <p class="lead">Categories</p><hr>
                    <p>No categories</p>
                </div>

                <div class="recentComments vs_widget_tp_padding">
                    <p class="lead">Meta</p><hr>
                    <ul class="vs_meta_list">
                        <li><a href="#">Site Admin</a></li>
                        <li><a href="#">Log out</a></li>
                        <li><a href="#">Entries RSS</a></li>
                        <li><a href="#">Comments RSS</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>            
<!-- End : image search result area-->
<?php get_footer(); ?>