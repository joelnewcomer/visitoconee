<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
?>

<!doctype html>
<html class="no-js no-svg" <?php html_tag_schema(); ?> <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="x-ua-compatible" content="ie=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<?php wp_head(); ?>
		
		<!-- Polyfills to make various versions of IE play nicer -->
		<script>
			jQuery( document ).ready(function() {
				conditionizr.polyfill('<?php echo get_template_directory_uri(); ?>/assets/javascript/polyfills/respond.min.js', ['ie7', 'ie8']);
				conditionizr.polyfill('<?php echo get_template_directory_uri(); ?>/assets/javascript/polyfills/nwmatcher-1.3.4.min.js', ['ie7', 'ie8']);
				conditionizr.polyfill('<?php echo get_template_directory_uri(); ?>/assets/javascript/polyfills/selectivizr-min.js', ['ie7', 'ie8']);
				conditionizr.polyfill('<?php echo get_template_directory_uri(); ?>/assets/javascript/polyfills/html5shiv.min.js', ['ie7', 'ie8', 'ie9']);
				conditionizr.polyfill('<?php echo get_template_directory_uri(); ?>/assets/javascript/polyfills/css3-multi-column.min.js', ['ie7', 'ie8', 'ie9']);
				conditionizr.polyfill('<?php echo get_template_directory_uri(); ?>/assets/javascript/polyfills/flexibility.js', ['ie8', 'ie9']);
				conditionizr.config({
					tests: {
						'ie7': ['class'],
						'ie8': ['class'],
						'ie9': ['class'],
					}
				});
			})
		</script>
		
		<link rel="stylesheet" href="https://use.typekit.net/umi7ged.css">

	</head>
	<body <?php body_class(); ?>>
		
		
	<!-- Load Basil -->
    <script>
    jQuery( document ).ready(function() {
        options = {
            expireDays: 365
        };
        basil = new window.Basil(options);
    });
    </script>
		
		<?php // get_template_part('template-parts/preloader'); ?>
		<a class="skip-link sr-only" href="#content"><?php _e( 'Skip to content', 'drumroll' ); ?></a>
		<!-- NOTE: Remove "transparent" class for white relative header (rather than semi-transparent absolute header) -->
		<div class="header-wrapper transparent">
			<header id="masthead" class="site-header"  role="banner">
				<div id="top-header" class="hide-for-small hide-for-print">
					<nav id="top-navigation" class="main-navigation top-menu grid-container" role="navigation">
						<?php drumroll_top_menu(); ?>
					</nav>
				</div>
				<div class="nav-wrapper">
					<div class="nav-wrapper-inner">
						<nav id="site-navigation" class="main-navigation top-bar grid-container" role="navigation">
							<div class="top-bar-left">
								<?php get_template_part('template-parts/site-logo','link'); ?>
							</div> <!-- top-bar-left -->
							<div class="top-bar-right hide-for-print">
								<?php drumroll_main_menu(); ?>
								<div class="icon-wrapper search-icon-wrapper">
									<a href="#" class="search-button" data-featherlight="#search-modal">
										<?php get_template_part('assets/images/search.svg'); ?>
									</a>
								</div> <!-- icon-wrapper -->
						
							</div> <!-- top-bar-right -->
						</nav> <!-- #site-navigation -->
					</div> <!-- nav-wrapper-inner -->
				</div> <!-- nav-wrapper -->
			</header> <!-- #masthead -->
		</div> <!-- header-wrapper -->
		
		<main id="content" class="container" tabindex="-1">