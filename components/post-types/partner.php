<?php

// Namespace declaration
namespace Ruffener\PostType;

use Ruffener\PostTypes;

// Exit if accessed directly 
defined('ABSPATH') or die;

class Partner {

    private static $instance;

    public static function instance() {
        return self::$instance ?: (self::$instance = new self());
    }

    private function __construct() {
        add_action('init', [$this, 'register']);
    }

    public function register() {
        PostTypes::instance()->register_post_type('partner', 'dashicons-star-filled', [
            'name' => 'Partner',
            'singular_name' => 'Partner',
            'menu_name' => 'Partners',
            'all_items' => 'All Partners',
            'add_new' => 'Add Partner',
            'add_new_item' => 'New Partner',
            'edit_item' => 'Edit Partner',
            'new_item' => 'New Partner',
            'view_item' => 'Show Partner',
            'search_items' => 'Search Partner',
            'not_found' => 'Partner has not been found.',
            'not_found_in_trash' => 'Partner not found in the trash'
        ], [
            'en' => 'partner'
        ], false, true,['title', 'excerpt', 'thumbnail', 'revisions', 'page-attributes']);

        if(!function_exists("register_field_group"))
            return;
    }
}

Partner::instance();