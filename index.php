<?php

// This will be removed after GoLive
// if( !is_user_logged_in() ) {
//     wp_redirect( '/cms/wp-admin/?redirect_to=' . get_home_url(), 302 );
//     exit;
// }


if ( ! defined( 'ABSPATH' ) ) {
    echo "Invalid URL";
    exit; // Exit if accessed directly
}


// Get Header
get_template_part('templates/page_header');


// Get Site Elements
$page_id = get_queried_object_id();
$site_elements = get_field('rev_elements',$page_id);


// Check if 404 Page
if ( is_404() ) {

    get_template_part('templates/page_404');

}else{

    // Get LeadTitle
    get_template_part('templates/page_title');
    
    // Loop all site elements
    if( !empty($site_elements)){
        foreach( $site_elements as $site_element ){
            include( locate_template( 'templates/' . $site_element['acf_fc_layout'] . '.php', false, false ) );
        }
    }
}

// Get Footer
get_template_part('templates/page_footer');

?>