<!DOCTYPE html>
<html>
<head>
    <?php wp_head(); ?>
</head>
<body>
<header class="site-header">
    <div class="container">
        <h1 class="store-logo-text float-left"><a href="#"><strong>Preethi's Book Store</strong></a></h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
            <nav class="main-navigation">
                <ul class="min-list group">
                    <li><a href="<?php echo home_url()?>">Home Sungoh</a></li>
                    <li><a href="<?php echo site_url('/about-us') ?>">About Us Sungoh</a></li>
                    <li><a href="<?php echo site_url('/shop') ?>">Products Sungoh</a></li>
                    <li><a href="<?php echo site_url('/news')?>">News Sungoh</a></li>
                    <li><a href="<?php echo site_url('/contact-us')?>">Contact Us Sungoh</a></li>
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

