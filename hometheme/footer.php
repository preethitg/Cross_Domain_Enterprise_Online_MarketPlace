
<footer class="site-footer">

    <div class="site-footer__inner container container--narrow">

        <div class="group">

        <div class="site-footer__col-four">
            <h3 class="headline headline--small">Connect With Us</h3>
            <nav>
                <ul class="min-list social-icons-list group">
                    <li><a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <li><a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li><a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                    </li>
                    <li><a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </li>
                    <li><a href="#" class="social-color-instagram"><i class="fa fa-instagram"
                                                                      aria-hidden="true"></i></a></li>
                </ul>
            </nav>
        </div>

            <?php
            if (is_product() && is_user_logged_in()) {
               global $product, $current_user;
                $data_key = 'user_visit_product_count';
                $utime = time();
                $data = get_post_meta(get_the_ID(), $data_key, true);
                $count = intval($data[$current_user->id][1]);
                echo "Today you have visited this product ";
                echo $count;
                echo " times.";
            }


            ?>

    </div>

    </div>
</footer>
<?php
wp_footer(); ?>
</body>
</html>