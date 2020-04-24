<?php

/**
 * Renders inputs for product icons in WooCommerce product edit screen
 * 
 * @category Wordpress_Plugin
 * @package  Silverback_Product_Specification_Icons
 * @author   Werner C. Bessinger <dev@silverbackdev.co.za>
 * @license  Standard WordPress License
 * @link     none
 */
class SBSI_Back
{
    /**
     * Class init
     */
    public static function init()
    {
        // register js and css
        wp_register_style('sbsi_back', SBSI_URL . 'assets/css/back.css');
        wp_register_script('sbsi_back', SBSI_URL . 'assets/js/back.js', ['jquery'], '1.0.0', true);

        // ajax
        add_action('wp_ajax_saveIconsAjax', [__CLASS__, 'saveIconsAjax']);
        add_action('wp_ajax_nopriv_saveIconsAjax', [__CLASS__, 'saveIconsAjax']);

        // custom product tabs
        add_filter('woocommerce_product_data_tabs', [__CLASS__, 'sbsiProductTab']);
        add_action('woocommerce_product_data_panels', [__CLASS__, 'sbsiProductTabData']);
    }

    /**
     * Adds a custom tab for our icons to the product edit screen
     * @return $tabs
     */
    public static function sbsiProductTab($tabs)
    {
        $tabs['sbsi'] = [
            'label' => 'Specification Icons',
            'target' => 'sbsi_product_icons', //target div id, NOT callback function
            'class' => 'sbsi-prod-spec-icons',
            'priority' => 21
        ];

        return $tabs;
    }

    /**
     * Renders content for custom product tab as registered in sbsiProductTab
     */
    public static function sbsiProductTabData()
    {
?>
        <div id="sbsi_product_icons" class="panel woocommerce_options_panel hidden">

            <form id="sbsi_icon_form" action="" enctype="multipart/form-data">

                <label for="sbsi_icon_1"><?php echo __('Add icon', 'woocommerce'); ?></label>

                <input id="sbsi_icon_1" name="sbsi_icon_1" type="file">

                <button id="sbsi_add_icon" title="<?php echo __('Add icon') ?>">+</button>

                <br>

                <input id="sbsi_submit" class="button button-primary" type="submit" value="<?php echo __('Attach Icon(s)', 'woocommerce'); ?>">

            </form>

        </div>

<?php

        // enqueue js and css
        wp_enqueue_style('sbsi_back');
        wp_enqueue_script('sbsi_back');
    }

    /**
     * Save icons via ajax submission
     */
    public static function saveIconsAjax()
    {

        wp_die();
    }
}

SBSI_Back::init();
