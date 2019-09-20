<?php
/**
 * Template Name: all user companies list
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

        function curlUserListFromURL($url)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $dom = new DOMDocument();
            $internalErrors = libxml_use_internal_errors(true); // prevent error messages
            $content_utf = mb_convert_encoding($output, 'HTML-ENTITIES', 'UTF-8'); // correct parsing of utf-8 chars
            $dom->loadHTML($content_utf);
            libxml_use_internal_errors($internalErrors); // prevent error messages
            $specialdiv = $dom->getElementById('my-user-list');
            if (isset($specialdiv)) {
                echo $dom->saveXML($specialdiv);
            }

        }
        echo '<p>User list from Hoang Thy Vo</p>';
        curlUserListFromURL('http://thyhoangvo.com/user-list/'); //thy url
        echo '<p>User list from Seongoh</p>';
        curlUserListFromURL('http://soryoo.netandhi.com/custom/allUser/user-list.php'); //seongoh url
        echo '<p>User list from Preethi</p>';
        curlUserListFromURL('http://ptgonlinemarket.com/user-list/'); //preethi url


        ?>
    </div>


<?php get_footer(); ?>