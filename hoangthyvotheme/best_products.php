<?php
/**
 * Template Name: best products
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
    // loop through all products
    function sort_and_display_best_products($order_by) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => '5'
        );
        $title = "";
        switch ($order_by){
            case 'rating':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_wc_average_rating';
                $args['order'] = 'desc';
                $title = "Average Rating";
                break;

            case 'review':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_wc_review_count';
                $args['order'] = 'desc';
                $title = "Review Count";
                break;

            case 'visit':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = ' my_product_viewed';
                $args['order'] = 'desc';
                $title = "Visit Count";
                break;

        }
        $loop = new WP_Query($args);
        switch ($order_by){
            case 'rating':
                echo '<table id="best-rating" border="1">';
                break;
            case 'review':
                echo '<table id="best-review" border="1">';
                break;
            case 'visit':
                echo '<table id="best-count" border="1">';
                break;
        }

        echo '<h3>Best products by ' . $title . '</h3>';
        echo '<thead><tr><th>Product Name</th><th>' .$title. '</th><th>Description</th><th>Price</th><th>Link</th></thead>';

        while ($loop->have_posts()) : $loop->the_post();
            global $product;

            $views = get_post_meta(get_the_ID(), 'my_product_viewed', true);
            echo '<tr>';
            echo '<td>' . $product->get_name() . '</td>';
            switch ($order_by){
                case 'rating':
                    echo '<td>' . $product->get_average_rating() . '</td>';
                    break;

                case 'review':
                    echo '<td>' . $product->get_review_count() . '</td>';
                    break;

                case 'visit':
                    echo '<td>' . $views . '</td>';
                    break;

            }

            echo '<td>' . $product->get_short_description() . '</td>';
            echo '<td>' . $product->get_price() . '</td>';
            echo '<td>' . get_permalink(get_the_ID()) . '</td>';

            echo '</tr>';
        endwhile;
        echo "</table>";
//        echo "</div>";

    }

    sort_and_display_best_products('visit');

    sort_and_display_best_products('rating');

    sort_and_display_best_products('review');

    ?>


</div>



