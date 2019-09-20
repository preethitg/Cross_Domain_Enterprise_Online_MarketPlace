<?php
/**
* Template Name: new user section login
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
            function displayUserNameForm() {
                print(
                '<div>You need to login to view this user section content.</div>
                <form id="login1" name="form" action="" method="post">
                    <input id="username" type="text" placeholder="Username" name="username"><br>
                    <input id="password" type="password" placeholder="Password" name="password">
                    <input id="submit" type="submit" name="submit" value="Submit">
                </form>');

            }
            function fieldsBlank() {
                displayUserNameForm();
                print('<div>Please fill all the fields before submitting</div>');
            }

            function fileNotExist() {
                displayUserNameForm();
                print('<div>User List file not found</div>');
            }

            function checkPassword($userpassword, $field) {
                if ($userpassword == $field[1]) {
                    return true;
                }
                return false;
            }

            function showUserList($filename) {
                echo '<div>Welcome! Here is the user list with plain password text.</div>';
                $data = file_get_contents($filename);

                $lines = explode("\n", $data);

                echo '<table border="1">';
                echo '<thead><tr><th>User Name</th><th>Password</th><th>Name</th><th>Role</th></tr></thead>';
                foreach ($lines as $newLine) {
                    $userInfo = explode(",", $newLine);
                    echo '<tr>';
                    echo '<td>' . $userInfo[0] . '</td>';
                    echo '<td>' . $userInfo[1] . '</td>';
                    echo '<td>' . $userInfo[2] . '</td>';
                    echo '<td>' . $userInfo[3] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';

            }

            function wrongPassword() {
                displayUserNameForm();
                print('<div>Access has been denied. Please try again.</div>');
            }

            function acccessDenied() {
                displayUserNameForm();
                print('<div>You do not have permission to view this page.</div>');
            }



            if($_POST) {
                extract($_POST);
                if (!$username || !$password) {
                    fieldsBlank();
                    die();
                } else {
                    $filename = dirname(__FILE__) . "/resource/user_list.txt";
                    $file = fopen($filename, "r");
                    if (!$file) {
                        fileNotExist();
                        die();
                    }
                    $userVerified = 0;
                    while (!feof($file) && !$userVerified) {
                        $line = fgets($file, 255);
                        $line = chop($line);
                        $field = explode(",", $line);
                        if ($username == $field[0]) {
                            $userVerified = 1;
                            if (checkPassword($password, $field) == true) {
                                if ($field[3] == "administrator") {
                                    showUserList($filename);
                                } else {
                                    acccessDenied();
                                }

                            } else {
                                wrongPassword();
                            }
                        }

                    }
                    fclose();
                    if (!$userVerified) {
                        acccessDenied();
                        die();
                    }
                }

            } else {
                displayUserNameForm();
            }
        ?>


    </div>


<?php get_footer(); ?>