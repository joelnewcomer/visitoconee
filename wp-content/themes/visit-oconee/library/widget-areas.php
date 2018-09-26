<?php
/**
 * Register widget areas
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */

// Commented this out on 3/21/18 since we rarely/never use sidebars
/* if ( ! function_exists( 'drumroll_sidebar_widgets' ) ) :
function drumroll_sidebar_widgets() {
	register_sidebar(array(
	  'id' => 'sidebar-widgets',
	  'name' => __( 'Sidebar widgets', 'drumroll' ),
	  'description' => __( 'Drag widgets to this sidebar container.', 'drumroll' ),
	  'before_widget' => '<article id="%1$s" class="widget %2$s">',
	  'after_widget' => '</article>',
	  'before_title' => '<h6>',
	  'after_title' => '</h6>',
	));
}

add_action( 'widgets_init', 'drumroll_sidebar_widgets' );
endif; */
