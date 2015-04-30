<?php
/*
Plugin Name: Cocorico Portfolio
Plugin URI: https://www.themesdefrance.fr/plugins/cocorico-portfolio
Description: Cocorico Portfolio met en valeur vos projets sur votre site
Version: 0.0.2
Author: Themes de France
Author URI: https://www.themesdefrance.fr
Text Domain: cocoportfolio
Domain Path: /languages/
License: GPL v3

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('COCO_PORTFOLIO_URI', plugin_dir_url(__FILE__).'admin/Cocorico/');
define('COCO_PORTFOLIO_COCORICO_PREFIX', 'cocoportfolio_');
define('COCO_PORTFOLIO_VERSION', '0.0.2');

/**
 * Load translations
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('coco_portfolio_load_textdomain')){
	
	function coco_portfolio_load_textdomain() {
		$domain = 'cocoportfolio';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
}
add_action( 'init', 'coco_portfolio_load_textdomain' );

// Cocorico loading
if(is_admin())
	require_once 'admin/Cocorico/Cocorico.php';

// Plugin Admin
function coco_portfolio_menu_item(){
	add_submenu_page('edit.php?post_type=portfolio',__('Cocorico Portfolio Settings','cocoportfolio'), __('Settings','cocoportfolio'), 'manage_options', 'coco-portfolio', 'coco_portfolio_options');
}
add_action('admin_menu','coco_portfolio_menu_item');

function coco_portfolio_options(){
	include('admin/cocorico-portfolio-admin.php');
}

/**
 * Initialize the portfolio post type on plugin activation
 *
 * @since 1.0
 * @return void
 */
function cocorico_portfolio_activate() {
    coco_portfolio_init();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'cocorico_portfolio_activate' );

/**
 * Sets up portfolio post type and registers portfolio category //and portfolio tag taxonomies (categories are enough to begin with).
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('coco_portfolio_init')){
	
	function coco_portfolio_init(){
		
		// Portfolio post type
		$portfolio_labels = array(
			'name'               => _x( 'Portfolio', 'project post type general name', 'cocoportfolio' ),
			'singular_name'      => _x( 'Project', 'project post type singular name', 'cocoportfolio' ),
			'menu_name'          => _x( 'Portfolio', 'projects admin menu', 'cocoportfolio' ),
			'name_admin_bar'     => _x( 'Project', 'add new project on admin bar', 'cocoportfolio' ),
			'add_new'            => _x( 'Add New', 'add new portfolio', 'cocoportfolio' ),
			'add_new_item'       => __( 'Add New Project', 'cocoportfolio' ),
			'new_item'           => __( 'Add New', 'cocoportfolio' ),
			'edit_item'          => __( 'Edit Project', 'cocoportfolio' ),
			'view_item'          => __( 'View Project', 'cocoportfolio' ),
			'all_items'          => __( 'All Projects', 'cocoportfolio' ),
			'search_items'       => __( 'Search Projects', 'cocoportfolio' ),
			'parent_item_colon'  => __( 'Parent Project:', 'cocoportfolio' ),
			'not_found'          => __( 'No Projects found.', 'cocoportfolio' ),
			'not_found_in_trash' => __( 'No Projects found in Trash.', 'cocoportfolio' ),
		);
		
		$portfolio_args = array(
			'label'			=> __('Project', 'cocoportfolio'),
			'labels'		=> $portfolio_labels,
			'public'		=> true,
			'publicly_queryable' => true,
			'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' /*'comments', 'custom-fields', 'post-formats'*/),
			'menu_position'	=> 20,
			'has_archive'	=> apply_filters('coco_portfolio_archive_slug', 'portfolio'),
			'rewrite'		=> array(
				'slug' => apply_filters('coco_portfolio_project_slug', _x('project', 'project slug', 'cocoportfolio'))
			),
			'exclude_from_search' => false,
			'menu_icon'		=> 'dashicons-art'
		);
		
		$portfolio_args = apply_filters('coco_portfolio_args', $portfolio_args);
		
		register_post_type('portfolio',$portfolio_args);
		
		// Portfolio category taxonomy
		$tax_portfolio_cat_labels = array(
			'name' 							=> __( 'Projects Categories', 'cocoportfolio' ),
			'singular_name' 				=> __( 'Project Category', 'cocoportfolio' ),
			'search_items' 					=> __( 'Search Projects Categories', 'cocoportfolio' ),
			'popular_items'					=> __( 'Popular Projects Categories', 'cocoportfolio' ),
			'all_items' 					=> __( 'All Projects Categories', 'cocoportfolio' ),
			'parent_item' 					=> __( 'Parent Project Category', 'cocoportfolio' ),
			'parent_item_colon' 			=> __( 'Parent Project Category:', 'cocoportfolio' ),
			'edit_item' 					=> __( 'Edit Project Category', 'cocoportfolio' ),
			'update_item' 					=> __( 'Update Project Category', 'cocoportfolio' ),
			'add_new_item' 					=> __( 'Add New Project Category', 'cocoportfolio' ),
			'new_item_name' 				=> __( 'New Project Category Name', 'cocoportfolio' ),
			'add_or_remove_items' 			=> __( 'Add or remove projects categories', 'cocoportfolio' ),
			'choose_from_most_used' 		=> __( 'Choose from the most used projects categories', 'cocoportfolio' ),
			'menu_name' 					=> __( 'Categories', 'cocoportfolio' ),
	    );
		
		$portfolio_tax_cat_args = array(
			'label'=>__('Categories', 'cocoportfolio'),
			'labels'=> $tax_portfolio_cat_labels,
			'hierarchical'=>true,
			'show_in_nav_menus'=> true,
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'show_tagcloud'		=> false,
			'rewrite'=> array(
				'slug' => apply_filters('coco_portfolio_category_slug', _x('project-category', 'project category taxonomy slug', 'cocoportfolio'))
			),
			'public' => true
		);
		
		$portfolio_tax_cat_args = apply_filters('coco_portfolio_tax_cat_args', $portfolio_tax_cat_args);
		
		register_taxonomy('skill', 'portfolio', $portfolio_tax_cat_args);
		
		register_taxonomy_for_object_type('skill', 'portfolio');
		
		// Portfolio tag taxonomy
		$tax_portfolio_tag_labels = array(
			'name' 							=> __( 'Projects Tags', 'cocoportfolio' ),
			'singular_name' 				=> __( 'Project Tag', 'cocoportfolio' ),
			'search_items' 					=> __( 'Search Projects Tags', 'cocoportfolio' ),
			'popular_items' 				=> __( 'Popular Projects Tags', 'cocoportfolio' ),
			'all_items' 					=> __( 'All Projects Tags', 'cocoportfolio' ),
			'parent_item' 					=> __( 'Parent Project Tag', 'cocoportfolio' ),
			'parent_item_colon' 			=> __( 'Parent Project Tag:', 'cocoportfolio' ),
			'edit_item' 					=> __( 'Edit Project Tag', 'cocoportfolio' ),
			'update_item' 					=> __( 'Update Project Tag', 'cocoportfolio' ),
			'add_new_item' 					=> __( 'Add New Project Tag', 'cocoportfolio' ),
			'new_item_name' 				=> __( 'New Project Tag Name', 'cocoportfolio' ),
			'separate_items_with_commas' 	=> __( 'Separate projects tags with commas', 'cocoportfolio' ),
			'add_or_remove_items' 			=> __( 'Add or remove projects tags', 'cocoportfolio' ),
			'choose_from_most_used' 		=> __( 'Choose from the most used projects tags', 'cocoportfolio' ),
			'menu_name' 					=> __( 'Tags', 'cocoportfolio' )
		);

		$portfolio_tax_tag_args = array(
			'label'=>__('Tags', 'cocoportfolio'),
			'labels' => $tax_portfolio_tag_labels,
			'hierarchical' => false,
			'public' => true,
			'show_in_nav_menus' => false,
			'show_ui' => true,
			'show_admin_column' => false,
			'show_tagcloud' => false,
			'rewrite' => array( 'slug' => _x('portfolio_tag','project tag taxonomy slug', 'cocoportfolio') ),
		);
		
		$portfolio_tax_tag_args = apply_filters('coco_portfolio_tax_tag_args', $portfolio_tax_tag_args);
		
		//register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $portfolio_tax_tag_args );
		
		//register_taxonomy_for_object_type('portfolio_tag', 'portfolio');
	}
}
add_action('init', 'coco_portfolio_init');

