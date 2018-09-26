<div class="search-and-cats">
	<!-- Search -->
	<form role="search" method="get" id="blog-search" action="<?php echo home_url( '/' ); ?>">
		<input type="text" value="" name="s" id="s" placeholder="<?php esc_attr_e( 'Search Blog', 'drumroll' ); ?>">
		<input type="submit" class="search" id="searchsubmit" value="">
	</form>
	<!-- Categories -->
	<?php
	if (is_home()) {
	    $selected = 0;
	} else {
	    $cat = get_queried_object();
	    $selected = $cat->slug;
	}	
	$args = array(
		'show_option_none'   => 'Select a Category',
		'option_none_value'  => '-1',
		'orderby'            => 'name',
		'hide_empty'         => 1,
		'child_of'           => 0,
		'selected'			=> $selected,
		'hierarchical'       => 0,
		'name'               => 'cat',
		'id'                 => 'blog-cats',
		'class'              => 'postform',
		'hide_if_empty'      => false,
		'value_field'		=> 'slug'
	);	
	wp_dropdown_categories( $args );
	?>
	<script>
		// When category is selected, go to that category
		jQuery( "#blog-cats" ).change(function() {
			var catSelected = jQuery(this).val();
			if (catSelected != -1) {
				window.location.href = '<?php echo get_site_url(); ?>/category/' + catSelected;
			}
		});
	</script>
</div> <!-- search-and-cats -->