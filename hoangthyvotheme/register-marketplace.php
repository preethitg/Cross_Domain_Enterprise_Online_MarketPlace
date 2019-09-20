<?php
/**
 * Template Name: new register marketplace
 */



?>
<html>
<head>
    <?php
    ob_start();
    wp_head();
    ?>
</head>
<html>
<header class="site-header">
    <div class="container">
        <h1 class="store-logo-text float-left"><a href="#"><strong>PTS Marketplace</strong></a></h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search"
                                                                       aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
            <nav class="main-navigation">
                <ul class="min-list group">
                    <li><a href="<?php echo site_url('/market-place') ?>">Marketplace</a></li>
                    <li><a href="http://soryoo.netandhi.com/">K-beauty Box</a></li>
                    <li><a href="http://ptgonlinemarket.com/">Book Store</a></li>
                    <li><a href="<?php echo home_url() ?>">Toddler Store</a></li>
                    <li><a href="<?php echo site_url('/best-products-marketplace/') ?>">Best Products</a></li>

                </ul>
            </nav>

            <div class="site-header__util">
                <?php if (is_user_logged_in()) { ?>
                    <a href="<?php echo wp_logout_url(); ?>"
                       class="btn btn--small  btn--dark-orange float-left btn--with-photo">
                        <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
                        <span class="btn__text">Log Out</span>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="<?php echo site_url('/register-marketplace') ?>" class="btn btn--small  btn--dark-orange float-left">Sign
                        Up</a>
                <?php } ?>

                <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            </div>

        </div>
    </div>
</header>



<div class="interior-page-banner">
    <div class="page-banner__bg-image"
         style="background-image: url(<?php echo get_theme_file_uri('/images/interior-page-banner-marketplace.jpg') ?>);"></div>
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

    function postCreateUser($user_data_string, $rest_api_url, $jwtToken){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $rest_api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $user_data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $jwtToken
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        if(!curl_errno($ch))
        {
            $info = curl_getinfo($ch);

            echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . 'with status ' . $info['http_code'];
        }

        curl_close($ch);

        if ($result) {
            print_r($result);
        }
    }

    function createUserViaRestApi($user_data_string) {
        $jwtToken_Preethi = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wdGdvbmxpbmVtYXJrZXQuY29tIiwiaWF0IjoxNTI1NTc1MjA1LCJuYmYiOjE1MjU1NzUyMDUsImV4cCI6MTUyNjE4MDAwNSwiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiNiJ9fX0.rLIcRF_hhdgOmUGn_T4XE2F0J3EnvxbRPHu2u7YenJc';
        $jwtToken_Thy = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC90aHlob2FuZ3ZvLmNvbSIsImlhdCI6MTUyNTU1MjgyMCwibmJmIjoxNTI1NTUyODIwLCJleHAiOjE1MjYxNTc2MjAsImRhdGEiOnsidXNlciI6eyJpZCI6IjEifX19.I_COh16r-VYo4MYwRclvPdPBcUsBZuUW-RVFjIaYd8E';
        $jwtToken_SungOh = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zb3J5b28ubmV0YW5kaGkuY29tIiwiaWF0IjoxNTI1NTc3MDIzLCJuYmYiOjE1MjU1NzcwMjMsImV4cCI6MTUyNjE4MTgyMywiZGF0YSI6eyJ1c2VyIjp7ImlkIjoiMSJ9fX0.Xe3VrEuBlYjPmHFaxipMNcAy1vDDEf3QScG0YMrTzjI';

        $rest_api_url_thy = 'http://thyhoangvo.com/wp-json/wp/v2/users';
        $rest_api_url_preethi = 'http://ptgonlinemarket.com/wp-json/wp/v2/users';
        $rest_api_url_sungoh = 'http://soryoo.netandhi.com/wp-json/wp/v2/users';
        //TODO : comment out the line which call the post request to your own page. Only call the rest api of the other pages.
//        postCreateUser($user_data_string, $rest_api_url_thy, $jwtToken_Thy);

        postCreateUser($user_data_string, $rest_api_url_sungoh, $jwtToken_SungOh);

        postCreateUser($user_data_string, $rest_api_url_preethi, $jwtToken_Preethi);

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


            $user_data_array = [];
            $user_data_array['username'] = $username;
            $user_data_array['password'] = $password;
            $user_data_array['email'] = $email;
            $user_data_array['meta'] = [];
            $user_data_array['meta']['address'] = $address;
            $user_data_array['meta']['cellphone'] = $cellphone;
            $user_data_array['meta']['homephone'] = $homephone;
            $user_data_array['meta']['firstname'] = $firstname;
            $user_data_array['meta']['lastname'] = $lastname;
            $user_data_string = json_encode($user_data_array);
            createUserViaRestApi($user_data_string);
            my_registration_redirect();



        } else {
            displayRegisterForm();
        }


    } else {
        echo "<script type='text/javascript'>window.location.href='". site_url('/market-place') ."'</script>";
        exit();

    }
    ?>

</div>


<?php get_footer(); ?>
