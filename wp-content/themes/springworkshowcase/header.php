<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1" />
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<script>var lang = "<?php echo substr(get_bloginfo ( 'language' ), 0,2); ?>";</script>
<?php wp_head(); ?>
<script type="application/javascript" src="<?php echo get_template_directory_uri() ?>/js/eucookie.js"></script>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
	<header id="header" role="banner">
		<div class="container">
			<div class="row">
				<div id="branding" class="col-4">
					<a href="http://www.springwork.de" target="_blank" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php /* echo esc_html( get_bloginfo( 'name' ) ); */?><img src="<?php echo get_template_directory_uri() ?>/img/springwork-logo.png" class="blandlogo" title="SpringWORK" alt="SpringWORK" /></a>
				</div>

				<div id="header-cta" class="col-8 text-right">
					<a class="bt_tel" href="tel: +49 341 140 655 9680"><b>TEL:</b>&nbsp;+49 (0)341- 140 655 - 9680</a>
					<a class="button bt_transparent" href="https://www.springwork.de/?referer=showcase#kontakt" target="_blank">Kontaktieren Sie uns jetzt.</a>
				</div>
			</div>
		</div>

		<?php
		/*
		<nav id="menu" role="navigation">
			
			<div id="search">
				<?php // get_search_form(); ?>
			</div>
			
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</nav>
		*/
		?>
	</header>