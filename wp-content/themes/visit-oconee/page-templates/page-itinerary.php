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
			<div class="large-12 cell text-center itinerary-buttons hide-for-print">
				<div class="button"><a href="javascript:window.print()">Print</a></div>
				<div class="button"><a class="email" href="mailto:?subject=My Itinerary for Oconee&body=Check out my itinerary for Ocononee County SC! (see attached).&attachment=c:\myfolder\myfile.txt">Email</a></div>
				<div class="load-awesome la-ball-clip-rotate la-2x"><div></div></div>
			</div>
		</div> <!-- grid-x -->
		<div id="itinerary"></div>
		<div class="grid-x grid-padding-x">
			<div class="large-12 cell text-center itinerary-buttons hide-for-print">
				<div class="button"><a href="javascript:window.print()">Print</a></div>
				<div class="button"><a class="email" href="mailto:?subject=My Itinerary for Oconee&body=Check out my itinerary for Ocononee County SC! (see attached).&attachment=c:\myfolder\myfile.txt">Email</a></div>
			</div>
		</div> <!-- grid-x -->


		<!-- Email Modal -->
		<div class="cat-modal transition" id="email-modal">
			<div style="display:table;width:100%;height:100%;">
				<div style="display:table-cell;vertical-align:middle;">
					<div style="text-align:center;">
						<div class="modal-inner">
							<div class="grid-x grid-padding-x">
								
								<div class="close-modal"><?php get_template_part('assets/images/close', 'icon.svg'); ?></div>
								<h2>Email My Itinerary</h2>
								<?php echo do_shortcode('[gravityform id="6" title="false" description="false" ajax="true"]'); ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- email-modal -->
		
	<script>
		jQuery("a.email").on( "click", function(e) {
			e.preventDefault();
			jQuery('#email-modal').addClass('active');
		});
		jQuery(".close-modal").on( "click", function(e) {
			jQuery('.cat-modal').removeClass('active');	
		});
	</script>

	</div> <!-- grid-container -->
</div> <!-- #page -->

<script>
// Function to change index of array item
function array_move(arr, old_index, new_index) {
    if (new_index >= arr.length) {
        var k = new_index - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    return arr; // for testing
};

// When the page loads, pull in the itinerary using AJAX
jQuery( document ).ready(function() {
    var itinerary = basil.get('itinerary');
    jQuery.post(ajaxurl, {
        action: 'load_itinerary',
        itinerary: itinerary
    }, function (data) {    
	    jQuery('.load-awesome').hide();
        jQuery('#itinerary').append(data);
    });
    
    // Generate PDF
    jQuery.ajax({
        url: '<?php echo get_stylesheet_directory_uri(); ?>/ajax-pdf.php',
        type: 'POST',
        data: { itinerary : itinerary },
        success: function(data) {
        	jQuery("a.email").attr("href", "mailto:?subject=My Itinerary for Oconee&body=Check out my itinerary for Ocononee County SC! <a href='" + data + "'>(click here).</a>");
        }
    });

    
});

// Initialize sortScroll - http://jadus.github.io/jquery-sortScroll/
jQuery( document ).ready(function() {
	// showing default options here
	jQuery("#itinerary").sortScroll({
	    animationDuration: 1000,// duration of the animation in ms
	    cssEasing: "ease-in-out",// easing type for the animation
	    keepStill: true,// if false the page doesn't scroll to follow the element
	    fixedElementsSelector: ""// a jQuery selector so that the plugin knows your fixed elements (like the fixed nav on the left)
	});
});

// Update array order when order is changed on itinerary
jQuery("#itinerary").on("sortScroll.sortStart", function(event, element, initialOrder, destinationOrder){
	var itinerary = basil.get('itinerary');
	itinerary = array_move(itinerary, initialOrder, destinationOrder);
	basil.set('itinerary', itinerary);
});

// Remove from basil and from screen
jQuery(document).on( "click", ".remove", function() {
	var r = confirm("Are you sure?");
	if (r == true) {
		poiID = jQuery(this).data('itinerary');
		var itinerary = basil.get('itinerary');
		var index = itinerary.indexOf(poiID);    // <-- Not supported in <IE9
		if (index !== -1) {
    		itinerary.splice(index, 1);
		}
		basil.set('itinerary', itinerary);
		jQuery(this).parents(".poi-card").fadeOut( "slow", function() {
			jQuery(this).parents(".poi-card").remove();
		});
	}
});

</script> 

<?php get_footer(); ?>