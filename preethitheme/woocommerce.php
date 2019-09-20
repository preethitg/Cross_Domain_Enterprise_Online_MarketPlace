<?php

get_header();
?>

<div class="interior-page-banner">
    <div class="page-banner__bg-image"
         style="background-image: url(<?php echo get_theme_file_uri('/images/interior-page-banner.png') ?>);"></div>
    <div class="interior-page-banner__content container container--narrow">
        <h1 class="interior-page-banner__title"></h1>
    </div>
</div>

<div class="container container--narrow page-section">

    <div class="generic-content">
        <div class="woocommerce">
            <?php woocommerce_content(); ?>
        </div>
    </div>




</div>

<?php

get_footer();

?>


