<?php
/**
 * The template for displaying search form
 *
 * @package DrumRoll
 * @since DrumRoll 1.0.0
 */
 ?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group">
		<input type="text" class="input-group-field" value="" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'drumroll' ); ?>">
		<div class="input-group-button">
			<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'drumroll' ); ?>" class="button">
		</div>
	</div>
</form>