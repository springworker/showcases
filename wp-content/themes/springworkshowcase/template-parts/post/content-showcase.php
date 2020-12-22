<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage SpringWORK_Showcase
 * @since 1.0
 * @version 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content row">
		<?php
		/* translators: %s: Name of current post 
		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'springworktest' ),
			get_the_title()
		) );
		*/

		$image = get_field('keyvisual');
		if( empty($image) ) {
			$image = array("sizes" => array("showcase-hero" => '' ), "alt" => '', "title" => '');
		}
		/* echo '<pre>'; print_r($image); echo '</pre>'; */
		?>

		<div class="col-md-7 col-lg-8">
			<img class="keyvisual" src="<?php echo $image['sizes']['showcase-hero']; ?>"  alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" />
		</div>

		<div class="showcase-description col-md-5 col-lg-4">
			<?php
			if ( is_single() ) {
				the_title( '<h2 class="entry-title">', '</h2>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
			// echo '<h4>' . get_field('short_description') . '</h4>';
			the_content();

			// Technology
			$technology_terms = wp_get_object_terms( $post->ID,  'technology' );
			if ( ! empty( $technology_terms ) ) {
				if ( ! is_wp_error( $technology_terms ) ) {
					$arr = array();					
					foreach( $technology_terms as $term ) {
						$arr[] = esc_html( $term->name ); 
					}
					echo '<p class="technologie-list">Technologie: ' . implode($arr, ', ') . '</p>';
					
				}
			}

			$sLink = get_field('showcaselink');
			if($sLink != ""){
				echo '<a class="btn btn-primary" href="' . $sLink . '" target="_blank" >launch showcases <i class="fa fa-external-link"></i></a>';
			}
			?>
			
		</div>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
		<?php /* twentyseventeen_entry_footer(); */ ?>
	<?php endif; ?>

</article><!-- #post-## -->
