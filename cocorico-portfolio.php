<?php
/*
Plugin Name: Cocorico Portfolio
Plugin URI: https://www.themesdefrance.fr/plugins/cocorico-portfolio
Description: Cocorico Portfolio met en valeur vos projets sur votre site
Version: 0.0.1
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
 * Sets up portfolio post type and registers portfolio category and portfolio tag taxonomies.
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
			'label'			=>__('Project', 'cocoportfolio'),
			'labels'		=>$portfolio_labels,
			'public'		=>true,
			'supports' 		=> array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions', 'custom-fields'/*, 'post-formats'*/),
			'menu_position'	=>20,
			'has_archive'	=>true,
			'rewrite'		=>array(
				'slug'=> _x('project', 'project slug', 'cocoportfolio')
			),
			'exclude_from_search'=> true,
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
			'rewrite'=>array('slug'=>_x('project_cat','project category taxonomy slug', 'cocoportfolio'))
		);
		
		$portfolio_tax_cat_args = apply_filters('coco_portfolio_tax_cat_args', $portfolio_tax_cat_args);
		
		register_taxonomy('project_cat', 'portfolio', $portfolio_tax_cat_args);
		
		register_taxonomy_for_object_type('project_cat', 'portfolio');
		
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
			'rewrite' => array( 'slug' => _x('project_tag','project tag taxonomy slug', 'cocoportfolio') ),
		);
		
		$portfolio_tax_tag_args = apply_filters('coco_portfolio_tax_tag_args', $portfolio_tax_tag_args);
		
		//register_taxonomy( 'project_tag', array( 'portfolio' ), $portfolio_tax_tag_args );
		
		//register_taxonomy_for_object_type('project_tag', 'portfolio');
	}
}
add_action('init', 'coco_portfolio_init');