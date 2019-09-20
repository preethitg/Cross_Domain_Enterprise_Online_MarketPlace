<?php
/**
 * Template Name: all user list
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
        echo '<table id="my-user-list" border="1">';
        echo '<thead><tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Cell Phone</th><th>Home Phone</th><th>Address</th></tr></thead>';

        $users = get_users( array( 'fields' => array( 'ID', 'user_login', 'user_email' ) ) );
        foreach($users as $user) {
                echo '<tr>';
                echo '<td>' . $user->user_login . '</td>';
                echo '<td>' . get_user_meta($user->ID, 'firstname', true) . '</td>';
                echo '<td>' . get_user_meta($user->ID, 'lastname', true) . '</td>';
                echo '<td>' . $user->user_email . '</td>';
                echo '<td>' . get_user_meta($user->ID, 'cellphone', true) . '</td>';
                echo '<td>' . get_user_meta($user->ID, 'homephone', true) . '</td>';
                echo '<td>' . get_user_meta($user->ID, 'address', true) . '</td>';
                echo '</tr>';
        }
        echo '</table>';
        ?>
    </div>


<?php get_footer(); ?>