<?php
/**
 * Show the pages that a form is on, with a link to edit or view the page
 *
 * @since
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Show_Page_On_Form_List {

	/**
	 * Pages that have a Gravity Forms shortcode
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	private $pages = array();

	/**
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function run () {

		add_filter( 'gform_form_list_columns', array( $this, 'gform_form_list_columns' ) );

		add_action( 'gform_form_list_column_page', array( $this, 'gform_form_list_column_page' ) );

	}

	/**
	 * Add Page column to Forms list page
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function gform_form_list_columns( $columns ) {

		$utility_columns = array(
			'page' => esc_html__( 'Page', 'gravityplus-gfutility' ),
		);

		$this->get_pages();


		return array_merge( $columns, $utility_columns );
	}

	/**
	 * Output pages for a form
	 *
	 * @since 2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $item form object
	 */
	public function gform_form_list_column_page( $item ) {

		$num_of_page_links = 0;

		foreach ( $this->pages as $page ) {

			if ( $item->id == $page['form_id'] ) {

				if ( 0 < $num_of_page_links ) {

					echo '<br />';

				}

				echo "<b><a class='row_title' title='{$page['name']}' href='{$page['edit_url']}'>{$page['name']}</a></b> <div class='row-actions'> <span class='edit-page-link'><a title='" . __('Edit Page', 'gravityplus-gfutility') . "' href='{$page['edit_url']}' target='_blank'>" . __('Edit', 'gravityplus-gfutility') . "</a> | </span><span class='view-page-link'><a title='" . __('View Page', 'gravityplus-gfutility') . "' href='{$page['view_url']}' target='_blank'>" . __('View', 'gravityplus-gfutility') . "</a> </span> </div>";

				$num_of_page_links++;

			}

		}
	}

	/**
	 * Get all of the pages that have a Gravity Forms shortcode
	 *
	 * @since
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	private function get_pages() {

		$query = new WP_Query( array( 's' => '[gravityform', 'nopaging' => true ) );

		if ( $query->have_posts() ) {

			global $post;

			while( $query->have_posts() ) {

				$query->the_post();

				$shortcode_instances = preg_match_all( "/(\[gravityform)(.*)(id=\")([0-9]*)(\".*)(\])/", $post->post_content, $matches );

				if ( ! empty( $shortcode_instances ) ) {

					foreach ( $matches[4] as $match ) {

						if ( empty( $this->pages ) ) {

							$this->pages[] = array( 'form_id' => $match, 'name' => $post->post_title, 'edit_url' => get_edit_post_link() , 'view_url' => get_permalink() );
						
						}
						else {

							$multiple_shortcodes_for_same_form = false;

							foreach ( $this->pages as $page ) {

								if ( $page['form_id'] == $match && $post->post_title == $page['name'] ) {

									$multiple_shortcodes_for_same_form = true;

									break;

								}

							}

							if ( ! $multiple_shortcodes_for_same_form ) {

								$this->pages[] = array( 'form_id' => $match, 'name' => $post->post_title, 'edit_url' => get_edit_post_link() , 'view_url' => get_permalink() );
							
							}

						}

					}

				}

			}

		}

	}

}

$gfpgfu_show_page = new GFPGFU_Show_Page_On_Form_List();
$gfpgfu_show_page->run();