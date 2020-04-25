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
     * 
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
     * 
     * @return html
     */
    public static function sbsiProductTabData()
    {
?>
        <div id="sbsi_product_icons" class="panel woocommerce_options_panel hidden">

            <form id="sbsi_icon_form" action="saveIconsAjax" enctype="multipart/form-data">

                <div id="sbsi_icon_div">
                    <span>
                        <label for="sbsi_icon">Select icon</label>
                        <input class="sbsi_icon" name="sbsi_icon" type="file">
                    </span>
                </div>

                <div id="sbsi_btn_cont">
                    <button id="sbsi_add_icon" class="button">
                        <?php echo __('Add another icon', 'woocommerce'); ?>
                    </button>
                    <input id="sbsi_submit" class="button button-primary" type="submit" value="<?php echo __('Attach Icon(s)', 'woocommerce'); ?>">
                </div>

            </form>
        </div>
<?php

        // enqueue js and css
        wp_enqueue_style('sbsi_back');
        wp_enqueue_script('sbsi_back');
    }

    /**
     * Save icons via ajax submission
     * 
     * @return success/failure
     */
    public static function saveIconsAjax()
    {
        if (isset($_POST)) :

            $target_dir = SBSI_PATH . 'uploads/';

            $file_name_arr = [];
            $file_url_arr = [];


            foreach ($_FILES as $key => $value) :
                $file_name_arr[] = $key;
            endforeach;

            foreach ($file_name_arr as $file_name) :

                $target_file = $target_dir . basename($_FILES[$file_name]["name"]);

                if (move_uploaded_file($_FILES[$file_name]["tmp_name"], $target_file)) {
                    echo "The file " . basename($_FILES[$file_name]["name"]) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }

            endforeach;
        endif;
        wp_die();
    }
} 

SBSI_Back::init();
