<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage SpringWORK_Showcase
 * @since 1.0
 * @version 1.0
 */
// return in JSON format
header( 'Content-type: application/json' );
// Needed if you want to manually browse to this location for testing
if(!WP_USE_THEMES) define('WP_USE_THEMES', false);
$response = array();
if ( have_posts() ){
	while ( have_posts() ) : the_post();		
		array_push($response, get_the_ID());
	endwhile; // End of the loop.
}
wp_send_json($response);
?>