/**
 * Displays project metaboxes
 *
 * @since 1.0
 * @return void
 */
if (!function_exists('coco_portfolio_metaboxes')){
	
	function coco_portfolio_metaboxes(){
		require_once 'admin/cocorico-portfolio-metaboxes.php';
	}
}	
add_action('after_setup_theme', 'coco_portfolio_metaboxes');

/**
 * Project update messages.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_post_type#Example
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function coco_portfolio_portfolio_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );
	
	$messages['portfolio'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Project updated.', 'cocoportfolio' ),
		2  => __( 'Custom field updated.', 'cocoportfolio' ),
		3  => __( 'Custom field deleted.', 'cocoportfolio' ),
		4  => __( 'Project updated.', 'cocoportfolio' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Project restored to revision from %s', 'cocoportfolio' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Project published.', 'cocoportfolio' ),
		7  => __( 'Project saved.', 'cocoportfolio' ),
		8  => __( 'Project submitted.', 'cocoportfolio' ),
		9  => sprintf(
			__( 'Project scheduled for: <strong>%1$s</strong>.', 'cocoportfolio' ),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i', 'cocoportfolio' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Project draft updated.', 'cocoportfolio' )
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'coco_portfolio_portfolio_updated_messages' );

/**
 * Add new columns to portfolio projects admin page
 *
 * @since 1.0
 * @return void
 */
function coco_portfolio_columns($columns){
	$columns = array_slice($columns, 0, 1, true) + array('project_thumbnail' => __('Thumbnail', 'cocoportfolio')) + array_slice($columns, 1, count($columns), true);
	return $columns;
}
add_filter('manage_edit-portfolio_columns', 'coco_portfolio_columns');

function coco_portfolio_custom_columns($column, $post_id) {
	switch ($column) {
		case 'project_thumbnail' :
			if (has_post_thumbnail($post_id)) {
				$edit_url = get_edit_post_link($post_id);
				echo '<a href="' . $edit_url . '">';
				echo get_the_post_thumbnail($post_id, 'thumbnail');
				echo '</a>';
			} else {
				echo '<small>' . __('None', 'cocoportfolio') . '</small>';
			}

			break;
	}
}
add_action('manage_portfolio_posts_custom_column', 'coco_portfolio_custom_columns', 10, 2);

/**
 * Filter the rewrite slugs based on plugin settings
 *
 * @since 1.0
 * @return void
 */
function coco_portfolio_archive_slug_from_setting($slug) {

}
add_filter('coco_portfolio_archive_slug', 'coco_portfolio_archive_slug_from_setting', 10, 1);

function coco_portfolio_project_slug_from_setting($slug) {

}
add_filter('coco_portfolio_project_slug', 'coco_portfolio_project_slug_from_setting', 10, 1);

function coco_portfolio_category_slug_from_setting($slug) {

}
add_filter('coco_portfolio_category_slug', 'coco_portfolio_category_slug_from_setting', 10, 1);
