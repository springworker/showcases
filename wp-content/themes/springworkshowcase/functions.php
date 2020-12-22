<?php
/**
 * SpringWORK Showcase functions and definitions
 *
 * @link http://www.springwork.de
 * @package WordPress
 * @subpackage SpringWORK_Showcase
 * @since 1.0
 */
/**
 * SpringWORK Showcase only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

// TGM Plugin Activation Class
require_once locate_template('/lib/tgm-plugin-activation/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'sws_register_required_plugins' );
function sws_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Require ACF
		array(
			'name'     => 'Advanced Custom Fields', // The plugin name
			'slug'     => 'advanced-custom-fields', // The plugin slug (typically the folder name)
			'source'   => 'http://downloads.wordpress.org/plugin/advanced-custom-fields.4.4.11.zip', // The plugin source
			'required' => true, // If false, the plugin is only 'recommended' instead of required
		 	'version' => '4.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
		 	'force_activation' => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		 	'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		 	'external_url' => '', // If set, overrides default API URL and points to an external URL
		 	'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		)
	);

	// Change this to your theme text domain, used for internationalising strings
 	
	$config = array(
		'id'           => 'springworkshowcase',    // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}



add_action( 'after_setup_theme', 'springworkshowcase_setup' );
function springworkshowcase_setup(){
	load_theme_textdomain( 'springworkshowcase', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'showcase-thumb', 700, 394, true ); // Hard Crop Mode
	add_image_size( 'showcase-hero', 1440, 810, true ); // Soft Crop Mode
	
	add_theme_support( 'html5', array( 'search-form' ) );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 1280;
	register_nav_menus(
		array( 'main-menu' => __( 'Main Menu', 'springworkshowcase' ) )
	);
}
/*
add_action( 'rest_api_init', 'wpc_register_wp_api_endpoints' );
function wpc_register_wp_api_endpoints() {
	register_rest_route( 'somename', '/search', array(
        'methods' => 'GET',
        'callback' => 'wpc_somename_search_callback',
    ));
}

function wpc_somename_search_callback( $request_data ) {
	
}
*/

function dd_remove_menus(){
  
  if ( !current_user_can('manage_options') ) {
    //remove_menu_page( 'index.php' );                  //Dashboard
    remove_menu_page( 'edit.php' );                   //Posts
    remove_menu_page( 'edit-comments.php' );          //Comments
    remove_menu_page( 'tools.php' );                  //Tools
  }
 
}
add_action( 'admin_menu', 'dd_remove_menus' );

/* add technology taxonomy */
function add_technology_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Technologien', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Technologie', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Technologien', 'text_domain' ),
		'all_items'                  => __( 'Alle Technologien', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true, // Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags. (Default: false)
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'technology', array( 'showcase' ), $args );
}

add_action( 'init', 'add_technology_taxonomy', 0 );

/* create showcases */
add_action( 'init', 'create_post_type', 0 );
function create_post_type() {
	register_post_type( 'showcase',
		array(
			'labels' => array(
				'name' => __( 'Showcases', 'textdomain' ),
				'singular_name' => __( 'Showcase', 'textdomain' )),
			'public' => true,
			'menu_icon'   => 'dashicons-welcome-view-site',
			'has_archive' => true,
			'rewrite' => array('slug' => 'showcase'),
			'supports' => array( 'title', 'editor', 'custom-fields'), //, 'custom-fields' )
			'taxonomies'  => array( 'category', 'Technologien', 'post_tag')
		)
	);
}


add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
function add_my_post_types_to_query( $query ) {
	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'post', 'showcase' ) );
	return $query;
}

add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts(){
	
	/*
	wp_enqueue_script( string $handle, string $src = '', array $deps = array(), string|bool|null $ver = false, bool $in_footer = false )

	$handle: 	(string) (Required) Name of the script. Should be unique.
	$src: 		(string) (Optional) Full URL of the script, or path of the script relative to the WordPress root directory. Default value: ''
	$deps: 		(array) (Optional) An array of registered script handles this script depends on. Default value: array()
	$ver: 		(string|bool|null) (Optional) String specifying script version number, if it has one, which is added to the URL as a query string for cache busting purposes.
				If version is set to false, a version number is automatically added equal to current installed WordPress version. If set to null, no version is added. Default value: false
	$in_footer:	(bool) (Optional) Whether to enqueue the script before </body> instead of in the <head>. Default 'false'. Default value: false
	*/

	// styles
    wp_enqueue_style('gfoots', 'https://fonts.googleapis.com/css?family=Open+Sans:600,300');
    wp_enqueue_style('tether', get_template_directory_uri() . '/vendor/tether/css/tether.min.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/vendor/bootstrap-4/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/vendor/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/page_style.css');


    


    // change jquery version
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery',
		//'http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js', false, '2.0.s');
		get_template_directory_uri() . '/vendor/jquery/2.0.2/jquery.min.js');
        wp_enqueue_script('jquery');
    }

    wp_enqueue_script( 'tether',
        get_template_directory_uri() . '/vendor/tether/js/tether.min.js',
        true
    );

    wp_enqueue_script( 'bootstrap',
        get_template_directory_uri() . '/vendor/bootstrap-4/js/bootstrap.min.js',
        array('jquery'),
        '4.0.0',
        true
    );

    wp_enqueue_script( 'jquery-gridder',
        //'https://rawgit.com/oriongunning/gridder/master/dist/js/jquery.gridder.js',
        get_template_directory_uri() . '/vendor/jquery/jquery.gridder.js',
        array('jquery'),
        false,
        true
    );

    wp_enqueue_script( 'gsap',
        get_template_directory_uri() . '/vendor/gsap/TweenLiteExtended.min.js',
        array(),
        false,
        true
    );

    wp_enqueue_script('themescripts',
        get_template_directory_uri() . '/js/main.js',
        array('jquery'),
        false,
        true
    );
}
?>