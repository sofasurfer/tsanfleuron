<?php 

// ToDo: use filter to get data
$pageid = get_queried_object_id();
$imageid = get_field('rev_header_image_desktop');
$imageid_mobile = get_field('rev_header_image_mobile');


// Get page title
if( get_post_type() == 'team' || get_post_type() == 'post' ){
    $pagetitle = get_the_title($pageid);
}else{
    $pagetitle = get_field('rev_header_title');
}

// Get category list
if( get_post_type() == 'portfolio' ){
    $categories = do_shortcode("[c_get_categories pid=\"$pageid\" posttype=\"portfolio_category\"]");
}elseif( get_post_type() == 'team' ){
    $categories = get_field('rev_team_jobtitlereal');
}elseif( get_field('rev_header_subtitle') ){
    $categories = get_field('rev_header_subtitle');
}

?>

<?php if($imageid): ?>
    <div class="c-container-wide c-showroom  <?= (get_field('remove_margin_bottom') ? '' : 'c-color-change-bottom' );?> c-bg-primary">               
    <!-- showroom, z weites bild mit anderem ratio für mobile screens-->
        <figure class="c-showroom-img"><?= do_shortcode("[render_imagetag id=\"$imageid\" mobile=\"$imageid_mobile\"]"); ?></figure>               
        <!--text-->
        <div class="c-gradient"></div>
        <div class="c-container c-container-no-padding c-showroom-text">
            <div class="c-row c-row-align-bottom">
                <div class="c-col-10 c-showroom-text-inner animation-element fade-up">
                    <?php if( !empty($categories) ): ?>
                        <span class="c-category-title"><?= $categories; ?></span>
                    <?php endif; ?>
                    <h1 class="animation"><?= $pagetitle; ?></h1>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- title main-->
    <div class="c-container c-showroom-light c-title-main">
        <div class="c-row">
            <div class="c-col-10 c-text-block animation-element fade-up">
                <?php if( $categories ): ?>
                    <span class="c-category-title"><?= $categories; ?></span>
                <?php endif; ?>
                <h1 class="animation"><?= $pagetitle; ?></h1>
            </div>
        </div>
    </div>
<?php endif; ?>