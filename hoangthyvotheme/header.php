<?php
//ob_start();
//
//function setRecentViewsToCookies($productId)
//{
//
//    if (isset($_COOKIE["recentviews"])) {
//        $cookie = $_COOKIE["recentviews"];
//        $cookie = explode(",", $cookie);
//    } else {
//        $cookie = array();
//    }
//    // add the value to the array and serialize
//    // always keep 5 latest visit - the smaller index the older visit
//    if (count($cookie) == 5) {
//        $temp = array();
//
//        for ($i = 0; $i < 4; $i++) {
//            $temp[$i] = $cookie[$i + 1];
//        }
//        $temp[4] = $productId;
//        unset($cookie);
//        $cookie = $temp;
//    } else {
//        $cookie[count($cookie)] = $productId;
//    }
//
//
//    $cookieString = implode(",", $cookie); /* changed $cookie to $cookieString */
//
//
//
//    // save the cookie
//    setcookie("recentviews", $cookieString, time() + 86400, '/', ".thyhoangvo.com");
//
//
//}
//
//function setProductListCountVisitToCookies($productId)
//{
//    if (isset($_COOKIE["productlist"])) {
//        $cookie = $_COOKIE["productlist"];
//        $cookie = stripslashes($cookie);
//        $decodeArray = json_decode($cookie, true);
//        if (!array_key_exists($productId, $decodeArray)) {
//            $decodeArray[$productId] = 1;
//        } else {
//            $decodeArray[$productId]++;
//        }
//
//        $productList = $decodeArray;
//    } else {
//
//        $args = array(
//            'post_type' => 'product',
//            'posts_per_page' => '50'
//        );
//        $loop = new WP_Query($args);
//        while ($loop->have_posts()) : $loop->the_post();
//            global $product;
//            $productList[get_the_ID()] = 0;
//        endwhile;
//        $productList[$productId] = 1;
//
//    }
//
//    $productListCookiesString = json_encode($productList);
//
//    setcookie("productlist", $productListCookiesString, time() + 86400, '/', ".thyhoangvo.com");
//
//
//}
//
//global $wp;
//$current_url = home_url(add_query_arg(array(), $wp->request)) . '/';
//
//$args = array(
//    'post_type' => 'product',
//    'posts_per_page' => '50'
//);
//$loop = new WP_Query($args);
//while ($loop->have_posts()) : $loop->the_post();
//    global $product;
//
//    $product_url = get_permalink();
//    if (0 === strcmp($current_url, $product_url)) {
//        setRecentViewsToCookies(get_the_ID());
//        setProductListCountVisitToCookies(get_the_ID());
//    }
//endwhile;
//
//wp_reset_query();

?>

<html>
<head>
    <?php
    ob_start();
    wp_head();
    ?>
</head>
<html>
<header class="site-header">
    <div class="container">
        <h1 class="store-logo-text float-left"><a href="#"><strong>Mic's Toddler Store</strong></a></h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search"
                                                                       aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
            <nav class="main-navigation">
                <ul class="min-list group">
                    <li><a href="<?php echo home_url() ?>">Home</a></li>
                    <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
                    <li><a href="<?php echo site_url('/shop') ?>">Products</a></li>
                    <li><a href="<?php echo site_url('/news') ?>">News</a></li>
                    <li><a href="<?php echo site_url('/contact-us') ?>">Contact Us</a></li>
                    <li><a href="<?php echo site_url('/best-products') ?>">Best Products</a></li>
                    <?php if (is_user_logged_in()) { ?>
                        <li><a href="<?php echo site_url('/user-activity/') ?>">User Activity</a></li>
                    <?php } ?>
                    <li><a href="<?php echo site_url('/market-place') ?>">Marketplace</a></li>

                </ul>
            </nav>

            <div class="site-header__util">
                <?php if (is_user_logged_in()) { ?>
                    <a href="<?php echo wp_logout_url(); ?>"
                       class="btn btn--small  btn--dark-orange float-left btn--with-photo">
                        <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
                        <span class="btn__text">Log Out</span>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="<?php echo site_url('/register') ?>" class="btn btn--small  btn--dark-orange float-left">Sign
                        Up</a>
                <?php } ?>

                <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            </div>

        </div>
    </div>
</header>
</html>


