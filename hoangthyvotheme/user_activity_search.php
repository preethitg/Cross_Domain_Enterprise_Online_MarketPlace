<?php
/**
 * Template Name: user activity search
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
    function displaySearchForm() {
        print(
        '<div>You need to login to view this user section content.</div>
                <form id="user_activity_search" name="form" action="" method="post">
                    <input id="username" type="text" placeholder="Username" name="username"><br>
                    <input id="adminkey" type="password" placeholder="Admin Key" name="adminkey">
                    <input id="submit" type="submit" name="submit" value="Submit">
                </form>');

    }
    function fieldsBlank() {
        displaySearchForm();
        print('<div>Please fill all the fields before submitting</div>');
    }
    displaySearchForm();
    if ($_POST) {
        extract($_POST);
        if (!$username || !$adminkey) {
            fieldsBlank();
            die();
        } else {
            $user = get_user_by('login',$username);
            if($user && $adminkey=='ptsadminkey')
            {
                $data_key = 'user_activity';
                $data = get_user_meta($user->ID, $data_key, true);
                if (is_array($data)) {
                    echo '<table id="my-user-tracking" border="1">';
                    echo '<thead><tr><th>Page Title</th><th>Link</th><th>Last Time Visited</th></tr></thead>';

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
                } else {
                    echo 'No data found for this user';
                }

            } else if ($adminkey !='ptsadminkey') {
                echo 'You do not have permission to view user activity';
            } else {
                echo 'This user is not existed in this store';
            }
        }
    }
    ?>


</div>


<?php get_footer(); ?>
