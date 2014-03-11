<?php
/**
 * Featured_Image_Metabox_Customizer
 *
 * A class to help override the Featured Image Metabox
 */

if ( !class_exists( 'Featured_Image_Metabox_Customizer' ) ) {

	class Featured_Image_Metabox_Customizer {

		protected $post_type;
		protected $metabox_title;
		protected $set_text;
		protected $remove_text;

		function __construct($args = array()) {
			if ( !empty($args) ) {
				$this->post_type     = $args['post_type'];
				$this->metabox_title = $args['metabox_title'];
				$this->set_text      = $args['set_text'];
				$this->remove_text   = $args['remove_text'];
			}

			if ( isset($this->post_type) ) {
				add_action( 'add_meta_boxes', array($this, 'change_featured_image_metabox_title') );
				add_filter( 'admin_post_thumbnail_html', array($this, 'change_featured_image_metabox_content') );
				add_filter( 'media_view_strings', array($this, 'change_featured_image_media_strings'), 10, 2 );
			}
		}

		/**
		 * Change the metabox title
		 *
		 * @param $post_type
		 */
		function change_featured_image_metabox_title($post_type) {
			if ( $post_type === $this->post_type ) {
				//remove original featured image metabox
				remove_meta_box( 'postimagediv', $this->post_type, 'side' );

				//add our customized metabox
				add_meta_box( 'postimagediv', $this->metabox_title, 'post_thumbnail_meta_box', $this->post_type, 'side', 'low' );
			}
		}

		/**
		 * Extract the post type from the AJAX referer
		 * @return string
		 */
		function get_ajax_referer_post_type() {
			//extract the querystring from the referer
			$query = parse_url( wp_get_referer(), PHP_URL_QUERY );

			//extract the querystring into an array
			parse_str( $query, $query_array );

			//get the post_type querystring value
			if ( array_key_exists( 'post_type', $query_array ) ) {
				return $query_array['post_type'];
			}

			//if all else fails, we are most likely dealing with a post
			return 'post';
		}

		/**
		 * Get the post type (AJAX or normal)
		 * @return string The post type
		 */
		function get_featured_image_metabox_post_type() {
			//we first need to check if this is an ajax call
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				return $this->get_ajax_referer_post_type();
			}

			//get the post type in the usual way
			$screen = get_current_screen();

			return $screen->post_type;
		}

		/**
		 * Change the text within the featured image metabox links
		 *
		 * @param string $content
		 *
		 * @return string
		 */
		function change_featured_image_metabox_content($content) {
			if ( $this->get_featured_image_metabox_post_type() === $this->post_type ) {
				$content = str_replace( __( 'Set featured image' ), $this->set_text, $content );
				$content = str_replace( __( 'Remove featured image' ), $this->remove_text, $content );
			}

			return $content;
		}

		/**
		 * Change the strings for the media manager modal
		 *
		 * @param $strings
		 * @param $post
		 *
		 * @return mixed
		 */
		function change_featured_image_media_strings($strings, $post) {

			// checks if post object is empty or not
			if ( ! empty($post) ) {

				if ( $post->post_type === $this->post_type ) {
					$strings['setFeaturedImage']      = $this->set_text;
					$strings['setFeaturedImageTitle'] = $this->set_text;
				}

			}

			return $strings;
		}

	}
}
