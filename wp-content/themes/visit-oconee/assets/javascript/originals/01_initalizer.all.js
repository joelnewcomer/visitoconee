 /**
 * Initialize jQuery Plugins
 **/
jQuery( document ).ready(function() {

	// Handle FOUC
	jQuery('.no-fouc').removeClass('no-fouc');

    if(jQuery("#estimated-time").length != 0) {
        jQuery('article').readingTime();
    }
    
    var floatlabelsInstances = Array();
    jQuery('form').each(function(i) {
	    var thisForm = jQuery(this)[0];
        floatlabelsInstances[i] = new FloatLabels( thisForm, {
			style: 2,
			prioritize: 'placeholder',
		});
    });

    jQuery('ul.slimmenu').slimmenu( {
        resizeWidth: '640',
        collapserTitle: '',
        animSpeed: 'medium',
        easingEffect: null,
        indentChildren: false,
        childrenIndenter: '&nbsp;',
        expandIcon: '<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 808l-742 741q-19 19-45 19t-45-19l-742-741q-19-19-19-45.5t19-45.5l166-165q19-19 45-19t45 19l531 531 531-531q19-19 45-19t45 19l166 165q19 19 19 45.5t-19 45.5z"/></svg>',
        collapseIcon: '<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19l-531-531-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"/></svg>',
    });

    jQuery('.search-button').featherlight({
        namespace: 'fl-modal',
        variant: 'fl-search',
        closeIcon: '&#10005;',
        afterContent: function(event){
            setTimeout(function() {
                jQuery( 'input#s' ).focus();
            }, 500);
        },
    });
    
    jQuery(window).paroller();
	
	var currentTime = new Date();
	jQuery("li.gfield.date input").each(function() {
	   // Date Dropper
	   // Set min year to current year.
	   jQuery(this).data('min-year', '1900');
	   // Set max year to 2030.
	   jQuery(this).data('max-year', '2030');
	   // Turn large mode on.
	   jQuery(this).data('large-mode', true);
	   // Set large mode as default.
	   jQuery(this).data('large-default', true);
	   // Don't set the date initially.
	   jQuery(this).data('init-set', false);
	   jQuery(this).dateDropper();
	});		    
});