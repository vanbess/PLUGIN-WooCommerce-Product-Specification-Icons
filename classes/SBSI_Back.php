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

        // get attached icons
        $attached_icons = get_post_meta($_GET['post'], 'sbsi_icons', true);

        if ($attached_icons) :
            $icon_url_arr = unserialize($attached_icons);
        endif;
?>
        <div id="sbsi_product_icons" class="panel woocommerce_options_panel hidden">

            <?php
            if ($icon_url_arr && is_array($icon_url_arr) || is_object($icon_url_arr)) :
                foreach ($icon_url_arr as $icon_url) : ?>
                    <div class="sbsi_icon_img_cont">
                        <a class="sbsi_del_icon" href="javascript:void(0);" title="<?php echo __('Remove icon', 'woocommerce'); ?>">x</a>
                        <img class="sbsi_icon_img" src="<?php echo $icon_url; ?>" alt="">
                    </div>
            <?php endforeach;
            endif;
            ?>

            <form id="sbsi_icon_form" action="saveIconsAjax" enctype="multipart/form-data">

                <div id="sbsi_icon_div">
                    <span class="sbsi_icon_span">
                        <label for="sbsi_icon">Select icon</label>
                        <input class="sbsi_icon" name="sbsi_icon" type="file">
                    </span>
                </div>

                <div id="sbsi_btn_cont">
                    <button id="sbsi_add_icon" class="button">
                        <?php echo __('Add another icon', 'woocommerce'); ?>
                    </button>
                    <input type="hidden" name="product_id" value="<?php echo $_GET['post'] ?>">
                    <input id="sbsi_submit" class="button button-primary" type="submit" value="<?php echo __('Attach Icon(s)', 'woocommerce'); ?>">
                    <button id="sbsi_del_icons" class="button" title="<?php echo __('Delete all icons/images', 'woocommerce'); ?>">
                        <?php echo __('Delete all', 'woocommerce'); ?>
                    </button>
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

            // get product id
            $product_id = $_POST['product_id'];

            // get wp upload directory path and urls
            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['path'] . '/';
            $target_url = $upload_dir['url'] . '/';

            // file name and url arrays
            $file_name_arr = [];
            $file_url_arr = [];
            $files_moved_arr = [];

            // loop through $_FILES to get file name and push to file name array
            foreach ($_FILES as $key => $value) :
                $file_name_arr[] = $key;
            endforeach;

            $file_count = 0;

            // loop through file name array and insert uploaded files one by one
            foreach ($file_name_arr as $file_name) :

                $target_file = $target_dir . basename($_FILES[$file_name]["name"]);

                // define file url and push to file url array
                $file_url_arr[] = $target_url . basename($_FILES[$file_name]["name"]);

                // move uploaded files
                $files_moved_arr[$file_name] = move_uploaded_file($_FILES[$file_name]["tmp_name"], $target_file);

                $file_count++;

            endforeach;

            // check if files were moved successfully by getting files moved count and comparing to submitted file count
            $files_moved_count = count($files_moved_arr);

            if ($files_moved_count == $file_count) :

                $urls_serialized = serialize($file_url_arr);

                if ($urls_serialized) :

                    $icons_attached = update_post_meta($product_id, 'sbsi_icons', $urls_serialized);

                    if ($icons_attached) :
                        echo __('Icons successfully attached.', 'woocommerce');
                    endif;

                endif;
            else :
                echo __('File upload failed. Please try again.', 'woocommerce');
            endif;

        endif;
        wp_die();
    }

    /**
     * Function which deletes some or all icons via Ajax
     */
    public static function sbsiDelIcons()
    {
        if (isset($_POST)) :


        endif;
        wp_die();
    }
}

SBSI_Back::init();
