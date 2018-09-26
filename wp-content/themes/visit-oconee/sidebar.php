<?php
/**
 * The sidebar containing the main widget area
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
?>
<aside class="sidebar sr large-4 medium-4 cell <?php if (is_page_template( 'page-templates/page-sidebar-left.php' )) { echo 'large-pull-8 medium-pull-8'; }?>">
	<?php dynamic_sidebar( 'sidebar-widgets' ); ?>
</aside>