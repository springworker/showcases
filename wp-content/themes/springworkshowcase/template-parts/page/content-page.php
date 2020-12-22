<?php
/**
 * Template part for displaying page content in page.php
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
	<header class="entry-header container d-flex flex-wrap flex-md-nowrap">
		
		<a class="collapseIconButton" data-toggle="collapse" href="#collapseTopInfo" role="button" aria-expanded="true" aria-controls="collapseTopInfo">
			<i class="fa fa-times-circle icon-close" aria-hidden="true"></i>
			<i class="fa fa-plus-circle icon-open" aria-hidden="true"></i>
		</a>

		<div id="collapseTopInfo" class="pr-4 collapse show">
			<?php the_content(); ?>
		</div>

		
	</header><!-- .entry-header -->

	<div class="container d-flex flex-wrap flex-lg-nowrap">

		<div id="showcase-nav" class="pr-2">

			<nav class="navbar-toggleable-sm">
				<a href="#!" class="navbar-toggler" data-toggle="collapse" data-target="#showcase-menu-navbar" aria-controls="showcase-menu-navbar" aria-expanded="false" aria-label="Toggle navigation">
			  	<i class="fa fa-bars" aria-hidden="true"></i>
			    <span id="mobile-category-info" class="btn">ALL</span>
			  </a>
				
				<div id="showcase-menu-navbar" class="showcase-menu collapse navbar-collapse show" role="navigation">
					<ul class="navbar-nav">
				  	<li class="nav-item selected" data-filter-categorie="*">ALL</li>						    	
						<?php
						$categories = get_terms('category', 
							array('parent' => 0, 'hide_empty' => true)
						);
						foreach ( $categories as $category ) {
							echo '<li data-filter-slug="' . $category->{'slug'} . '" data-filter-categorie="' . $category->{'term_id'} . '">' . $category->{'name'} . '</li>';
							// echo '<li data-filter-slug="' . $category->{'slug'} . '" data-filter-categorie="' . $category->{'term_id'} . '">' . $category->{'name'} . '</li>';
						}
						?>

						
				  </ul>
				</div>
			</nav>			
		</div> <!-- .showcase-nav -->




		
		<div id="showcase-search" class="ml-lg-auto align-self-md-start pl-lg-4">
			<div id="search" class="form-inline">
				<form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_permalink(); ?>">
					<input type="hidden" value="showcase" name="post_type" />
					<div class="form-group">
	        	<div class="input-group">
	        		<input type="text" class="form-control" value="" name="s" id="s" />
	          	<button class="btn btn-primary input-group-addon"><span class="fa fa-search fa-lg"></span></button>
	        	</div>
			    </div>
			   </form>
			</div>
		</div>
	</div>

	<?php
	// Tag cloud
	if ( function_exists( 'wp_tag_cloud' ) ) : ?>	
	<div id="techology-cloud" class="techology-cloud container mt-4 text-center">		
		<?php
			$settings = array(
			   'smallest' 	=> 14, // size of least used tag
			   'largest'  	=> 34, // size of most used tag
			   'separator' 	=> ' <span class="tcs">~</span> ', // seperator
			   'unit'     	=> 'px', // unit for sizing the tags
			   'number'   	=> 100, // displays at most 45 tags
			   'format' 		=> 'flat',
			   'orderby'  	=> 'name', // order tags alphabetically
			   'order'    	=> 'ASC', // order tags by ascending order
			   'taxonomy' 	=> 'technology' // you can even make tags for custom taxonomies
			);

			wp_tag_cloud($settings);			
		?>
	</div>
	<?php endif; ?>

	<div class="showcases container">

		<ul class="gridder">
			<?php $args = array( 'post_type' => 'showcase', 'posts_per_page' => 100, 'orderby' => array( 'date' => 'DESC') );
			$loop = new WP_Query( $args );

			// https://www.advancedcustomfields.com/resources/#functions
			while ( $loop->have_posts() ) : $loop->the_post();

				$post_id 			= get_the_ID();
				$anchorlink 	= rtrim(str_replace(home_url() . '/showcase/', '', get_permalink()), '/');

				$cats 				= implode(',', wp_get_post_categories($post_id));

				echo '<li class="gridder-list animated" data-deeplink="' . $anchorlink . '" data-categories="[' . $cats . ']" data-griddercontent="' . get_permalink() . '" data-postid="' . $post_id . '">' . "\n";
				$image = get_field('thumbnail');
				if( empty($image) ) {
					$image = array("sizes" => array("showcase-thumb" => '' ), "alt" => '', "title" => '');
				}

				//echo '<pre>'; print_r($anchorlink); echo '</pre>';

				echo '		<div class="image-container">' . "\n";				
				echo '			<div class="image" style="background-image: url(\'' . $image['sizes']['showcase-thumb'] . '\');"></div>'. "\n";
				echo '			<div class="overlay">'. "\n";
		    echo '				' . the_title('<span class="title">', '</span>') . '<br>'. "\n";
		    echo '  			<span class="description">' . get_field( 'short_description' ) .'</span>'. "\n";
		    echo '  			<a class="showcaselink fa fa-link fa-lg" href="' . get_field( 'showcaselink' ) . '"></a>'. "\n";
		    //echo '	<span class="description">' . the_content( ) .'</span>'. "\n";
		    echo '  		</div>' . "\n";
		    echo '		</div>'. "\n";			    
				echo '</li>'. "\n";
			endwhile; ?>
		</ul><!-- end .freelancer -->

		<div class="noentries container">
			<br />
			<h3>Tut uns leid, wir konnten für deine Suche keine Ergebnisse finden.</h3>
			<h5>Vorschläge:</h5>
			<ul>
				<li>Bitte kontrolliere die Schreibweise</li>
				<li>Versuche fachspezifische Kennwörter wie z.B html5, flashtalking</li>
				<li>Bitte kontaktiere uns unter: <a href="http://www.springwork.de/#kontakt" target="_blank">www.springwork.de</a></li>
			</ul>
		</div>

	</div><!-- .entry-content -->
</article><!-- #post-## -->



