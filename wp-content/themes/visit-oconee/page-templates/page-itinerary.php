<?php
/*
Template Name: My Itinerary
*/
get_header(); ?>

<div id="page" role="main">

<?php get_template_part( 'template-parts/featured-image' ); ?>

<div id="page" role="main">
	<div class="grid-container">
		<div class="grid-x grid-padding-x">
			<div class="large-12 cell text-center">
				<div class="button"><a href="">Print</a></div>
				<div class="button"><a href="">Email</a></div>
				<div class="load-awesome la-ball-clip-rotate la-2x"><div></div></div>
			</div>
		</div> <!-- grid-x -->
		<div id="itinerary">
			
		</div>
	</div> <!-- grid-container -->
</div> <!-- #page -->

<script>
jQuery( document ).ready(function() {
    var itinerary = basil.get('itinerary');
    jQuery.post(ajaxurl, {
        action: 'load_itinerary',
        itinerary: itinerary
    }, function (data) {    
	    jQuery('.load-awesome').hide();
        jQuery('#itinerary').append(data);
    });
});
</script>  

<?php get_footer(); ?>