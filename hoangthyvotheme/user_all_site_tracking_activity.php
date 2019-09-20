<?php
/**
 * Template Name: user all site tracking activity
 */



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
        <h1 class="store-logo-text float-left"><a href="#"><strong>PTS Marketplace</strong></a></h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search"
                                                                       aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
            <nav class="main-navigation">
                <ul class="min-list group">
                    <li><a href="<?php echo site_url('/market-place') ?>">Marketplace</a></li>
                    <li><a href="http://soryoo.netandhi.com/">K-beauty Box</a></li>
                    <li><a href="http://ptgonlinemarket.com/">Book Store</a></li>
                    <li><a href="<?php echo home_url() ?>">Toddler Store</a></li>
                    <li><a href="<?php echo site_url('/best-products-marketplace/') ?>">Best Products</a></li>
                    <?php if (is_user_logged_in()) { ?>
                        <li><a href="<?php echo site_url('/user-tracking/') ?>">User Tracking</a></li>
                    <?php } ?>


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
                    <a href="<?php echo site_url('/register-marketplace') ?>" class="btn btn--small  btn--dark-orange float-left">Sign
                        Up</a>
                <?php } ?>

                <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            </div>

        </div>
    </div>
</header>

<div class="interior-page-banner">
    <div class="page-banner__bg-image"
         style="background-image: url(<?php echo get_theme_file_uri('/images/interior-page-banner-marketplace.jpg') ?>);"></div>
    <div class="interior-page-banner__content container container--narrow">
        <h1 class="interior-page-banner__title"><?php the_title(); ?></h1>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    if (is_user_logged_in()) {
        global $current_user;



        function curl_other_sites_for_user_activity($url, $username) {
            $fields = array(
                'username' => urlencode($username),
                'adminkey' => urlencode("ptsadminkey")
            );
            $fields_string = "";
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);
            $dom = new DOMDocument();
            $internalErrors = libxml_use_internal_errors(true); // prevent error messages
            $content_utf = mb_convert_encoding($result, 'HTML-ENTITIES', 'UTF-8'); // correct parsing of utf-8 chars
            $dom->loadHTML($content_utf);
            libxml_use_internal_errors($internalErrors); // prevent error messages
            $specialdiv = $dom->getElementById('my-user-tracking');
            if (isset($specialdiv)) {
                echo $dom->saveXML($specialdiv);
            }
        }
        $url = site_url('/user-activity-search/');
        echo '<h3>User Activity on Toddler Store</h3>';
        curl_other_sites_for_user_activity($url, $current_user->user_login);
        #replace $url with team member 1 url
        $url = 'http://ptgonlinemarket.com/search-activity-user/';
        echo '<h3>User Activity on Book Store</h3>';
        curl_other_sites_for_user_activity($url, $current_user->user_login);
        #replace $url with team member 2 url
        $url = 'http://soryoo.netandhi.com/user-activity-search/';
        echo '<h3>User Activity on K-beauty Box</h3>';
        curl_other_sites_for_user_activity($url, $current_user->user_login);
    }
    ?>


</div>


<?php get_footer(); ?>
