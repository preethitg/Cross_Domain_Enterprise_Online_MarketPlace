<?php

get_header();

while (have_posts()) {
    the_post(); ?>

    <div class="interior-page-banner">
        <div class="page-banner__bg-image"
             style="background-image: url(<?php echo get_theme_file_uri('/images/interior-page-banner.png') ?>);"></div>
        <div class="interior-page-banner__content container container--narrow">
            <h1 class="interior-page-banner__title"><?php the_title(); ?></h1>
        </div>
    </div>

    <div class="container container--narrow page-section">

        <div class="generic-content">
            <?php
            the_content();
            ?>
        </div>

    </div>

<?php }

get_footer();

?>