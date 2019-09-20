<?php
/**
 * Template Name: home page
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



<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/banner_page_marketplace.jpg') ?>);"></div>
    <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">PTS Marketplace.</h2>
<!--        <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>best</strong> products?</h3>-->
        <a href="<?php echo site_url('/best-products-marketplace/') ?>" class="btn btn--large btn--blue">Marketplace Best Products</a>
    </div>
</div>
<?php get_footer(); ?>
