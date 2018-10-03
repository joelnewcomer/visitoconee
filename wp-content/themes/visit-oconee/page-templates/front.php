<?php
/*
Template Name: Front
*/
get_header(); ?>

<div id="page" role="main">

	<?php // get_template_part('template-parts/video'); ?>

	<div class="slider-container">
	    <ul class="bxslider">
			<?php if( have_rows('slides') ):
				while ( have_rows('slides') ) : the_row(); ?>
	                <li>
	                	<?php
		                $link = get_sub_field('link_to');
		                if ($link != '') : ?>
		                    <a href="<?php echo get_sub_field('link_to'); ?>">
			            <?php endif; ?>
							<?php echo wp_get_attachment_image(get_sub_field('slide'), 'featured-home'); ?>
						<?php if ($link != '') : ?>	
	                    	</a>
	                    <?php endif; ?>
	                </li>
				<?php endwhile;
			endif; ?>
	    </ul>
	    <div class="slider-overlay text-center">
		    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/visit-oconee-logo.png" alt="Visit Oconee South Carolina logo">
		    <h1>Oconee is a<br /><span>cool place to play!</span></h1>
	    </div>
	</div> <!-- slider-container -->

	<section class="videos">
		<div class="grid-container">
	   		<div class="grid-x">
	   			<?php if(get_field('videos')): ?>
	   				<?php while(has_sub_field('videos')): ?>
	   					<div class="large-4 medium-4 cell home-video">
		   					<a href="<?php echo get_sub_field('video_url'); ?>?autoplay=1&modestbranding=1&showinfo=0&rel=0" data-featherlight="iframe" data-featherlight-iframe-width="960" data-featherlight-iframe-height="540">
		   						<?php echo wp_get_attachment_image(get_sub_field('video_thumbnail'), 'home-video'); ?>
		   						<?php get_template_part('assets/images/play', 'button.svg'); ?>
		   					</a>
	   					</div>
	   				<?php endwhile; ?>
	   			<?php endif; ?>
	   		</div> <!-- grid-x -->
	   	</div> <!-- grid-container -->	   			
	   	<div class="home-quote text-center">
			<div class="quote-wrapper">
				<?php echo wp_get_attachment_image(get_field('quote_image'), 'full'); ?>
				<h2><i><?php echo get_field('quote'); ?></i></h2>
				<p><?php echo get_field('quote_author'); ?></p>
			</div>
	   	</div>
	</section> <!-- videos -->
	
	<section class="home-blocks">
	   	<div class="grid-x">		
			<?php if(get_field('home_blocks')): ?>
				<?php while(has_sub_field('home_blocks')): ?>
					<div class="large-4 medium-4 cell home-block">
		   				<?php $link = get_sub_field('link'); ?>
						<a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>">
							<?php echo wp_get_attachment_image(get_sub_field('image'), 'home-block'); ?>
							<div class="home-block-overlay">
								<div style="display:table;width:100%;height:100%;">
								  <div style="display:table-cell;vertical-align:middle;">
								    <div style="text-align:center;"><?php echo get_sub_field('title'); ?></div>
								  </div>
								</div>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
	   	</div>
	</section> <!-- home-blocks -->

</div> <!-- #page -->

<script>
if (typeof bxSlider === "function") { 	
    var slider = jQuery('.bxslider').bxSlider({
        auto: true,
        pager: false,
        controls: true,
        mode: 'fade',
        speed: 1000,
        pause: 7000
    });	
} else {
	jQuery(window).load(function(){
    	var slider = jQuery('.bxslider').bxSlider({
    	    auto: true,
    	    pager: false,
    	    controls: true,
    	    mode: 'fade',
    	    speed: 1000,
    	    pause: 7000
    	});		
	});
}

</script>

<?php get_footer(); ?>