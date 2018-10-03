<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( empty( $posts ) ) {
	return;
}
?>
<div class="wpautoterms-footer"><p>
		<?php
		$links = array();
		$target = $new_page ? ' target="_blank"' : '';
		foreach ( $posts as $post ) {
			$links[] = '<a href="' . esc_url( get_post_permalink( $post->ID ) ) . '"' . $target . '>' .
			           esc_html( $post->post_title ) . '</a>';
		}
		echo join( '<span class="separator"> ' . get_option( WPAUTOTERMS_OPTION_PREFIX . 'links_separator' ) . ' </span>', $links );
		?></p>
</div>