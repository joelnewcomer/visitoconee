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


	

    jQuery(document).on( "click", ".reorder .up", function() {
        var thisID = jQuery(this).parents('.poi-card').attr('id');
        var prevID = jQuery(this).parents('.poi-card').prev().attr('id');
        jQuery('#' + prevID).swap({  
            target: thisID, // Mandatory. The ID of the element we want to swap with  
            opacity: "0.5", // Optional. If set will give the swapping elements a translucent effect while in motion  
            speed: 1000, // Optional. The time taken in milliseconds for the animation to occur  
            callback: function() { // Optional. Callback function once the swap is complete  
                // alert("Swap Complete");  
            }  
        });  
    });  
</script> 

<?php get_footer(); ?>