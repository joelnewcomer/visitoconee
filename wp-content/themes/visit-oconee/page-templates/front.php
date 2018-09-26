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
	</div> <!-- slider-container -->
	
	<section class="intro" role="main">
	   <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
	   	<div class="entry-content grid-container">
	   		<div class="grid-x">
	   			<div class="large-12 cell">
	   				<?php the_content(); ?>
	   			</div>
	   		</div> <!-- grid-x -->
	   	</div> <!-- grid-container -->
	   </div>
	</section>

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