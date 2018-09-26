<?php
/*
Template Name: Convert all pages to Drum Columns

*/
get_header(); ?>

<?php
$args = array(
	'post_type' => 'page',
	'posts_per_page' => -1,
	'meta_query' => array( 
    	array(
        	'key'   => '_wp_page_template', 
            'value' => 'default'
        )
    )	
);	
$the_query = new WP_Query( $args ); ?>
<?php if ( $the_query->have_posts() ) : ?>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<?php
		$content = get_the_content();
		if ($content != null) {
			echo "Updating " . get_the_title() . '...<br />';
			// $clean_post = array(
			// 	'ID' => $post->ID,
			// 	'post_content' => '',
			// );
			// Update the post into the database
			// wp_update_post( $clean_post );
			$field_key = "field_54eb81451c471";
			$value = array(
				array( "column_1" => array("content" => $content),  "acf_fc_layout" => "one_column" ),
			);
			update_field( $field_key, $value, $post->ID);			
		}	
		?>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>