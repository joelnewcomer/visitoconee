jQuery( function($) {
    
    // Initialise some variables, used later for the image ID input value
    mfis_value = '';
    previous_value = '';

    // Function to reset all things mfis
    function mfis_reset(){
        
        $( '#publishing-action input[type="submit"]' ).removeAttr('disabled').show();
        
        $( '.mfis_publishing_disabled' ).fadeOut(500, function(){
            $( '.mfis_publishing_disabled' ).remove();
            $( '#postimagediv .inside' ).removeClass( 'mfis_is_disabled' );
        });

        mfis_value = '';

    }

    // Do the mfis check
    function mfis_check_image(){

        // Check if there is an input with the image ID
        if ( $('#_thumbnail_id').length > 0 && $('#_thumbnail_id').val() >= 0 ) {

            // Compare it to the previous value
            mfis_value = $('#_thumbnail_id').val();

            if ( mfis_value != previous_value ) {
            	
            	// Value has changed, so let's disable the Publish button and do the ajax
                $( '#publishing-action input[type="submit"]' ).attr('disabled', 'disabled').show();

                data = {
                    action      : 'mfis_get_size_from_id',
                    image_id    : mfis_value,
                    post_type   : mfis.post_type,
                };

                $.post( ajaxurl , data , function( response ) {
                    
                    // Split the response into an array
                    response = response.split('[mfis_delimter]');

                    if( response[0] == 'image_failed') {

                        // Add error message
                        var mfis_publishing_disabled_message = '<div class="mfis_publishing_disabled"><span class="mfis_icon">!</span><span class="mfis_error_message">' + response[1] + '</span></div>';
                        if( ! $( '#postimagediv .inside' ).hasClass('mfis_is_disabled') ) {
                            $( '#postimagediv .inside' ).after( mfis_publishing_disabled_message ).addClass('mfis_is_disabled');
                            $( '.mfis_publishing_disabled' ).hide().fadeIn();
                        }
                    
                    } else {

                        // Image passed, so let's reset things
                        mfis_reset();

                    }

                });
            }

            previous_value = mfis_value;

        // There's no image ID input present, so reset things
        } else {

            mfis_reset();

        }

    }

    // Reset mfis if 'Remove featured image' link is clicked
    $( '#remove-post-thumbnail' ).on( 'click', function(){

        $('#_thumbnail_id').val( -1 );

        mfis_reset();

    });

    // Do initial check on page load, and then keep checking
    mfis_check_image();
    setInterval(mfis_check_image, 200);

});

