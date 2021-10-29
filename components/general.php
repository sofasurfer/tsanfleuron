<?php

// Namespace declaration
namespace Ruffener;

// Exit if accessed directly 
defined('ABSPATH') or die;


/**
 * General hooks
 */
class General {

    /**
     * The singleton instance of this class.
     * @var General
     */
    private static $instance;

    /**
     * Gets the singleton instance of this class.
     * This instance is lazily instantiated if it does not already exist.
     * The given instance can be used to unregister from filter and action hooks.
     * 
     * @return General The singleton instance of this class.
     */
    public static function instance() {
        return self::$instance ?: (self::$instance = new self());
    }


    /**
     * Creates a new instance of this singleton.
     */
    private function __construct() {


        // add_action('wp_enqueue_scripts', [$this, 'custom_scripts']);
        add_action('init', [$this, 'c_init']);
        add_action('init', [$this, 'c_register_maim_menu'] );
        add_action('admin_head', [$this, 'my_custom_admin_css']);

        add_action('wp_ajax_newsletter_subscribe', [$this, 'campainmonitor_subscribe']);
        add_action('wp_ajax_nopriv_newsletter_subscribe', [$this, 'campainmonitor_subscribe'] );
        
        add_shortcode( 'render_animation_elements', [$this, 'render_animation_elements'] );
        add_shortcode( 'render_imagetag', [$this, 'c_shortcode_render_image'] );
        add_shortcode( 'wp_version', [$this, 'c_shortcode_version'] );
        add_shortcode( 'c_post_language_url', [$this, 'c_shortcode_post_languages'] );
        add_shortcode( 'c_post_locale', [$this, 'c_shortcode_post_locale'] );
        add_shortcode( 'c_get_categories', [$this, 'c_shortcode_get_categories'] );
        add_shortcode( 'c_option', [$this, 'c_shortcode_option'] );
        add_shortcode( 'c_socialmedia_list', [$this, 'c_shortcode_socialmedia'] );

        add_filter('c_get_pagetitle', [$this, 'c_get_pagetitle']);
        add_filter('c_get_ogobj', [$this, 'c_get_ogobj']);
        add_filter('login_redirect',[$this, 'glue_login_redirect'],999);
        add_filter('upload_mimes', [$this, 'cc_mime_types'] );
        add_filter('acf/format_value/type=textarea', [$this, 'c_format_value'], 10, 3);
        add_filter('acf/fields/google_map/api', [$this, 'my_acf_google_map_api'] );
        add_filter('use_block_editor_for_post', '__return_false', 10);
        add_filter('use_block_editor_for_post_type', '__return_false', 10);
        add_filter('c_latest_post', [$this, 'c_latest_post'] );
        add_filter('c_get_instagram_feed', [$this, 'get_instagram_feed'], 10, 3 );
        add_filter('c_get_document_info', [$this, 'c_get_document_info'], 10, 1 );
        add_filter('c_get_team_paging', [$this, 'c_get_team_paging'], 10);
        add_filter('c_get_option', [$this, 'c_get_option'], 10, 1);

        add_filter('acf/fields/wysiwyg/toolbars' , [$this, 'c_toolbars']  );
        add_filter('tiny_mce_before_init', [$this, 'c_tiny_mce_before_init'] );

        add_filter('nav_menu_css_class' , [$this, 'c_special_nav_class'] , 10 , 2);
        add_filter('nav_menu_link_attributes', [$this, 'add_class_to_menu'], 10, 4 );


        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'menus' );

        load_theme_textdomain('ruffener', get_stylesheet_directory() . '/languages');



        add_action( 'admin_head', [$this, 'favicon4admin'] );


