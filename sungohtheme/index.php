<?php get_header(); ?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/page-banner.png') ?>);"></div>
    <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">Be a happy toddler.</h2>
        <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>new</strong> Spring collection?</h3>
        <a href="<?php echo site_url('/products') ?>" class="btn btn--large btn--blue">Mix & Match with Mic</a>
    </div>
</div>
<?php get_footer(); ?>
