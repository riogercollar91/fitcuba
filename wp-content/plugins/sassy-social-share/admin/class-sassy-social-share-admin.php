<?php

/**
 * Contains functions responsible for functionality at admin side
 *
 * @since      1.0.0
 *
 */

/**
 * This class defines all code necessary for functionality at admin side
 *
 * @since      1.0.0
 *
 */
class Sassy_Social_Share_Admin {

	/**
	 * Options saved in database.
	 *
	 * @since    1.0.0
	 */
	private $options;

	/**
	 * Current version of the plugin.
	 *
	 * @since    1.0.0
	 */
	private $version;

	/**
	 * Flag to check if BuddyPress is active.
	 *
	 * @since    1.0.0
	 */
	private $is_bp_active = false;

	/**
	 * Get saved options.
	 *
	 * @since    1.0.0
     * @param    array    $options    Plugin options saved in database
	 */
	public function __construct( $options, $version ) {

		$this->options = $options;
		$this->version = $version;

	}

	/**
	 * Creates plugin menu in admin area
	 *
	 * @since    1.0.0
	 */
	public function create_admin_menu() {

		$page = add_menu_page( __( 'Sassy Social Share by Heateor', 'sassy-social-share' ), 'Sassy Social Share', 'manage_options', 'heateor-sss-options', array( $this, 'options_page' ), plugins_url( '../images/logo.png', __FILE__ ) );
		// options
		$options_page = add_submenu_page( 'heateor-sss-options', __( "Sassy Social Share - General Options", 'sassy-social-share' ), __( "Sassy Social Share", 'sassy-social-share' ), 'manage_options', 'heateor-sss-options', array( $this, 'options_page' ) );
		// What's new (keep it for next release)
		//$whats_new_page = add_submenu_page( 'heateor-sss-options', __( "Sassy Social Share - What's New", 'sassy-social-share' ), __( "What's New", 'sassy-social-share' ), 'manage_options', 'heateor-sss-whats-new', array( $this, 'whats_new_page' ) );
		add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_scripts' ) );
		add_action( 'admin_print_scripts-' . $page, array( $this, 'admin_style' ) );
		add_action( 'admin_print_scripts-' . $page, array( $this, 'fb_sdk_script' ) );
		add_action( 'admin_print_scripts-' . $options_page, array( $this, 'admin_scripts' ) );
		add_action( 'admin_print_scripts-' . $options_page, array( $this, 'fb_sdk_script' ) );
		add_action( 'admin_print_styles-' . $options_page, array( $this, 'admin_style' ) );
		add_action( 'admin_print_scripts-' . $options_page, array( $this, 'admin_options_scripts' ) );
		add_action( 'admin_print_styles-' . $options_page, array( $this, 'admin_options_style' ) );
	
	}

	/**
	 * Register plugin settings and its sanitization callback.
	 *
	 * @since    1.0.0
	 */
	public function options_init() {

		register_setting( 'heateor_sss_options', 'heateor_sss', array( $this, 'validate_options' ) );
		
		// show option to disable sharing on particular page/post
		$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
		$post_types = array_unique( array_merge( $post_types, array( 'post', 'page' ) ) );
		foreach ( $post_types as $type ) {
			add_meta_box( 'heateor_sss_meta', 'Sassy Social Share', array( $this, 'sharing_meta_setup' ), $type );
		}
		// save sharing meta on post/page save
		add_action( 'save_post', array( $this, 'save_sharing_meta' ) );

	}

	/**
	 * Update options in all the old blogs.
	 *
	 * @since    1.0.0
	 */
	public function update_old_blogs( $old_config ) {
		
		$option_parts = explode( '_', current_filter() );
		$option = $option_parts[2] . '_' . $option_parts[3] . '_' . $option_parts[4];
		$new_config = get_option( $option );
		if ( isset( $new_config['config_multisite'] ) && $new_config['config_multisite'] == 1 ) {
			$blogs = get_blog_list( 0, 'all' );
			foreach ( $blogs as $blog ) {
				update_blog_option( $blog['blog_id'], $option, $new_config );
			}
		}
	
	}