        if( function_exists('acf_add_options_page') ) {
            acf_add_options_page();   
        }
    }


    public function favicon4admin() {
        echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_stylesheet_directory_uri() . '/dist/assets/images/ico/favicon-32x32.png" />';
    }

    public function c_init(){

        setcookie("hideloader", 'true');

        add_post_type_support( 'page', 'excerpt' );

        remove_post_type_support( 'page', 'editor' );
        remove_post_type_support( 'post', 'editor' );
        remove_post_type_support( 'project', 'editor' );
        
        // Remove comments page in menu
        add_action('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });        
    }

    public function cc_mime_types($mimes = [] ){
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    public function glue_login_redirect($redirect_to,$request='',$user=null){
        //using $_REQUEST because when the login form is submitted the value is in the POST
        if(isset($_REQUEST['redirect_to'])){
            $redirect_to = $_REQUEST['redirect_to'];
        }
        return $redirect_to;
    }

    public function c_register_maim_menu() {
      register_nav_menu('header-menu', __( 'Header Menu' ));
      register_nav_menu('footer-menu', __( 'Footer Menu' ));

    }

    public function c_special_nav_class ($classes, $item) {
        if (in_array('current-menu-item', $classes) ){
            $classes[] = 'c-active';
        }
        if( $item->object_id == $this->c_get_option('archive_portfolio') && get_post_type(get_queried_object_id()) == 'portfolio' ){
            $classes[] = 'c-active ';
        }
        if( $item->object_id == $this->c_get_option('archive_team') && get_post_type(get_queried_object_id()) == 'team' ){
            $classes[] = 'c-active';
        }
        if( $item->object_id == $this->c_get_option('archive_services') && get_post_type(get_queried_object_id()) == 'service' ){
            $classes[] = 'c-active ';
        }
        if( $item->object_id == $this->c_get_option('archive_blog') && get_post_type(get_queried_object_id()) == 'post' ){
            $classes[] = 'c-active ';
        }    
        return $classes;
    }

    public function add_class_to_menu($atts, $item, $args, $depth){

        $atts['class'] = 'menu-item-link';
        return $atts;
    }

    public function my_acf_google_map_api() {
        $api['key'] = $this->c_get_option('google_maps_api_key');
        return $api;
    }

    public function c_shortcode_version(){
        $my_theme = wp_get_theme( 'tsanfleuron' );
        if ( $my_theme->exists() ){
            return $my_theme->get( 'Version' );
        }
        return 1.0;
    }


    /*
        Run do_shortcode on all textarea values
    */
    public function c_format_value( $value, $post_id, $field ) {
        $value = do_shortcode($value);
        return $value;
    }

    /*
        Reders categories for post
        ToDo: add link
    */
    public function c_shortcode_get_categories($args){   
        return '';
        
        $categories = get_the_terms($args['pid'],$args['posttype']);
        if( !empty($categories) && count($categories) > 0 ){
            $cats = array();
            foreach($categories as $cat){
                array_push($cats, $cat->name);
            }        
            return implode(" / ", $cats);
        }else{
            return '';
        }
    }


    public function c_get_pagetitle(){

        $pagetitle = get_the_title() . ' | ';
        if( get_post_type() == 'portfolio' ){
            $pagetitle .= get_the_title($this->c_get_option('archive_portfolio')) . ' | ';
        }else if( get_post_type() == 'service' ){
            $pagetitle .= get_the_title($this->c_get_option('archive_services')) . ' | ';
        }else if( get_post_type() == 'team' ){
            $pagetitle .= get_the_title($this->c_get_option('archive_team')) . ' | ';
        }else if( get_post_type() == 'post' ){
            $pagetitle .= get_the_title($this->c_get_option('archive_blog')) . ' | ';
        }

        return  $pagetitle . get_bloginfo();
    }

    public function c_get_ogobj(){

        $obj = [];
        $obj['locale'] = ICL_LANGUAGE_CODE;
        $obj['title'] = $this->c_get_pagetitle();
        $obj['description'] = get_field('rev_header_metadescription');

        $image_id = false;
        if( get_post_thumbnail_id() ){
            $image_id = get_post_thumbnail_id();
        }else if( get_field('rev_header_image_desktop') ){
            $image_id = get_field('rev_header_image_desktop');
        }
        if( $image_id  ){

            $obj['image'] = wp_get_attachment_image_src( $image_id, 'medium' );
        }
        return $obj;
    }

    public function c_get_option($key){

        $options = get_field('company','option');
        if($options){
            $options = array_merge($options,get_field('site','option'));
            $options = array_merge($options,get_field('integrations','option'));
        }else{
            $options = array();
        }

        if( array_key_exists($key, $options)){
            return $options[$key];
        }else{
            return 'Key ' . $key . ' not found';
        }


    }


    public function c_get_team_paging($args){
        // Get posts
        global $wp_query;
        $news_query = array(
            'post_type' => 'team',
            'orderby'   => 'menu_order',
            'order'     => 'ASC',
            'posts_per_page'   => -1,
        );
        $team = get_posts( $news_query ); 

        $count = 0;
        $active = false;
        $prev = false;
        $next = false;
        foreach($team as $member ){
            if( $member->ID == get_queried_object_id() ){
                if( $count > 0 ){
                    $prev = $team[ $count-1 ];
                }else{
                    $prev = $team[ count($team)-1 ];
                }
                if( $count <  count($team)-1 ){
                    $next = $team[ $count+1 ];
                }else{
                    $next = $team[ 0 ];
                }
                $active = $member;
            }
            $count++;
        }

        return  [
            'total' => count($team),
            'current' => ($active->menu_order+1),
            'prev' => $prev,
            'next' => $next
        ];
    }

    /*
        Shortcode to output theme options
    */
    public function c_shortcode_option($args){
        return $this->c_get_option($args['key']);
    }

    public function c_shortcode_socialmedia($args){
        
        if(!apply_filters('c_get_option','socialmedia_accounts')){
            return false;
        }
        $list = '<ul class="c-list-social">';
        foreach(apply_filters('c_get_option','socialmedia_accounts') as $s_account){
            $list .= "<li><a class=\"c-icon c-btn-social c-btn-social-".$s_account['icon']." c-ir\" href=\"".$s_account['link']['url']."\" target=\"".$s_account['link']['target']."\"></a></li>";
        }
        $list .= "</ul>";
        return $list;

    }

    /*
        Renders an image tag by it's ID
    */
    public function c_shortcode_render_image($args){

        // get alttext
        if( !empty($args['alt'])){
            $alt = $args['alt'];
        }else{
            $alt = get_the_title( $args['id'] );
        }

        // error_log(print_r(get_intermediate_image_sizes(),true));

        // get different image sizes
        if( $args['mobile'] && !empty($args['mobile']) ){
            $src_small = wp_get_attachment_image_src( $args['mobile'], 'thumbnail' );
            $srcset  = $src_small[0] . ' 400w,';
            $scr_medium = wp_get_attachment_image_src( $args['mobile'], 'medium' );
            $srcset  .= $scr_medium[0] . ' 1250w,';
        }else{
            $src_small = wp_get_attachment_image_src( $args['id'], 'thumbnail' );
            $srcset  = $src_small[0] . ' 400w,';
            $scr_medium = wp_get_attachment_image_src( $args['id'], 'medium' );
            $srcset  .= $scr_medium[0] . ' 1250w,';
        }
        
        $scr_large =  wp_get_attachment_image_src( $args['id'], 'large' );
        $srcset .= $scr_large[0] . ' 1840w,';

        $scr_full =  wp_get_attachment_image_src( $args['id'], 'full' ); 
        $srcset .= $scr_full[0] . ' 2400w';

        $sizes = '100vw';
        // $sizes =    '(min-width: 1600px) 1200px,  // ViewPort mindestens 1600 px, nimm Bild mit 1200px Breite'.
        //             '(min-width: 1400px) 1100px,  // ViewPort mindestens 1400 px, nimm Bild mit 1100px Breite'.
        //             '(min-width: 1000px) 900px,    // ViewPort mindestens 1000 px, nimm Bild mit 900px Breite'.
        //             '100vw"';

        $image .= '<noscript><img src="'.$scr_full[0].'" alt="'.$alt.'" /></noscript>';
        $image .= '<img class="lazy" sizes="'.$sizes.'" data-srcset="'.$srcset.'" data-src="'.$scr_large[0].'" alt="'.$alt.'" />';

        if( $args['legend'] ){            
            $attachment = get_post( $args['id'] );
            if($attachment){
                $image .= '<figcaption class="c-legend">' . $attachment->post_excerpt. '</figcaption>';
            }
        }


        return $image;
    }


    public function render_animation_elements($args){

        // apply_filters('the_content', get_post_field('post_content', get_queried_object_id() ) ); 
        $dom = new \DOMDocument();
        $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $args['text'] );
        $items = $dom->getElementsByTagName('p');
        
        // error_log(print_r($args,true) . ' / ' . $args['text'] );

        $content = "";
        if( false && $items && count($items) > 0 ){
            for($i = 0; $i < $items->length; $i ++) {
                $content .= '<div class="animation-element fade-up">';
                $content .= '<div class="animation">' . $items->item($i)->nodeValue . PHP_EOL . '</div>';
                $content .= '</div>';
            }
        }else{
            $content .= '<div class="animation-element fade-up">';
            $content .= '<div class="animation">' . $args['text'] . '</div>';
            $content .= '</div>';
        }
        return $content;
    }

    /*
        Returns default locale
    */
    public function c_shortcode_post_locale(){
        $lang = ICL_LANGUAGE_CODE;
        $langs = icl_get_languages( 'skip_missing=0' );
        if( isset( $langs[$lang]['default_locale'] ) ) {
            return $langs[$lang]['default_locale'];
        }
        return "en_US";
    }


    /*
        Adds custom CSS to admin
    */
    public function my_custom_admin_css() {
        echo '<style>
        .acf-fc-layout-handle{
            color: white!important;
            background-color: #0073aa;
        }
        p.c-lead{
            font-size: 2rem;
        }
        </style>';
    }




    /*
        Creates language switch
    */
    public function c_shortcode_post_languages($args){
        $lswitch = "";
        $languages = icl_get_languages('skip_missing=1');
        if(1 < count($languages)){
            $lswitch = '';
            foreach($languages as $l){
                if( $l['active'] != 1 ){
                    $lswitch .=  $l['url'];
                }
            }
        }
        return $lswitch;
    }

    /*
        wysiwyg settings
    */
    public function c_toolbars( $toolbars )
    {

        $toolbars['Ruffener default'] = array();
        $toolbars['Ruffener default'][1] = array(
            'formatselect',
            'styleselect',
            'bold',
            'italic',
            'link',
            'unlink',
            'removeformat',
            'charmap',
        );
        return $toolbars;
    }
    public function c_tiny_mce_before_init( $settings ){

        $settings['block_formats'] = 'Paragraph=p;Heading 3=h3;Heading 4=h4;';
        $style_formats = array(
            array(
                    'title' => 'Lead',
                    'selector' => 'p',
                    'classes' => 'c-lead',
                    'wrapper' => false,
            ),
        );

        $settings['style_formats'] = json_encode( $style_formats );        
        return $settings;

    }


    /*
        Newsletter AJAX
    */

    function campainmonitor_subscribe(){

        require_once 'csrest_general.php';
        require_once 'csrest_subscribers.php';

        $newsletter_settings = get_field('rev_settings_newsletter', 'option');  
        $auth = array('api_key' => $this->c_get_option('campainmonitor_api_key') );

        $wrap = new \CS_REST_Subscribers( $this->c_get_option('campainmonitor_listid') , $auth);
        
        $result = $wrap->add(array(
            'EmailAddress' =>  $_REQUEST['email'],
            'Name' => $_REQUEST['email'],
            'CustomFields' => array(
                array(
                    'Key' => 'Language',
                    'Value' => $_REQUEST['language']
                )
            ),
            'ConsentToTrack' => 'yes',
            'Resubscribe' => true
        ));
        // error_log( 'RESULT' . print_r($result,true) );
        echo json_encode($result);
        wp_die(); 
    }

}

// Trigger initialization
General::instance();