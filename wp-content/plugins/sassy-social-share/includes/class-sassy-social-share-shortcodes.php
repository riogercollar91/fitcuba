<?php

/**
 * The file that defines Shortcodes class
 *
 * A class definition that includes functions used for Shortcodes.
 *
 * @since      1.0.0
 *
 */

/**
 * Shortcodes class.
 *
 * This is used to define functions for Shortcodes.
 *
 * @since      1.0.0
 */
class Sassy_Social_Share_Shortcodes {

	/**
	 * Options saved in database.
	 *
	 * @since    1.0.0
	 */
	private $options;

	/**
	 * Member to assign object of Sassy_Social_Share_Public Class.
	 *
	 * @since    1.0.0
	 */
	private $public_class_object;

	/**
	 * Assign plugin options to private member $options.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $options, $public_class_object ) {

		$this->options = $options;
		$this->public_class_object = $public_class_object;

	}

	/** 
	 * Shortcode for Social Sharing.
	 *
	 * @since    1.0.0
	 */ 
	public function sharing_shortcode( $params ) {
		extract( shortcode_atts( array(
			'style' => '',
			'type' => 'standard',
			'left' => '0',
			'right' => '0',
			'top' => '100',
			'url' => '',
			'count' => 0,
			'align' => 'left',
			'title' => '',
			'total_shares' => 'OFF'
		), $params ) );
		
		$type = strtolower( $type );

		if ( ( $type == 'standard' && ! isset( $this->options['hor_enable'] ) ) || ( $type == 'floating' && ! isset( $this->options['vertical_enable'] ) ) ) {
			return;
		}
		global $post;
		if ( $url ) {
			$target_url = $url;
			$post_id = 0;
		} elseif ( get_permalink( $post -> ID ) ) {
			$target_url = get_permalink( $post -> ID );
			$post_id = $post -> ID;
		} else {
			$target_url = html_entity_decode( esc_url( $this->public_class_object->get_http_protocol() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) );
			$post_id = 0;
		}
		// generate short url
		$short_url = $this->public_class_object->get_short_url( $target_url, $post_id );
		$alignment_offset = 0;
		if ( $left) {
			$alignment_offset = $left;
		} elseif ( $right) {
			$alignment_offset = $right;
		}
		$html = '<div class="heateor_sss_sharing_container heateor_sss_' . ( $type == 'standard' ? 'horizontal' : 'vertical' ) . '_sharing' . ( $type == 'floating' && isset( $this->options['hide_mobile_sharing'] ) ? ' heateor_sss_hide_sharing' : '' ) . ( $type == 'floating' && isset( $this->options['bottom_mobile_sharing'] ) ? ' heateor_sss_bottom_sharing' : '' ) . '" ss-offset="' . $alignment_offset . '" heateor-sss-data-href="' . $target_url.'" ';
		$vertical_offsets = '';
		if ( $type == 'floating' ) {
			$vertical_offsets = $align . ': ' . $$align . 'px; top: ' . $top . 'px;width:' . ( ( $this->options['vertical_sharing_size'] ? $this->options['vertical_sharing_size'] : '35' ) + 4 ) . "px;";
		}
		// style 
		if ( $style != "" || $vertical_offsets != '' ) {
			$html .= 'style="';
			if ( strpos( $style, 'background' ) === false ) { $html .= '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;'; }
			$html .= $vertical_offsets;
			$html .= $style;
			$html .= '"';
		}
		$html .= '>';
		if ( $type == 'standard' && $title != '' ) {
			$html .= '<div style="font-weight:bold">' . ucfirst( $title ) . '</div>';
		}
		// share count transient ID
		$this->public_class_object->share_count_transient_id = '';
		$html .= $this->public_class_object->prepare_sharing_html( $short_url ? $short_url : $target_url, $type == 'standard' ? 'horizontal' : 'vertical', $count, $total_shares == 'ON' ? 1 : 0 );
		$html .= '</div>';
		if ( $count || $total_shares == 'ON' ) {
			$html .= '<script>heateorSssLoadEvent(
		function() {
			// sharing counts
			heateorSssCallAjax(function() {
				heateorSssGetSharingCounts();
			});
		}
	);</script>';
		}
		return $html;
	}

}
