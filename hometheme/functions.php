<?php

function mic_store_files()
{
    wp_enqueue_script('main-store-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('mic_store_main_styles', get_stylesheet_uri());
    wp_enqueue_style('woocommerce_stylesheet', WP_PLUGIN_URL . '/woocommerce/assets/css/woocommerce.css', false, '1.0', "all");

}

function my_custom_login()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-style.css" />';
}

function my_login_redirect($redirect_to, $request, $user)
{
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        //check for admins
        if (in_array('administrator', $user->roles)) {
            // redirect them to the default place
            return $redirect_to;
        } else {
            return home_url();
        }
    } else {
        return $redirect_to;
    }
}

function my_registration_redirect($username, $password)
{
    $url = home_url() . '/wp-login.php';
    echo "<script type='text/javascript'>window.location.href='" . $url . "'</script>";
    exit;
}

function count_product_visits()
{

    if (is_product()) {
        global $product;
        $views = get_post_meta(get_the_ID(), 'my_product_viewed', true);
        if ($views == '') {
            update_post_meta(get_the_ID(), 'my_product_viewed', '1');
        } else {
            $views_no = intval($views);
            update_post_meta(get_the_ID(), 'my_product_viewed', ++$views_no);
        }
    }

}

add_action('wp_head', 'count_product_visits');

function track_user_view_product_within_a_day()
{
    if (is_product() && is_user_logged_in()) {
        // list of user who has visited the product and the visit count in a day
        global $product, $current_user;

        $data_key = 'user_visit_product_count';
        $utime = time();
        $data = get_post_meta(get_the_ID(), $data_key, true);
        if (is_array($data)) {
            //data existed for this product
            $isArrayKeyExistWithUserId = false;
            foreach ($data as $key => $value) {
                if ($key == $current_user->id) {
                    $isArrayKeyExistWithUserId = true;
                    break;
                }
            }
            // check if current user ever visit this product
            if (!$isArrayKeyExistWithUserId) {
                # array_key_exist function does not work with nested array
                $productViewsArray = array();
                $productViewsArray[] = $utime; // first time visit within a day
                $productViewsArray[] = 1;
                $data[$current_user->ID] = $productViewsArray;
                update_post_meta(get_the_ID(), $data_key, $data);
            } else {
                //user already visited this product, reset count if it's a new day
                $productViewsArray = $data[$current_user->id];
                $saved_time = $productViewsArray[0];
                date_default_timezone_set('America/Los_Angeles');
                $beginOfDay = strtotime("midnight", $saved_time);
                $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;
                if ($utime >= $beginOfDay && $utime <= $endOfDay) {
                    $count = intval($productViewsArray[1]);
                    $productViewsArray[1] = $count + 1;
                } else {
                    $productViewsArray = array();
                    $productViewsArray[] = $utime; // first time visit within a day
                    $productViewsArray[] = 1;

                }
                $data[$current_user->ID] = $productViewsArray;
                update_post_meta(get_the_ID(), $data_key, $data);
            }
        } else {
            // data is not an array means data is not existed, create a new array
            $productViewsArray = array();
            $productViewsArray[] = $utime; // first time visit within a day
            $productViewsArray[] = 1;
            $data = array();
            $data[$current_user->ID] = $productViewsArray;
            update_post_meta(get_the_ID(), $data_key, $data);
        }
    }
}

add_action('wp_head', 'track_user_view_product_within_a_day');


remove_filter('comments_clauses', array('WC_Comments', 'exclude_order_comments'), 10, 1);
add_filter('registration_redirect', 'my_registration_redirect');

add_filter('login_redirect', 'my_login_redirect', 10, 3);
add_action('login_head', 'my_custom_login');
add_action('wp_enqueue_scripts', 'mic_store_files');

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start()
{
    echo '<section id="main">';
}

function my_theme_wrapper_end()
{
    echo '</section>';
}

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);