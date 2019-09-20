<?php
/**
 * Template Name: product statistics
 */

get_header();

?>

<div class="interior-page-banner">
    <div class="page-banner__bg-image"
         style="background-image: url(<?php echo get_theme_file_uri('/images/interior-page-banner.png') ?>);"></div>
    <div class="interior-page-banner__content container container--narrow">
        <h1 class="interior-page-banner__title"><?php the_title(); ?></h1>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    ob_start();
    function displayPreviouslyVisitedProductTable($productIdList)
    {

        echo '<table border="1">';
        echo 'Last previously visited products';
        echo '<thead><tr><th>Product Name</th><th>Description</th><th>Price</th><th>Link</th><th>Rating Counts</th><th>Review counts</th></thead>';

        foreach ($productIdList as $productId) {
            $product = wc_get_product($productId);
            echo '<tr>';
            echo '<td>' . $product->get_name() . '</td>';
            echo '<td>' . $product->get_short_description() . '</td>';
            echo '<td>' . $product->get_price() . '</td>';
            echo '<td>' . get_permalink($productId) . '</td>';
            echo '<td>' . $product->get_rating_count() . '</td>';
            echo '<td>' . $product->get_review_count() . '</td>';
            echo '</tr>';

        }
    }
    function displayMostVisitedProductTable($productViewsCountList)
    {

        echo '<table border="1">';
        echo 'Most five visited products';
        echo '<thead><tr><th>Product Name</th><th>Number of Visits</th><th>Description</th><th>Price</th><th>Link</th><th>Rating Counts</th><th>Review counts</th></thead>';
        $i = 0;
        foreach ($productViewsCountList as $productId => $count) {
            if ($i == 5) {
                break;
            } elseif ($count > 0) {
                $product = wc_get_product($productId);
                echo '<tr>';
                echo '<td>' . $product->get_name() . '</td>';
                echo '<td>' . $count . '</td>';
                echo '<td>' . $product->get_short_description() . '</td>';
                echo '<td>' . $product->get_price() . '</td>';
                echo '<td>' . get_permalink($productId) . '</td>';
                echo '<td>' . $product->get_rating_count() . '</td>';
                echo '<td>' . $product->get_review_count() . '</td>';
                echo '</tr>';
                $i++;
            } else {
                $i++;
            }

        }
    }

    function errorDisplay($error_message)
    {
        print('<div>' . $error_message . '</div>');
    }

    if (isset($_COOKIE["recentviews"])) {
        $recentViewsCookies = $_COOKIE["recentviews"];
        $recentViewsList = explode(",", $recentViewsCookies);
        $displayRecentViews = true;
    } else {
        $displayRecentViews = false;
        errorDisplay("There is no product visited");
    }
    if (isset($_COOKIE["productlist"])) {
        $productViewsCountCookies = $_COOKIE["productlist"];
        $productViewsCountCookies = stripslashes($productViewsCountCookies);
        $productViewsCountList = json_decode($productViewsCountCookies, true);
        arsort($productViewsCountList);
        $displayMostViews = true;
    } else {
        $displayMostViews = false;
        errorDisplay("There is no product visited");
    }
    print('<div id="product_statistics">');
    if ($displayRecentViews) {

        displayPreviouslyVisitedProductTable($recentViewsList);

    }
    if ($displayMostViews) {

        displayMostVisitedProductTable($productViewsCountList);

    }
    print('</div>');

    ?>


</div>


<?php //get_footer(); ?>
