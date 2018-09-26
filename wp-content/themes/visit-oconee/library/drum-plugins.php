<?php
/*===================================
=             Plugins               =
===================================*/

// 1. Shortcode Empty Paragraph Fix 0.2 - https://wordpress.org/plugins/shortcode-empty-paragraph-fix/


// Shortcode Empty Paragraph Fix 0.2 - https://wordpress.org/plugins/shortcode-empty-paragraph-fix/
function shortcode_empty_paragraph_fix( $content ) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
    $content = strtr( $content, $array );
    return $content;
}
add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );
?>