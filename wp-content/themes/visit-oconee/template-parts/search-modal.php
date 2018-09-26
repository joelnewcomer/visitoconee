<?php
/**
 * The template for displaying search form
 *
 * @package WordPress
 * @subpackage DrumRoll
 * @since DrumRoll 1.0.0
 */
?>
<div class="search-popup-container">
	<div class="search-popup" id="search-modal">
		<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
			<input type="text" value="" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'drumroll' ); ?>">
			<input type="submit" class="search" id="searchsubmit" value="Submit">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
  <path fill="#FFF" d="M17.7522319,16.3173665 L23.7174327,22.2825673 L22.2825673,23.7174327 L16.3173665,17.7522319 C14.5951808,19.1573483 12.3959963,20 10,20 C4.4771525,20 0,15.5228475 0,10 C0,4.4771525 4.4771525,0 10,0 C15.5228475,0 20,4.4771525 20,10 C20,12.3959963 19.1573483,14.5951808 17.7522319,16.3173665 Z M10,18.3333333 C14.6023729,18.3333333 18.3333333,14.6023729 18.3333333,10 C18.3333333,5.39762709 14.6023729,1.66666667 10,1.66666667 C5.39762709,1.66666667 1.66666667,5.39762709 1.66666667,10 C1.66666667,14.6023729 5.39762709,18.3333333 10,18.3333333 Z"/>
</svg>
		</form>
	</div> <!-- search-modal -->
</div>