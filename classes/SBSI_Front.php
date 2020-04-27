<?php

/**
 * Renders product icons on product page
 */
class SBSI_Front
{

    /**
     * Init class   
     */
    public static function init()
    {

        add_filter('woocommerce_after_single_product', [__CLASS__, 'sbsiDisplayIcons']);

        wp_register_script('sbsi_front', SBSI_URL . 'assets/js/front.js', ['jquery'], '1.0.0', false);
        wp_register_style('sbsi_front', SBSI_URL . 'assets/css/front.css', [], '1.0.0', false);
    }

    public static function sbsiDisplayIcons()
    {
        // get product id
        $product_id = get_the_ID();

        // get icon meta
        $icon_meta = get_post_meta($product_id, 'sbsi_icons', true);

        // if icon meta is present, unserialize and display
        if ($icon_meta) : ?>
            <div id="sbsi_icon_div_front">
                <h1 class="product-page-subtitle"><?php echo __('Specifications', 'woocommerce'); ?></h1>
                <div id="sbsi_icon_img_cont" class="row large-columns-4 medium-columns-2 small-columns-1 row-small">
                    <?php
                    $icon_url_arr = unserialize($icon_meta);
                    foreach ($icon_url_arr as $icon_url) : ?>

                        <div class="col">
                            <div class="col-inner">
                                <img src="<?php echo $icon_url ?>">
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif;
        ?>
<?php
        wp_enqueue_script('sbsi_front');
        wp_enqueue_style('sbsi_front');
    }
}

SBSI_Front::init();
