<div class="single-cats-container hide-for-small">
	<?php
	global $post;
	$args = array(
		'fields' => 'all'  
	);
	$cats = wp_get_post_categories($post->ID, $args);
	foreach ($cats as $cat) {
	    echo '<a class="header-cat" href="' . get_term_link($cat) . '">' . $cat->name . '</a>';
	}
	?>
</div>