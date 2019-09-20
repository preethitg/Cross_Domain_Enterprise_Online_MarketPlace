<?php
/**
 * Template Name: user search
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
    function displaySearchForm()
    {
        print ('
               
                <form class="user_search cf" id="user_search" name="form" action="" method="post">
                   
                    <input type="search" id="search_text" placeholder="Search any name, phone number, email ..." name="search_text">
                    <span></span>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form> ');

    }
    function showUserList($result) {


        echo '<table border="1">';
        echo '<thead><tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Cell Phone</th><th>Home Phone</th><th>Address</th></tr></thead>';
        foreach ($result as $newLine) {
            echo '<tr>';

            echo '<td>' . $newLine->username . '</td>';
            echo '<td>' . $newLine->first_name . '</td>';
            echo '<td>' . $newLine->last_name . '</td>';
            echo '<td>' . $newLine->email . '</td>';
            echo '<td>' . $newLine->cellphone . '</td>';
            echo '<td>' . $newLine->homephone . '</td>';
            echo '<td>' . $newLine->address . '</td>';
            echo '</tr>';
        }
        echo '</table>';

    }

    displaySearchForm();
    if ($_POST) {
        extract($_POST);
        if ($search_text) {

            $search_query = "SELECT {$wpdb->users}.ID, firstname.meta_value as first_name, lastname.meta_value as last_name, cellphone.meta_value as cellphone, homephone.meta_value as homephone, 
                                    {$wpdb->users}.user_email as email, {$wpdb->users}.user_login as username, address.meta_value as address
                                    FROM {$wpdb->users} 
                                      INNER JOIN (SELECT user_id, meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'firstname')  as firstname ON {$wpdb->users}.ID = firstname.user_id
                                      INNER JOIN (SELECT user_id, meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'address')  as address ON {$wpdb->users}.ID = address.user_id
                                      INNER JOIN (SELECT user_id, meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'lastname') as lastname ON {$wpdb->users}.ID = lastname.user_id
                                      INNER JOIN (SELECT user_id, meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'cellphone') as cellphone ON {$wpdb->users}.ID = cellphone.user_id
                                      INNER JOIN (SELECT user_id, meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'homephone') as homephone ON {$wpdb->users}.ID = homephone.user_id
                                     WHERE firstname.meta_value REGEXP '" . $search_text . "' OR lastname.meta_value REGEXP '" . $search_text . "' OR cellphone.meta_value REGEXP '" . $search_text . "' OR homephone.meta_value REGEXP '" . $search_text . "'
                                     OR {$wpdb->users}.user_email REGEXP '" . $search_text . "'";



            $result = $wpdb->get_results($search_query);
            showUserList($result);
        }
    }
    ?>


</div>


<?php get_footer(); ?>
