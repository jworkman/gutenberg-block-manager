<?php

namespace JWorkman\Gutenberg_Block_Manager;

class UserInterface extends Factory
{
  public function addCustomPostTypes()
  {
    return $this->addCustomPostType('gbm-component', 'Gutenberg Component', 'Gutenberg Components');
  }
  public function addCustomPostType($slug, $singular, $plural)
  {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( $plural, 'Post Type General Name', $slug ),
        'singular_name'       => _x( $singular, 'Post Type Singular Name', $slug ),
        'menu_name'           => __( $plural, $slug ),
        'parent_item_colon'   => __( 'Parent ' . $singular, $slug ),
        'all_items'           => __( 'All ' . $plural, $slug ),
        'view_item'           => __( 'View ' . $singular, $slug ),
        'add_new_item'        => __( 'Add New ' . $singular, $slug ),
        'add_new'             => __( 'Add New', $slug ),
        'edit_item'           => __( 'Edit ' . $singular, $slug ),
        'update_item'         => __( 'Update ' . $singular, $slug ),
        'search_items'        => __( 'Search ' . $singular, $slug ),
        'not_found'           => __( 'Not Found', $slug ),
        'not_found_in_trash'  => __( 'Not found in Trash', $slug ),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label'               => __( $slug ),
        'description'         => __( 'Custom Gutenberg Component Blocks', $slug ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy.
        'taxonomies'          => array(),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,

    );

    // Registering your Custom Post Type
    register_post_type( $slug, $args );
  }
  public function initHooks()
  {
    // add_management_page(
    //   "Manage Custom Gutenberg Blocks",
    //   "Manage Components",
    //
    // )
    add_action( 'init', [$this, 'addCustomPostTypes'], 0 );

  }
}
