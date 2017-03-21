<?php

/**
 * Custom filters/actions
 *
 * @package   PT_Content_Views
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !class_exists( 'PT_CV_Hooks' ) ) {

	/**
	 * @name PT_CV_Hooks
	 */
	class PT_CV_Hooks {
		/**
		 * Add custom filters/actions
		 */
		static function init() {
			add_filter( PT_CV_PREFIX_ . 'validate_settings', array( __CLASS__, 'filter_validate_settings' ), 10, 2 );
			add_filter( PT_CV_PREFIX_ . 'field_content_excerpt', array( __CLASS__, 'filter_field_content_excerpt' ), 9, 3 );

			/**
			 * @since 1.7.5
			 * able to disable responsive image of WordPress 4.4
			 */
			add_filter( 'wp_get_attachment_image_attributes', array( __CLASS__, 'filter_disable_wp_responsive_image' ), 1000 );

			// Do action
			add_action( PT_CV_PREFIX_ . 'before_query', array( __CLASS__, 'action_before_query' ) );
			add_action( PT_CV_PREFIX_ . 'before_process_item', array( __CLASS__, 'action_before_process_item' ) );
			add_action( PT_CV_PREFIX_ . 'after_process_item', array( __CLASS__, 'action_after_process_item' ) );

			// For only Frontend
			add_action( 'init', array( __CLASS__, 'action_init' ), 1 );
		}

		/**
		 * Validate settings filter
		 *
		 * @param string $errors The error message
		 * @param array  $args  The Query parameters array
		 */
		public static function filter_validate_settings( $errors, $args ) {
			$dargs = PT_CV_Functions::get_global_variable( 'dargs' );

			//			echo "<pre>";
			//			var_dump( 'query args', $args );
			//			echo "</pre>";
			//			echo "<pre>";
			//			var_dump( 'display args', $dargs );
			//			echo "</pre>";

			$messages = array(
				'field'	 => array(
					'select' => __( 'Please select an option in : ', PT_CV_TEXTDOMAIN ),
					'text'	 => __( 'Please set value in : ', PT_CV_TEXTDOMAIN ),
				),
				'tab'	 => array(
					'filter'	 => __( 'Filter Settings', PT_CV_TEXTDOMAIN ),
					'display'	 => __( 'Display Settings', PT_CV_TEXTDOMAIN ),
				),
			);

			/**
			 * Validate Query parameters
			 */
			// Post type
			if ( empty( $args[ 'post_type' ] ) ) {
				$errors[] = $messages[ 'field' ][ 'select' ] . $messages[ 'tab' ][ 'filter' ] . ' > ' . __( 'Content type', PT_CV_TEXTDOMAIN );
			}

			/**
			 * Validate common Display parameters
			 */
			// View type
			if ( empty( $dargs[ 'view-type' ] ) ) {
				$errors[] = $messages[ 'field' ][ 'select' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'View type', PT_CV_TEXTDOMAIN );
			}

			// Layout format
			if ( empty( $dargs[ 'layout-format' ] ) ) {
				$errors[] = $messages[ 'field' ][ 'select' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'Layout format', PT_CV_TEXTDOMAIN );
			}

			// Field settings
			if ( !isset( $dargs[ 'fields' ] ) ) {
				$errors[] = $messages[ 'field' ][ 'select' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'Fields settings', PT_CV_TEXTDOMAIN ) . ' > ' . __( 'Fields display', PT_CV_TEXTDOMAIN );
			}

			// Item per page
			if ( isset( $dargs[ 'pagination-settings' ] ) ) {
				if ( empty( $dargs[ 'pagination-settings' ][ 'items-per-page' ] ) ) {
					$errors[] = $messages[ 'field' ][ 'text' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'Pagination settings', PT_CV_TEXTDOMAIN ) . ' > ' . __( 'Items per page', PT_CV_TEXTDOMAIN );
				}
			}

			/**
			 * Validate Display parameters of view types
			 */
			if ( !empty( $dargs[ 'view-type' ] ) ) {
				switch ( $dargs[ 'view-type' ] ) {
					case 'grid':
						if ( empty( $dargs[ 'number-columns' ] ) ) {
							$errors[] = $messages[ 'field' ][ 'text' ] . $messages[ 'tab' ][ 'display' ] . ' > ' . __( 'View type settings', PT_CV_TEXTDOMAIN ) . ' > ' . __( 'Items per row', PT_CV_TEXTDOMAIN );
						}
						break;
				}
			}

			return array_filter( $errors );
		}

		/**
		 * Filter content before generating excerpt
		 *
		 * @param type $args
		 * @param type $fargs
		 * @param type $post
		 */
		public static function filter_field_content_excerpt( $args, $fargs, $post ) {
			/**
			 * Get content of current language
			 * qTranslate-X (and qTranslate, mqTranslate)
			 * @since 1.7.8
			 */
			if ( function_exists( 'qtranxf_use' ) ) {
				global $q_config;
				$args = qtranxf_use( $q_config[ 'language' ], $args );
			}

			return $args;
		}

		// Disable WP 4.4 responsive image
		public static function filter_disable_wp_responsive_image( $args ) {
			if ( PT_CV_Functions::setting_value( PT_CV_PREFIX . 'field-thumbnail-nowprpi' ) ) {
				if ( isset( $args[ 'sizes' ] ) )
					unset( $args[ 'sizes' ] );
				if ( isset( $args[ 'srcset' ] ) )
					unset( $args[ 'srcset' ] );
			}

			return $args;
		}

		public static function action_before_query() {
			/** Fix problem with Paid Membership Pro plugin
			 * It resets (instead of append) "post__not_in" parameter of WP query which makes:
			 * - exclude function doesn't work
			 * - output in Preview panel is different from output in front-end
			 */
			if ( function_exists( 'pmpro_search_filter' ) ) {
				remove_filter( 'pre_get_posts', 'pmpro_search_filter' );
			}
		}

		public static function action_before_process_item() {
			// Disable View Shortcode in child page
			PT_CV_Functions::disable_view_shortcode();
		}

		public static function action_after_process_item() {
			// Enable View Shortcode again
			PT_CV_Functions::disable_view_shortcode( 'recovery' );
		}

		public static function action_init() {
			$user_can = current_user_can( 'administrator' ) || current_user_can( PT_CV_Functions::get_option_value( 'access_role' ) );
			if ( !($user_can) ) {
				return;
			}

			if ( !empty( $_GET[ PT_CV_SOLVE_SCRIPT_ERROR ] ) ) {
				update_option( PT_CV_SOLVE_SCRIPT_ERROR, true, false );
			}

			if ( !empty( $_GET[ 'cv_undo_solve_error' ] ) ) {
				delete_option( PT_CV_SOLVE_SCRIPT_ERROR );
			}
		}

	}

}
