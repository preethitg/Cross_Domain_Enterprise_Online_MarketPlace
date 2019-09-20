<?php
/**
 * Template Name: best products marketplace
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
                    <a href="<?php echo site_url('/register-marketplace') ?>"
                       class="btn btn--small  btn--dark-orange float-left">Sign
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


    function curlBestProductFromURL($url, $tableId)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $dom = new DOMDocument();

        @$dom->loadHTML($output);
        $data = $dom->getElementById($tableId);
        $header = $data->getElementsByTagName('th');
        $detail = $data->getElementsByTagName('td');
        foreach ($header as $nodeHeader) {
            $aDataTableHeaderHTML[] = trim($nodeHeader->textContent);
        }

        //#Get row data/detail table without header name as key
        $i = 0;
        $j = 0;
        foreach ($detail as $nodeDetail) {
            $aDataTableDetailHTML[$j][] = trim($nodeDetail->textContent);
            $i = $i + 1;
            $j = $i % count($aDataTableHeaderHTML) == 0 ? $j + 1 : $j;
        }

        for ($i = 0; $i < count($aDataTableDetailHTML); $i++) {
            for ($j = 0; $j < count($aDataTableHeaderHTML); $j++) {
                $aTempData[$i][$aDataTableHeaderHTML[$j]] = $aDataTableDetailHTML[$i][$j];
            }
        }
        $aDataTableDetailHTML = $aTempData;
        unset($aTempData);
        return $aDataTableDetailHTML;
    }

    function pushArray($bigArray, $newArray) {
        foreach ($newArray as $values) {
            $bigArray[] = $values;
        }
        return $bigArray;
    }

    function buildBestProductArrayInMarketPlace($tableId) {
        $bigArray = array();
        $aDataTableDetailHTML = curlBestProductFromURL(site_url('best-products/'), $tableId);
        $bigArray = pushArray($bigArray, $aDataTableDetailHTML);
        $aDataTableDetailHTML = curlBestProductFromURL('http://soryoo.netandhi.com/best-products/', $tableId);
        $bigArray = pushArray($bigArray, $aDataTableDetailHTML);
        $aDataTableDetailHTML = curlBestProductFromURL('http://ptgonlinemarket.com/best-products/', $tableId);
        $bigArray = pushArray($bigArray, $aDataTableDetailHTML);
        return $bigArray;
    }

    function buildDataTableForFinalBestProduct($bigArray, $title, $id) {
        echo '<table id="' .$id .'" border="1">';
        echo '<h3>Best products by '. $title .' over the marketplace</h3>';
        echo '<thead><tr><th>Product Name</th><th>'.$title.' </th><th>Description</th><th>Price</th><th>Link</th></thead>';

        for ($i = 0; $i < 5; $i++) {
            echo '<tr>';
            echo '<td>' . $bigArray[$i]['Product Name'] . '</td>';

            echo '<td>' . $bigArray[$i][$title] . '</td>';


            echo '<td>' . $bigArray[$i]['Description'] . '</td>';
            echo '<td>' . $bigArray[$i]['Price'] . '</td>';
            echo '<td>' . $bigArray[$i]['Link'] . '</td>';

            echo '</tr>';
        }
        echo '</table>';
    }



    // Build Best Product by Rating
    $tableId = 'best-rating';
    $bigArray = buildBestProductArrayInMarketPlace($tableId);

    usort($bigArray, function ($a, $b) {
        return ($b['Average Rating'] < $a['Average Rating']) ? -1 : 1 ;
    });
    echo "</br>";
    buildDataTableForFinalBestProduct($bigArray, 'Average Rating', 'best-rating-marketplace');

    $tableId = 'best-review';
    $bigArray = buildBestProductArrayInMarketPlace($tableId);
    usort($bigArray, function ($a, $b) {
        return $b['Review Count'] - $a['Review Count'];
    });
    buildDataTableForFinalBestProduct($bigArray, 'Review Count', 'best-review-marketplace');
    echo "</br>";


    $tableId = 'best-count';
    $bigArray = buildBestProductArrayInMarketPlace($tableId);
    usort($bigArray, function ($a, $b) {
        return $b['Visit Count'] - $a['Visit Count'];
    });
    buildDataTableForFinalBestProduct($bigArray, 'Visit Count', 'best-count-marketplace');
    echo "</br>";

    ?>


</div>