	/**
	 * Replicate the options to the new blog created.
	 *
	 * @since    1.0.0
	 */
	public function replicate_settings( $blog_id ) {

		add_blog_option( $blog_id, 'heateor_sss', $this->options );
	
	}

	/**
	 * Show sharing meta options
	 *
	 * @since    1.0.0
	 */
	public function sharing_meta_setup() {

		global $post;
		$postType = $post->post_type;
		$sharing_meta = get_post_meta( $post->ID, '_heateor_sss_meta', true );
		?>
		<p>
			<label for="heateor_sss_sharing">
				<input type="checkbox" name="_heateor_sss_meta[sharing]" id="heateor_sss_sharing" value="1" <?php checked( '1', @$sharing_meta['sharing'] ); ?> />
				<?php _e( 'Disable Standard Sharing interface on this ' . $postType, 'sassy-social-share' ) ?>
			</label>
			<br/>
			<label for="heateor_sss_vertical_sharing">
				<input type="checkbox" name="_heateor_sss_meta[vertical_sharing]" id="heateor_sss_vertical_sharing" value="1" <?php checked( '1', @$sharing_meta['vertical_sharing'] ); ?> />
				<?php _e( 'Disable Floating Sharing interface on this ' . $postType, 'sassy-social-share' ) ?>
			</label>
			<?php
			$valid_networks = array( 'facebook', 'twitter', 'linkedin', 'google_plus', 'delicious', 'buffer', 'reddit', 'pinterest', 'stumbleupon', 'vkontakte' );
			if ( isset( $this->options['hor_enable'] ) && isset( $this->options['horizontal_counts'] ) && isset( $this->options['horizontal_re_providers'] ) && count( $this->options['horizontal_re_providers'] ) > 0 ) {
				?>
				<p>
				<strong><?php _e( 'Standard sharing', 'sassy-social-share' ) ?></strong>
				<?php
				foreach ( array_intersect( $this->options['horizontal_re_providers'], $valid_networks ) as $network ) {
					?>
					<br/>
					<label for="heateor_sss_<?php echo $network ?>_horizontal_sharing_count">
						<span style="width: 242px; float:left"><?php _e( 'Starting share count for ' . ucfirst( str_replace ( '_', ' ', $network ) ), 'sassy-social-share' ) ?></span>
						<input type="text" name="_heateor_sss_meta[<?php echo $network ?>_horizontal_count]" id="heateor_sss_<?php echo $network ?>_horizontal_sharing_count" value="<?php echo isset( $sharing_meta[$network . '_horizontal_count'] ) ? $sharing_meta[$network . '_horizontal_count'] : '' ?>" />
					</label>
					<?php
				}
				?>
				</p>
				<?php
			}
			
			if ( isset( $this->options['vertical_enable'] ) && isset( $this->options['vertical_counts'] ) && isset( $this->options['vertical_re_providers'] ) && count( $this->options['vertical_re_providers'] ) > 0 ) {
				?>
				<p>
				<strong><?php _e( 'Floating sharing', 'sassy-social-share' ) ?></strong>
				<?php
				foreach ( array_intersect( $this->options['vertical_re_providers'], $valid_networks ) as $network ) {
					?>
					<br/>
					<label for="heateor_sss_<?php echo $network ?>_vertical_sharing_count">
						<span style="width: 242px; float:left"><?php _e( 'Starting share count for ' . ucfirst( str_replace ( '_', ' ', $network ) ), 'sassy-social-share' ) ?></span>
						<input type="text" name="_heateor_sss_meta[<?php echo $network ?>_vertical_count]" id="heateor_sss_<?php echo $network ?>_vertical_sharing_count" value="<?php echo isset( $sharing_meta[$network . '_vertical_count'] ) ? $sharing_meta[$network . '_vertical_count'] : '' ?>" />
					</label>
					<?php
				}
				?>
				</p>
				<?php
			}
			?>
		</p>
		<?php
	    echo '<input type="hidden" name="heateor_sss_meta_nonce" value="' . wp_create_nonce( __FILE__ ) . '" />';
	
	}

