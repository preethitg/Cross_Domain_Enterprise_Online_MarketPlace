<?php
/*
 * Particular functions for my site only
 */

function mic_store_files()
{
    wp_enqueue_script('main-store-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('mic_store_main_styles', get_stylesheet_uri());
    wp_enqueue_style('woocommerce_stylesheet', WP_PLUGIN_URL . '/woocommerce/assets/css/woocommerce.css', false, '1.0', "all");

}

add_action('wp_enqueue_scripts', 'mic_store_files');

function my_custom_login()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-style.css" />';
}
add_action('login_head', 'my_custom_login');


/*
 * WooCommerce theme support for my site only
 */
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
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');
remove_filter('comments_clauses', array('WC_Comments', 'exclude_order_comments'), 10, 1);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/*
 * Common functions can be used for the whole marketplace
 * */

// disable register and forgot password link in wordpress login

function hide_login_links_div()
{
    echo '<style type="text/css"> .login #nav {
        display: none;
    }
    </style>';
}

// redirect user to homepage after login
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

// redirect user to login page after registration
function my_registration_redirect()
{
    $url = home_url() . '/wp-login.php';
    echo "<script type='text/javascript'>window.location.href='" . $url . "'</script>";
    exit;
}


// count the visit numbers of each product
function count_product_visits()
{
    if (is_product()) {
        $views = get_post_meta(get_the_ID(), 'my_product_viewed', true);
        if ($views == '') {
            update_post_meta(get_the_ID(), 'my_product_viewed', '1');
        } else {
            $views_no = intval($views);
            update_post_meta(get_the_ID(), 'my_product_viewed', ++$views_no);
        }
    }

}


// track how many times within a day a particular user visit a product page

function track_user_view_product_within_a_day()
{
    if (is_product() && is_user_logged_in()) {
        // list of user who has visited the product and the visit count in a day
        global $current_user;

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

// track
function track_user_activity(){
    /*
     * $userVisitedPage['pageId'] = utime => store the last time visit of the page
     */
    if (is_user_logged_in()) {
        global $current_user;
        global $post;
        if(is_shop()){
            $page_id = wc_get_page_id('shop');
        }else{
            $page_id = $post->ID;
        }
        $data_key = 'user_activity';
        $utime = time();
        $data = get_user_meta($current_user->ID, $data_key, true);
        if (is_array($data)) {
           $data[$page_id] = $utime; //always updated the latest visit of user in a page/post/product
        } else {
            // data is not an array means data is not existed, create a new array
            $data = array();
            $data[$page_id] = $utime;
        }
        update_user_meta($current_user->ID, $data_key, $data);
    }
}

// register the needed user meta filed to be used in rest api
function register_posts_meta_field()
{
    $object_type = 'user';
    $args1 = array( // Validate and sanitize the meta value.
        // Note: currently (4.7) one of 'string', 'boolean', 'integer',
        // 'number' must be used as 'type'. The default is 'string'.
        'type' => 'string',
        // Shown in the schema for the meta key.
        'description' => 'A meta key associated with a user cellphone value.',
        // Return a single value of the type.
        'single' => true,
        // Show in the WP REST API response. Default: false.
        'show_in_rest' => true,
    );

    register_meta($object_type, 'cellphone', $args1);
    $args1['description'] = 'A meta key associated with a user address value.';
    register_meta($object_type, 'address', $args1);
    $args1['description'] = 'A meta key associated with a user first name value.';
    register_meta($object_type, 'firstname', $args1);
    $args1['description'] = 'A meta key associated with a user last name value.';
    register_meta($object_type, 'lastname', $args1);
    $args1['description'] = 'A meta key associated with a user homephone value.';
    register_meta($object_type, 'homephone', $args1);
    $args1['description'] = 'A meta key associated with a user activity array value.';
    register_meta($object_type, 'user_activity', $args1);

}


add_action('wp_head', 'track_user_view_product_within_a_day');
add_action('wp_head', 'track_user_activity');
add_action('wp_head', 'count_product_visits');

add_filter('registration_redirect', 'my_registration_redirect');
add_filter('login_redirect', 'my_login_redirect', 10, 3);
add_action('login_head', 'hide_login_links_div');


add_action('rest_api_init', 'register_posts_meta_field');




