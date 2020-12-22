<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage SpringWORK_Showcase
 * @since 1.0
 * @version 1.0
 */
?>
<div id="showcase-main-container" class="container">
	<div id="primary" class="content-area">
		<main id="showcase-main" class="site-main" role="main">
			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
					//get_template_part( 'template-parts/post/content', get_post_format() );
					get_template_part( 'template-parts/post/content', 'showcase' );
				endwhile; // End of the loop.
			?>
		</main><!-- #main -->
	</div><!-- #primary -->	
</div><!-- #main-content -->