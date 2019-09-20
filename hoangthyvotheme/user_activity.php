<?php
/**
 * Template Name: user activity
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
    if (is_user_logged_in()) {
        global $current_user;
        $data_key = 'user_activity';
        $data = get_user_meta($current_user->ID, $data_key, true);
        echo '<table id="current-user-tracking" border="1">';
        echo '<thead><tr><th>Page Title</th><th>Link</th><th>Last Time Visited</th></tr></thead>';
        echo '<h3>Here are your activities in this store</h3>';
        foreach ($data as $pageId => $time) {
            echo '<tr>';
            echo '<td>' . get_the_title( $pageId ) . '</td>';
            echo '<td>' . get_permalink($pageId) . '</td>';
            date_default_timezone_set('America/Los_Angeles');
            $date = date("F j, Y, g:i a", $time);
            echo '<td>' . $date . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    ?>


</div>


<?php get_footer(); ?>
