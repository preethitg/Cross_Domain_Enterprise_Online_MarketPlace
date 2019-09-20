<?php
/**
 * Template Name: cross site products
 */



?>


<!--        --><?php
//        function display_blogs()
//        {
//            // loop through all blogs
//
//
//
//            $sites = get_sites();
//            foreach ( $sites as $site ) {
//                echo $site->blog_id;
//                echo "</br>";
//                switch_to_blog( $site->blog_id );
//                $args = array(
//                    'post_type' => 'product',
//                    'posts_per_page' => '-1'
//                );
//                $loop = new WP_Query($args);
//                while ($loop->have_posts()) : $loop->the_post();
//                    global $product;
//                    echo $product;
//
//                    echo "</br>";
//                endwhile;
//                // do something
//        restore_current_blog();
//    }
//
//        }
//        display_blogs();
//
//        ?>
<!---->
<!---->
<?php

$sites = get_sites();
foreach ( $sites as $site ) {

echo "</br>";
switch_to_blog( $site->blog_id );
$popular_products_args = array(
    'post_type' => 'product',
    'posts_per_page' => '-1',
    'meta_key' => 'my_product_viewed',
    'orderby' => 'meta_value_num',
    'order'=> 'DESC'
);

$popular_products_loop = new WP_Query( $popular_products_args );

while( $popular_products_loop->have_posts()) :  $popular_products_loop->the_post();
    global $product;
    // Loop continues
    echo $product;
    echo '</br>';
    echo $product->name;
    echo '</br>';
    echo $product->average_rating;
    echo '</br>';
    $views = get_post_meta( get_the_ID(), 'my_product_viewed', true );
    echo $views;

//    echo $product->get_title() + " number of vie " + $views;
    echo '</br>';
endwhile;
wp_reset_query();
    restore_current_blog();
}
?>


