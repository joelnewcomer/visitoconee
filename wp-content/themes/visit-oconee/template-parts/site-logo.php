<?php if ( get_theme_mod( 'site_logo' ) ) : ?>
    <?php $img_src = get_theme_mod( 'site_logo' ); ?>
    <?php if (strpos($img_src, '.svg') !== false) : ?>
		<?php echo file_get_contents($img_src); ?>
	<?php else : ?> 
   		<img src="<?php echo $img_src; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> Logo" />
   	<?php endif; ?>	    
<?php else : ?>
	<?php get_template_part('assets/images/logo.svg'); ?>
<?php endif; ?>