	/**
	 * Save sharing meta fields.
	 *
	 * @since    1.0.0
	 */
	public function save_sharing_meta( $post_id ) {
	    
	    // make sure data came from our meta box
	    if ( ! isset( $_POST['heateor_sss_meta_nonce'] ) || ! wp_verify_nonce( $_POST['heateor_sss_meta_nonce'], __FILE__ ) ) {
			return $post_id;
	 	}
	    // check user permissions
	    if ( $_POST['post_type'] == 'page' ) {
	        if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
	    	}
		} else {
	        if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
	    	}
		}
	    if ( isset( $_POST['_heateor_sss_meta'] ) ) {
			$newData = $_POST['_heateor_sss_meta'];
		} else {
			$newData = array( 'sharing' => 0, 'vertical_sharing' => 0 );
		}
		update_post_meta( $post_id, '_heateor_sss_meta', $newData );
	    return $post_id;

	}

	/** 
	 * Sanitization callback for plugin options.
	 *
	 * IMPROVEMENT: complexity can be reduced (this function is called on each option page validation and "if ( $k == 'providers' ) {"
	 * condition is being checked every time)
     * @since    1.0.0
	 */ 
	public function validate_options( $heateorSssOptions ) {
		
		foreach ( $heateorSssOptions as $k => $v ) {
			if ( is_array( $v ) ) {
				$heateorSssOptions[$k] = $heateorSssOptions[$k];
			} else {
				$heateorSssOptions[$k] = esc_attr( trim( $v ) );
			}
		}
		return $heateorSssOptions;

	}

	/**
	 * "Whats's New" page.
	 *
	 * @since    1.0.0
	 */	
	public function whats_new_page() {

		//wp_enqueue_script( 'heateor_sss_fb_sdk_script', plugins_url( '../admin/js/fb_sdk.js', __FILE__ ), false, $this->version );
	
	}

	/**
	 * Include Javascript at plugin options page in admin area.
	 *
	 * @since    1.0.0
	 */	
	public function admin_options_scripts() {

		wp_enqueue_script( 'heateor_sss_admin_options_script', plugins_url( 'js/sassy-social-share-options.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), $this->version );
	
	}

	/**
	 * Include Javascript SDK in admin.
	 *
	 * @since    1.0.0
	 */	
	public function fb_sdk_script() {

		wp_enqueue_script( 'heateor_sss_fb_sdk_script', plugins_url( 'js/sassy-social-share-fb-sdk.js', __FILE__ ), false, $this->version );
	
	}

	/**
	 * Include CSS files in admin.
	 *
	 * @since    1.0.0
	 */	
	public function admin_style() {

		wp_enqueue_style( 'heateor_sss_admin_style', plugins_url( 'css/sassy-social-share-admin.css', __FILE__ ), false, $this->version );
	
	}

	/**
	 * Include CSS files at plugin options page in admin area.
	 *
	 * @since    1.0.0
	 */	
	public function admin_options_style() {

		wp_enqueue_style( 'heateor_sss_admin_svg', plugins_url( 'css/sassy-social-share-svg.css', __FILE__ ), false, $this->version );
		if ( $this->options['horizontal_font_color_default'] != '' ) {
			$updated = $this->update_css( 'horizontal_sharing_replace_color', 'horizontal_font_color_default', 'sassy-social-share-default-svg-horizontal' );
			wp_enqueue_style( 'heateor_sss_admin_svg_horizontal', plugins_url( 'css/sassy-social-share-default-svg-horizontal.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
		if ( $this->options['horizontal_font_color_hover'] != '' ) {
			$updated = $this->update_css( 'horizontal_sharing_replace_color_hover', 'horizontal_font_color_hover', 'sassy-social-share-hover-svg-horizontal' );
			wp_enqueue_style( 'heateor_sss_admin_svg_horizontal_hover', plugins_url( 'css/sassy-social-share-hover-svg-horizontal.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
		if ( $this->options['vertical_font_color_default'] != '' ) {
			$updated = $this->update_css( 'vertical_sharing_replace_color', 'vertical_font_color_default', 'sassy-social-share-default-svg-vertical' );
			wp_enqueue_style( 'heateor_sss_admin_svg_vertical', plugins_url( 'css/sassy-social-share-default-svg-vertical.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
		if ( $this->options['vertical_font_color_hover'] != '' ) {
			$updated = $this->update_css( 'vertical_sharing_replace_color_hover', 'vertical_font_color_hover', 'sassy-social-share-hover-svg-vertical' );
			wp_enqueue_style( 'heateor_sss_admin_svg_vertical_hover', plugins_url( 'css/sassy-social-share-hover-svg-vertical.css', __FILE__ ), false, ( $updated === true ? rand() :  $this->version ) );
		}
	
	}

	/**
	 * Update CSS file
	 *
	 * @since    1.0.0
	 */
	private function update_css( $replace_color_option, $logo_color_option, $css_file ) {
		
		if ( $this->options[$replace_color_option] != $this->options[$logo_color_option] ) {
			$path = plugin_dir_url( __FILE__ ) . 'css/' . $css_file . '.css';
			$content = file( $path );
			if ( $content !== false ) {
				$handle = fopen( dirname( __FILE__ ) . '/css/' . $css_file . '.css','w' );
				if ( $handle !== false ) {
					foreach ( $content as $value ) {
					    fwrite( $handle, str_replace( str_replace( '#', '%23', $this->options[$replace_color_option] ), str_replace( '#', '%23', $this->options[$logo_color_option] ), $value ) );
					}
					fclose( $handle );
					$this->options[$replace_color_option] = $this->options[$logo_color_option];
					update_option( 'heateor_sss', $this->options );
					return true;
				}
			}
		}
		return false;

	}

	/**
	 * Include javascript files in admin.
	 *
	 * @since    1.0.0
	 */	
	public function admin_scripts() {
		
		?>
		<script type="text/javascript">var heateorSssWebsiteUrl = '<?php echo site_url() ?>', heateorSssHelpBubbleTitle = "<?php echo __( 'Click to show help', 'sassy-social-share' ) ?>", heateorSssHelpBubbleCollapseTitle = "<?php echo __( 'Click to hide help', 'sassy-social-share' ) ?>", heateorSssSharingAjaxUrl = '<?php echo get_admin_url() ?>admin-ajax.php';</script>
		<?php
		wp_enqueue_script( 'heateor_sss_admin_script', plugins_url( 'js/sassy-social-share-admin.js', __FILE__ ), array( 'jquery', 'jquery-ui-tabs' ), $this->version );
	
	}

	/**
	 * Renders options page
	 *
	 * @since    1.0.0
	 */
	public function options_page() {

		// message on saving options
		echo $this->settings_saved_notification();
		$options = $this->options;
		/**
		 * The file rendering options page
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/sassy-social-share-options-page.php';
	
	}

	/**
	 * Display notification message when plugin options are saved
	 *
	 * @since    1.0.0
     * @return   string    Notification after saving options
	 */
	private function settings_saved_notification() {

		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) {
			return '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible below-h2"> 
	<p><strong>' . __( 'Settings saved', 'sassy-social-share' ) . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . __( 'Dismiss this notice', 'sassy-social-share' ) . '</span></button></div>';
		}
	
	}

	/**
	 * Check if WooCommerce is active
	 *
	 * @since    1.0.0
	 */
	private function is_woocommerce_active() {
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}

	/**
	 * Set BuddyPress active flag to true
	 *
	 * @since    1.0.0
	 */
	public function is_bp_loaded() {
		
		$this->is_bp_active = true;
	
	}

	/**
	 * Clear Bitly shorturl cache
	 *
	 * @since    1.7
	 */
	public function clear_shorturl_cache() {
		
		global $wpdb;
		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_heateor_sss_bitly_url'" );
		die;
	
	}

	/**
	 * Clear share counts cache
	 *
	 * @since    1.7
	 */
	public function clear_share_count_cache() {
		
		global $wpdb;
		$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_heateor_sss_share_count_%'" );
		die;
	
	}

	/**
	 * Ask reason to deactivate the plugin
	 *
	 * @since    2.0
	 */
	public function ask_reason_to_deactivate() {
		
		global $pagenow;
		if ( ! get_option( 'heateor_sss_feedback_submitted' ) && 'plugins.php' === $pagenow ) {
			?>
			<style type="text/css">
			#heateor_sss_sharing_more_providers{position:fixed;top:45%;left:47%;background:#FAFAFA;width:650px;margin:-180px 0 0 -300px;z-index:10000000;text-shadow:none!important;height:394px}#heateor_sss_popup_bg{background:url(<?php echo plugins_url( '../images/transparent_bg.png', __FILE__ ) ?>);bottom:0;display:block;left:0;position:fixed;right:0;top:0;z-index:10000}#heateor_sss_sharing_more_providers .title{font-size:14px!important;height:auto!important;background:#EC1B23!important;border-bottom:1px solid #D7D7D7!important;color:#fff;font-weight:700;letter-spacing:inherit;line-height:34px!important;padding:0!important;text-align:center;text-transform:none;margin:0!important;text-shadow:none!important;width:100%}#heateor_sss_sharing_more_providers *{font-family:Arial,Helvetica,sans-serif}#heateor_sss_sharing_more_content .form-table td{padding:4px 0;}#heateor_sss_sharing_more_providers #heateor_sss_sharing_more_content{background:#FAFAFA;border-radius:4px;color:#555;height:100%;width:100%}#heateor_sss_sharing_more_providers .filter{margin:0;padding:10px 0 0;position:relative;width:100%}#heateor_sss_sharing_more_providers .all-services{clear:both;height:421px;overflow:auto}#heateor_sss_sharing_more_content .all-services ul{margin:10px!important;overflow:hidden;list-style:none;padding-left:0!important;position:static!important;width:auto!important}#heateor_sss_sharing_more_content .all-services ul li{margin:0;background:0 0!important;float:left;width:33.3333%!important;text-align:left!important}#heateor_sss_sharing_more_providers .close-button img{margin:0;}#heateor_sss_sharing_more_providers .close-button.separated{background:0 0!important;border:none!important;box-shadow:none!important;width:auto!important;height:auto!important;z-index:1000}#heateor_sss_sharing_more_providers .close-button{height:auto!important;width:auto!important;left:auto!important;display:block!important;color:#555!important;cursor:pointer!important;font-size:29px!important;line-height:29px!important;margin:0!important;padding:0!important;position:absolute;right:-13px;top:-11px}#heateor_sss_sharing_more_providers .filter input.search{width:94%;display:block;float:none;font-family:"open sans","helvetica neue",helvetica,arial,sans-serif;font-weight:300;height:auto;line-height:inherit;margin:0 auto;padding:5px 8px 5px 10px;border:1px solid #ccc!important;color:#000;background:#FFF!important;font-size:16px!important;text-align:left!important}#heateor_sss_sharing_more_providers .footer-panel{background:#EC1B23!important;border-top:1px solid #D7D7D7;padding:6px 0;width:100%;color:#fff}#heateor_sss_sharing_more_providers .footer-panel p{background-color:transparent;top:0;text-align:left!important;color:#000;font-family:'helvetica neue',arial,helvetica,sans-serif;font-size:12px;line-height:1.2;margin:0!important;padding:0 6px!important;text-indent:0!important}#heateor_sss_sharing_more_providers .footer-panel a{color:#fff;text-decoration:none;font-weight:700;text-indent:0!important}#heateor_sss_sharing_more_providers .all-services ul li a{border-radius:3px;color:#666!important;display:block;font-size:18px;height:auto;line-height:28px;overflow:hidden;padding:8px;text-decoration:none!important;text-overflow:ellipsis;white-space:nowrap;border:none!important;text-indent:0!important;background:0 0!important;text-shadow:none;box-shadow:none!important}#heateor_sss_feedback_skip{background-color: #777;color:#fff;border: none;padding: 4px 28px;border-radius: 5px;cursor: pointer;}#heateor_sss_feedback_submit{color:#fff;background-color: #EC1B23; margin-right: 20px;border: none;padding: 4px 28px;border-radius: 5px;font-weight: bold;cursor: pointer}
				@media screen and (max-width:783px) {#heateor_sss_sharing_more_providers{width:80%;left:60%;margin-left:-50%;text-shadow:none!important}}
			</style>
			<script type="text/javascript">
			if (typeof String.prototype.trim!=="function") {String.prototype.trim=function() {return this.replace(/^\s+|\s+$/g,"")}}

			jQuery(function() {
				jQuery(document).on( 'click', 'tr#sassy-social-share span.deactivate a', function(event) {
					var deactivateUrl = jQuery(this).attr( 'href' );
					event.preventDefault();
					
					var theChampMoreSharingServicesHtml = '<h3 class="title ui-drag-handle"><?php _e( 'Please help us make the plugin better', 'sassy-social-share' ) ?></h3><button id="heateor_sss_sharing_popup_close" class="close-button separated"><img src="<?php echo plugins_url( '../images/close.png', __FILE__ ) ?>" /></button><div id="heateor_sss_sharing_more_content"><div class="all-services">';
					theChampMoreSharingServicesHtml += '<div class="metabox-holder columns-2" id="post-body" style="width:100%"><div class="stuffbox" style="margin-bottom:0"><h3><label><?php echo sprintf(__('Please take a look at our <a href="%s" target="_blank">support documentation</a> before deactivating the plugin', 'sassy-social-share'), 'http:\/\/support.heateor.com');?></label></h3><h3><label><?php _e( 'I am deactivating the plugin because', 'sassy-social-share' );?></label></h3><div class="inside"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table"><tr><td colspan="2"><label for="heateor_sss_reason_1"><input id="heateor_sss_reason_1" name="heateor_sss_deactivate_reason" type="radio" value="1" /><?php _e("I no longer need the plugin", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><label for="heateor_sss_reason_2"><input id="heateor_sss_reason_2" name="heateor_sss_deactivate_reason" type="radio" value="2" /><?php _e("I found a better plugin", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><label for="heateor_sss_reason_3"><input id="heateor_sss_reason_3" name="heateor_sss_deactivate_reason" type="radio" value="3" /><?php _e("I only needed the plugin for a short period", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><input id="heateor_sss_reason_4" name="heateor_sss_deactivate_reason" type="radio" value="4" /><label for="heateor_sss_reason_4"><?php _e("The plugin broke my site", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><input id="heateor_sss_reason_5" name="heateor_sss_deactivate_reason" type="radio" value="5" /><label for="heateor_sss_reason_5"><?php _e("The plugin suddenly stopped working", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><label for="heateor_sss_reason_6"><input id="heateor_sss_reason_6" name="heateor_sss_deactivate_reason" type="radio" value="6" /><?php _e("I couldn\'t understand how to make it work", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><label for="heateor_sss_reason_7"><input id="heateor_sss_reason_7" name="heateor_sss_deactivate_reason" type="radio" value="7" /><?php _e("The plugin is great, but I need specific feature that you don\'t support", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><input id="heateor_sss_reason_8" name="heateor_sss_deactivate_reason" type="radio" value="8" /><label for="heateor_sss_reason_8"><?php _e("The plugin is not working", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><label for="heateor_sss_reason_9"><input id="heateor_sss_reason_9" name="heateor_sss_deactivate_reason" type="radio" value="9" /><?php _e("It\'s not what I was looking for", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><label for="heateor_sss_reason_10"><input id="heateor_sss_reason_10" name="heateor_sss_deactivate_reason" type="radio" value="10" /><?php _e("The plugin didn\'t work as expected", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><input id="heateor_sss_reason_11" name="heateor_sss_deactivate_reason" type="radio" value="11" /><label for="heateor_sss_reason_11"><?php _e("Other", 'sassy-social-share' ); ?></label></td></tr><tr><td colspan="2"><input type="button" id="heateor_sss_feedback_submit" value="Submit" /><input type="button" id="heateor_sss_feedback_skip" value="Skip" /></td><td class="heateor_sss_loading"></td></tr></table></div></div></div>';
					var mainDiv = document.createElement( 'div' );
					mainDiv.innerHTML = theChampMoreSharingServicesHtml + '</div><div class="footer-panel"><p></p></div></div>';
					mainDiv.setAttribute( 'id', 'heateor_sss_sharing_more_providers' );
					var bgDiv = document.createElement( 'div' );
					bgDiv.setAttribute( 'id', 'heateor_sss_popup_bg' );
					jQuery( 'body' ).append(mainDiv).append(bgDiv);
					jQuery( 'input[name=heateor_sss_deactivate_reason]' ).click(function() {
						jQuery( 'div#heateor_sss_reason_details' ).remove();
						if (jQuery(this).val() == 2) {
							var label = 'Plugin name and download link';
						}else{
							var label = 'Details (Optional)';
						}
						jQuery(this).parent().append( '<div id="heateor_sss_reason_details"><label>'+ label +'</label><div style="clear:both"></div><textarea id="heateor_sss_reason_details_textarea" rows="5" cols="50"></textarea></div>' );
					});
					jQuery( 'input#heateor_sss_feedback_skip' ).click(function() {
						location.href = deactivateUrl;
					});
					jQuery( 'input#heateor_sss_feedback_submit' ).click(function() {
						var reason = jQuery( 'input[name=heateor_sss_deactivate_reason]:checked' );
						var details = typeof jQuery( '#heateor_sss_reason_details_textarea' ).val() != 'undefined' ? jQuery( '#heateor_sss_reason_details_textarea' ).val().trim() : '';
						if (reason.length == 0) {
							alert( '<?php _e("Please specify a vaild reason", "sassy-social-share") ?>' );
							return false;
						}
						reason = reason.val().trim();
						jQuery("#heateor_sss_feedback_submit").after( '<img style="margin-right:20px" src="<?php echo plugins_url( '../images/ajax_loader.gif', __FILE__ ) ?>" />' )
						jQuery.ajax({
					        type: "GET",
					        dataType: "json",
					        url: '<?php echo get_admin_url() ?>admin-ajax.php',
					        data: {
					            action: "heateor_sss_send_feedback",
					            reason: reason,
					            details: details
					        },
					        success: function(e) {
					            location.href = deactivateUrl;
					        },
					        error: function(e) {
					            location.href = deactivateUrl;
					        }
					    });
					});
					document.getElementById( 'heateor_sss_sharing_popup_close' ).onclick = function() {
						mainDiv.parentNode.removeChild(mainDiv);
						bgDiv.parentNode.removeChild(bgDiv);
					}
				});
			});
			</script>
			<?php
		}
	}

	/**
	 * Send feedback to heateor server
	 *
	 * @since    2.0
	 */
	public function send_feedback() {
		
		if ( isset( $_GET['reason'] ) && isset( $_GET['details'] ) ) {
			$reason = trim( esc_attr( $_GET['reason'] ) );
			$details = trim( esc_attr( $_GET['details'] ) );
			$querystring = array(
				'pid' => 8,
				'r' => $reason,
				'd' => $details
			);
			wp_remote_get( 'https://www.heateor.com/api/analytics/v1/save?' . http_build_query( $querystring ), array( 'timeout' => 15) );
			add_option( 'heateor_sss_feedback_submitted', '1' );
		}
		die;

	}

}
