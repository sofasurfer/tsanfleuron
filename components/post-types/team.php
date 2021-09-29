<?php

// Namespace declaration
namespace Ruffener\PostType;

use Ruffener\PostTypes;

// Exit if accessed directly 
defined('ABSPATH') or die;

class Team {

    private static $instance;

    public static function instance() {
        return self::$instance ?: (self::$instance = new self());
    }

    private function __construct() {
        add_action('init', [$this, 'register']);
    }

    public function register() {
        PostTypes::instance()->register_post_type('team', 'dashicons-star-filled', [
            'name' => 'Team',
            'singular_name' => 'Team',
            'menu_name' => 'Teams',
            'all_items' => 'All Teams',
            'add_new' => 'Add Team',
            'add_new_item' => 'New Team',
            'edit_item' => 'Edit Team',
            'new_item' => 'New Team',
            'view_item' => 'Show Team',
            'search_items' => 'Search Team',
            'not_found' => 'Team has not been found.',
            'not_found_in_trash' => 'Team not found in the trash'
        ], [
            'en' => 'team'
        ], false, true,['title', 'excerpt', 'thumbnail', 'revisions', 'page-attributes']);

        if(!function_exists("register_field_group"))
            return;
    }
}

Team::instance();