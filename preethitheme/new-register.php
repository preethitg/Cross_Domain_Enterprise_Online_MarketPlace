<?php
/**
 * Template Name: new register preethi
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
    function displayRegisterForm()
    {
        print(
        '
         <h1>Sign Up</h1>
         <p>Please fill in this form to create an account.</p>
         <hr>
        <form id="wp_signup_form" action="" method="post">  
  
        <label for="username">Username</label>  
        <input type="text" name="username" id="username">  
        
        <label for="firstname">First Name</label>  
        <input type="text" name="firstname" id="firstname">
        
        <label for="lastname">Last Name</label>  
        <input type="text" name="lastname" id="lastname">   
        
        <label for="address">Home Address</label>  
        <input type="text" name="address" id="address">
        
        <label for="homephone">Home Phone</label>  
        <input type="text" name="homephone" id="homephone">     

        <label for="cellphone">Cell Phone</label>  
        <input type="text" name="cellphone" id="cellphone">     
                
        <label for="email">Email address</label>  
        <input type="text" name="email" id="email">  
        
        <label for="password">Password</label>  
        <input type="password" name="password" id="password">  
        
        <label for="password_confirmation">Confirm Password</label>  
        <input type="password" name="password_confirmation" id="password_confirmation">  
 
  
        <input type="submit" id="submitbtn" name="submit" value="Sign Up" />  
  
</form>  
        ');

    }

    function errorDisplay($error_message)
    {
        displayRegisterForm();
        print('<div>' . $error_message . '</div>');
    }


    global $wpdb, $user_ID;
    if (!is_user_logged_in()) {
        if ($_POST) {
            extract($_POST);
            if (!$username || !$password) {
                errorDisplay('Please fill the username and password fields before submitting');
                die();
            } elseif (strpos($username, ' ') !== false) {
                errorDisplay('Sorry, no spaces allowed in usernames');
            } elseif (0 !== strcmp($_POST['password'], $_POST['password_confirmation'])) {
                errorDisplay('Password and password confirmation do not match');
                die();
            } elseif (username_exists($username)) {
                errorDisplay('Username already exists, please try another');
                die();
            } elseif ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                errorDisplay('This is not a valid email');
                die();
            } elseif (email_exists($email)) {
                errorDisplay('Email has been used, please try another');
                die();

            } elseif ($cellphone && !preg_match("/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/", $cellphone)) {
                errorDisplay('Invalid cell phone format');
                die();
            } elseif ($homephone && !preg_match("/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/", $homephone)) {
                errorDisplay('Invalid home phone format');
                die();
            }
            $hash = wp_hash_password($password);
            $fullname = $firstname . ' ' . $lastname;
            $user_insert_query = 'INSERT INTO ' . $wpdb->prefix . 'users (user_login, user_pass, user_email, user_nicename, display_name)'
                . ' VALUES(%s, %s, %s, %s, %s)';

            $result = $wpdb->query($wpdb->prepare($user_insert_query, array($username, $hash, $email, $fullname, $fullname)));

            $insert_user_id = $wpdb->insert_id;


            $usermeta_insert_query = 'INSERT INTO ' . $wpdb->prefix . 'usermeta (user_id, meta_key, meta_value)'
                . ' VALUES(%d, %s, %s)';

            if ($insert_user_id) {

                $result = $wpdb->query($wpdb->prepare($usermeta_insert_query, array($insert_user_id, 'firstname', $firstname)));

                $wpdb->query($wpdb->prepare($usermeta_insert_query, array($insert_user_id, 'lastname', $lastname)));
                $wpdb->query($wpdb->prepare($usermeta_insert_query, array($insert_user_id, 'address', $address)));
                $wpdb->query($wpdb->prepare($usermeta_insert_query, array($insert_user_id, 'homephone', $homephone)));
                $wpdb->query($wpdb->prepare($usermeta_insert_query, array($insert_user_id, 'cellphone', $cellphone)));
            }
            $success = 1;
            my_registration_redirect($username, $password);

        } else {
            displayRegisterForm();
        }


    } else {
        echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>";
       exit();

    }
    ?>

</div>


<?php get_footer(); ?>
