<?php
/**
 * Add / Edit Content Views
 *
 * @package   PT_Content_Views_Admin
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
// Check if using Wordpress version 3.7 or higher
$version_gt_37 = PT_CV_Functions::wp_version_compare( '3.7' );

$settings = array();

// Id of current view
$id = 0;

// Check if this is edit View page
if ( !empty( $_GET[ 'id' ] ) ) {
	$id = esc_sql( $_GET[ 'id' ] );

	if ( $id ) {
		global $pt_cv_admin_settings;
		$pt_cv_admin_settings	 = $settings				 = PT_CV_Functions::view_get_settings( $id );
	}
}

// Submit handle
PT_CV_Functions::view_submit();
?>

<div class="wrap form-horizontal pt-wrap">
	<?php do_action( PT_CV_PREFIX_ . 'admin_view_header' ); ?>

	<h2><?php echo esc_html( $id ? __( 'Edit View', PT_CV_TEXTDOMAIN ) : get_admin_page_title()  ); ?></h2>

	<?php
	if ( $id ) {
		?>
		<div>
			<div class="view-code">For page, widget... editor: <input class="form-control" style="width: 190px;background-color: #ADFFAD;margin-right: 50px;" type="text" value="[pt_view id=&quot;<?php echo $id ?>&quot;]" onclick="this.select()" readonly=""></div>
			<div class="view-code">For theme file: <input class="form-control" style="width: 370px;" type="text" value='&lt;?php echo do_shortcode("[pt_view id=<?php echo $id ?>]"); ?&gt;' onclick="this.select()" readonly=""></div>
			<?php echo apply_filters( PT_CV_PREFIX_ . 'view_actions', '<a class="btn btn-info pull-right" target="_blank" href="http://www.contentviewspro.com/?utm_source=client&utm_medium=view">Get Pro version</a>', $id ) ?>
		</div>
		<div class="clear"></div>
		<?php
	}
	?>

	<div class="preview-wrapper">
		<?php
		// Preview
		$options = array(
			array(
				'label'	 => array(
					'text' => __( 'Preview', PT_CV_TEXTDOMAIN ),
				),
				'params' => array(
					array(
						'type'		 => 'html',
						'name'		 => 'preview',
						'content'	 => PT_CV_Html::html_preview_box(),
						'desc'		 => __( 'To show output, please click <code>Show Preview</code> or <code>Update Preview</code> button. Otherwise, please click <code>Hide Preview</code> button', PT_CV_TEXTDOMAIN ),
					),
				),
			),
		);
		echo PT_Options_Framework::do_settings( $options, $settings );
		?>
	</div>

	<!-- Show Preview -->
	<a class="btn btn-success" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>show-preview"><?php _e( 'Show Preview', PT_CV_TEXTDOMAIN ); ?></a>

	<br>

	<!-- Settings form -->
	<form action="" method="POST" id="<?php echo esc_attr( PT_CV_PREFIX . 'form-view' ); ?>">

		<?php
		// Add nonce field
		wp_nonce_field( PT_CV_PREFIX_ . 'view_submit', PT_CV_PREFIX_ . 'form_nonce' );

		// Get post ID of this View
		$post_id	 = PT_CV_Functions::post_id_from_meta_id( $id );
		$view_object = $post_id ? get_post( $post_id ) : null;
		?>
		<!-- add hidden field -->
		<input type="hidden" name="<?php echo esc_attr( PT_CV_PREFIX . 'post-id' ); ?>" value="<?php echo esc_attr( $post_id ); ?>" />
		<input type="hidden" name="<?php echo esc_attr( PT_CV_PREFIX . 'view-id' ); ?>" value="<?php echo esc_attr( $id ); ?>" />
		<input type="hidden" name="<?php echo esc_attr( PT_CV_PREFIX . 'version' ); ?>" value="<?php echo apply_filters( PT_CV_PREFIX_ . 'view_version', 'free-' . PT_CV_VERSION ); ?>" />

		<?php
		// View title
		$options	 = array(
			array(
				'label'	 => array(
					'text' => __( 'View title', PT_CV_TEXTDOMAIN ),
				),
				'params' => array(
					array(
						'type'	 => 'text',
						'name'	 => 'view-title',
						'std'	 => isset( $view_object->post_title ) ? $view_object->post_title : '',
						'desc'	 => __( 'Enter a name to identify your views easily', PT_CV_TEXTDOMAIN ),
					),
				),
			),
		);
		echo PT_Options_Framework::do_settings( $options, $settings );
		?>
		<br>

		<!-- Save -->
		<div class="btn-cvp-action">
			<input type="submit" class="btn btn-primary pull-right <?php echo esc_attr( PT_CV_PREFIX ); ?>save-view" value="<?php _e( 'Save', PT_CV_TEXTDOMAIN ); ?>">
			<?php do_action( PT_CV_PREFIX_ . 'admin_more_buttons' ); ?>
		</div>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#<?php echo esc_attr( PT_CV_PREFIX ); ?>filter-settings" data-toggle="tab"><span class="glyphicon glyphicon-search"></span><?php _e( 'Filter Settings', PT_CV_TEXTDOMAIN ); ?>
				</a>
			</li>
			<li>
				<a href="#<?php echo esc_attr( PT_CV_PREFIX ); ?>display-settings" data-toggle="tab"><span class="glyphicon glyphicon-th-large"></span><?php _e( 'Display Settings', PT_CV_TEXTDOMAIN ); ?>
				</a>
			</li>
			<?php do_action( PT_CV_PREFIX_ . 'setting_tabs_header', $settings ); ?>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<!-- Filter Settings -->
			<div class="tab-pane active" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>filter-settings">
				<?php
				$options	 = array(
					// Content type
					array(
						'label'	 => array(
							'text' => __( 'Content type', PT_CV_TEXTDOMAIN ),
						),
						'params' => array(
							array(
								'type'		 => 'radio',
								'name'		 => 'content-type',
								'options'	 => PT_CV_Values::post_types(),
								'std'		 => 'post',
							),
						),
					),
					// Upgrade to Pro: Custom post type
					!get_option( 'pt_cv_version_pro' ) ? PT_CV_Settings::get_cvpro( __( 'Filter custom post type (product, event...)', PT_CV_TEXTDOMAIN ) ) : '',
					apply_filters( PT_CV_PREFIX_ . 'custom_filters', array() ),
					// Common Filters
					array(
						'label'			 => array(
							'text' => __( 'Common filters', PT_CV_TEXTDOMAIN ),
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => array(
									apply_filters( PT_CV_PREFIX_ . 'sticky_posts_setting', array() ),
									// Includes
									array(
										'label'	 => array(
											'text' => __( 'Include only', PT_CV_TEXTDOMAIN ),
										),
										'params' => array(
											array(
												'type'	 => 'text',
												'name'	 => 'post__in',
												'std'	 => '',
												'desc'	 => apply_filters( PT_CV_PREFIX_ . 'setting_post_in', __( 'List of post IDs to show (comma-separated values, for example: 1,2,3)', PT_CV_TEXTDOMAIN ) ),
											),
										),
									),
									apply_filters( PT_CV_PREFIX_ . 'include_extra_settings', array() ),
									// Excludes
									array(
										'label'		 => array(
											'text' => __( 'Exclude', PT_CV_TEXTDOMAIN ),
										),
										'params'	 => array(
											array(
												'type'	 => 'text',
												'name'	 => 'post__not_in',
												'std'	 => '',
												'desc'	 => apply_filters( PT_CV_PREFIX_ . 'setting_post_not_in', __( 'List of post IDs to exclude (comma-separated values, for example: 1,2,3)', PT_CV_TEXTDOMAIN ) ),
											),
										),
										'dependence' => array( 'post__in', '' ),
									),
									apply_filters( PT_CV_PREFIX_ . 'exclude_extra_settings', array() ),
									// Parent page
									array(
										'label'		 => array(
											'text' => __( 'Parent page', PT_CV_TEXTDOMAIN ),
										),
										'params'	 => array(
											array(
												'type'	 => 'number',
												'name'	 => 'post_parent',
												'std'	 => '',
												'desc'	 => apply_filters( PT_CV_PREFIX_ . 'setting_parent_page', __( 'Enter ID of parent page to show its children', PT_CV_TEXTDOMAIN ) ),
											),
										),
										'dependence' => array( 'content-type', 'page' ),
									),
									apply_filters( PT_CV_PREFIX_ . 'post_parent_settings', array() ),
									// Limit
									array(
										'label'	 => array(
											'text' => __( 'Limit', PT_CV_TEXTDOMAIN ),
										),
										'params' => array(
											array(
												'type'	 => 'number',
												'name'	 => 'limit',
												'std'	 => '10',
												'min'	 => '1',
												'desc'	 => __( 'The number of posts to show. Set empty to show all found posts', PT_CV_TEXTDOMAIN ),
											),
										),
									),
									// Upgrade to Pro: Offset
									apply_filters( PT_CV_PREFIX_ . 'after_limit_option', PT_CV_Settings::get_cvpro( __( 'Skip some posts', PT_CV_TEXTDOMAIN ), 12 ) ),
								),
							),
						),
					), // End Common Filters
					// Advanced Filters
					array(
						'label'			 => array(
							'text' => __( 'Advanced filters', PT_CV_TEXTDOMAIN ),
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
								'wrap-id'	 => PT_CV_Html::html_group_id( 'advanced-params' ),
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => array(
									array(
										'label'			 => array(
											'text' => '',
										),
										'extra_setting'	 => array(
											'params' => array(
												'width' => 12,
											),
										),
										'params'		 => array(
											array(
												'type'		 => 'checkbox',
												'name'		 => 'advanced-settings[]',
												'options'	 => PT_CV_Values::advanced_settings(),
												'std'		 => '',
												'class'		 => 'advanced-settings-item',
											),
										),
									),
								),
							),
						),
					), // End Advanced Filters
					// Settings of Advanced Filters options
					array(
						'label'			 => array(
							'text' => '',
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_panel_group_class(),
								'wrap-id'	 => PT_CV_Html::html_panel_group_id( PT_CV_Functions::string_random() ),
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'panel_group',
								'params' => apply_filters( PT_CV_PREFIX_ . 'advanced_settings_panel', array(
									// Taxonomies Settings
									'taxonomy'	 => array(
										// Taxonomies list
										array(
											'label'			 => array(
												'text' => __( 'Taxonomies', PT_CV_TEXTDOMAIN ),
											),
											'extra_setting'	 => array(
												'params' => array(
													'wrap-class' => PT_CV_PREFIX . 'taxonomies',
												),
											),
											'params'		 => array(
												array(
													'type'		 => 'checkbox',
													'name'		 => 'taxonomy[]',
													'options'	 => PT_CV_Values::taxonomy_list(),
													'std'		 => '',
													'class'		 => 'taxonomy-item',
													'desc'		 => __( 'Check the boxes to show settings', PT_CV_TEXTDOMAIN ),
												),
											),
										),
										// Upgrade to Pro: Custom taxonomy
										!get_option( 'pt_cv_version_pro' ) ? PT_CV_Settings::get_cvpro( __( 'Filter by custom taxonomies', PT_CV_TEXTDOMAIN ) ) : '',
										// Terms list
										array(
											'label'			 => array(
												'text' => __( 'Terms', PT_CV_TEXTDOMAIN ),
											),
											'extra_setting'	 => array(
												'params' => array(
													'wrap-class' => PT_CV_Html::html_panel_group_class() . ' terms',
													'wrap-id'	 => PT_CV_Html::html_panel_group_id( PT_CV_Functions::string_random() ),
												),
											),
											'params'		 => array(
												array(
													'type'		 => 'panel_group',
													'settings'	 => array(
														'nice_name' => PT_CV_Values::taxonomy_list(),
													),
													'params'	 => PT_CV_Settings::terms_of_taxonomies(),
												),
											),
										),
										// Relation of taxonomies
										array(
											'label'	 => array(
												'text' => __( 'Relation', PT_CV_TEXTDOMAIN ),
											),
											'params' => array(
												array(
													'type'		 => 'select',
													'name'		 => 'taxonomy-relation',
													'options'	 => PT_CV_Values::taxonomy_relation(),
													'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values::taxonomy_relation() ),
													'class'		 => 'taxonomy-relation',
												),
											),
										),
										!get_option( 'pt_cv_version_pro' ) ? PT_CV_Settings::get_cvpro( sprintf( '<br>' . __( 'When you select any term above, it will not replace posts layout in term page (for example: %s) with layout of this View', PT_CV_TEXTDOMAIN ), '<code style="font-size: 11px;">http://yourdomain/category/selected_term/</code>' ), 12, null, true ) : '',
										apply_filters( PT_CV_PREFIX_ . 'taxonomies_custom_settings', array() ),
									), // End Taxonomies Settings
									// Order by Settings
									'order'		 => array(
										array(
											'label'			 => array(
												'text' => __( 'Order by', PT_CV_TEXTDOMAIN ),
											),
											'extra_setting'	 => array(
												'params' => array(
													'width' => 12,
												),
											),
											'params'		 => array(
												array(
													'type'		 => 'panel_group',
													'settings'	 => array(
														'show_all' => 1,
													),
													'params'	 => PT_CV_Settings::orderby(),
												),
											),
										),
									), // End Order by Settings
									// Author Settings
									'author'	 => apply_filters( PT_CV_PREFIX_ . 'author_settings', array(
										array(
											'label'	 => array(
												'text' => __( 'Written by', PT_CV_TEXTDOMAIN ),
											),
											'params' => array(
												array(
													'type'		 => 'select',
													'name'		 => 'author__in[]',
													'options'	 => PT_CV_Values::user_list(),
													'std'		 => '',
													'class'		 => 'select2',
													'multiple'	 => $version_gt_37 ? '1' : '0',
												),
											),
										),
										$version_gt_37 ?
											array(
											'label'	 => array(
												'text' => __( 'Not written by', PT_CV_TEXTDOMAIN ),
											),
											'params' => array(
												array(
													'type'		 => 'select',
													'name'		 => 'author__not_in[]',
													'options'	 => PT_CV_Values::user_list(),
													'std'		 => '',
													'class'		 => 'select2',
													'multiple'	 => $version_gt_37 ? '1' : '0',
												),
											),
											) : array(),
									) ), // End Author Settings
									// Status Settings
									'status'	 => array(
										array(
											'label'	 => array(
												'text' => __( 'Status', PT_CV_TEXTDOMAIN ),
											),
											'params' => array(
												array(
													'type'		 => 'select',
													'name'		 => 'post_status',
													'options'	 => PT_CV_Values::post_statuses(),
													'std'		 => 'publish',
													'class'		 => 'select2',
													'multiple'	 => '1',
												),
											),
										),
									), // End Status Settings
									// Keyword Settings
									'search'	 => array(
										array(
											'label'	 => array(
												'text' => __( 'Keyword', PT_CV_TEXTDOMAIN ),
											),
											'params' => array(
												array(
													'type'	 => 'text',
													'name'	 => 's',
													'std'	 => '',
													'desc'	 => __( 'Enter the keyword to searching for posts', PT_CV_TEXTDOMAIN ) . apply_filters( PT_CV_PREFIX_ . 'searchby_keyword_desc', '' ),
												),
											),
										),
									), // End Keyword Settings
									)
								),
							),
						),
					),
				);
				echo PT_Options_Framework::do_settings( $options, $settings );
				?>
			</div>
			<!-- end Filter Settings -->

			<!-- Display Settings -->
			<div class="tab-pane" id="<?php echo esc_attr( PT_CV_PREFIX ); ?>display-settings">
				<?php
				$options	 = array(
					// View Type
					array(
						'label'	 => array(
							'text' => __( 'View type (Layout)', PT_CV_TEXTDOMAIN ),
						),
						'params' => array(
							array(
								'type'		 => 'radio',
								'name'		 => 'view-type',
								'options'	 => PT_CV_Values::view_type(),
								'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values::view_type() ),
							),
						),
					),
					// View settings
					array(
						'label'	 => array(
							'text' => __( 'View type settings', PT_CV_TEXTDOMAIN ),
						),
						'params' => array(
							array(
								'type'		 => 'panel_group',
								'settings'	 => array(
									'no_panel'		 => 1,
									'show_only_one'	 => 1,
								),
								'params'	 => PT_CV_Values::view_type_settings(),
							),
						),
					),
					apply_filters( PT_CV_PREFIX_ . 'responsive_settings', array() ),
					// Layout format of output item
					array(
						'label'			 => array(
							'text' => __( 'Layout format', PT_CV_TEXTDOMAIN ),
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => array(
									array(
										'label'			 => array(
											'text' => '',
										),
										'extra_setting'	 => array(
											'params' => array(
												'width' => 12,
											),
										),
										'params'		 => array(
											array(
												'type'		 => 'radio',
												'name'		 => 'layout-format',
												'options'	 => PT_CV_Values::layout_format(),
												'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values::layout_format() ),
											),
										),
									),
									array(
										'label'			 => array(
											'text' => '',
										),
										'extra_setting'	 => array(
											'params' => array(
												'width' => 12,
											),
										),
										'params'		 => array(
											array(
												'type'		 => 'checkbox',
												'name'		 => 'lf-mobile-disable',
												'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Disable this format on mobile devices & extra small screens', PT_CV_TEXTDOMAIN ) ),
												'std'		 => '',
											),
										),
										'dependence'	 => array( 'layout-format', '2-col' ),
									),
								),
							),
						),
					),
					// Fields settings
					array(
						'label'			 => array(
							'text' => __( 'Fields settings', PT_CV_TEXTDOMAIN ),
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
								'wrap-id'	 => PT_CV_Html::html_group_id( 'field-settings' ),
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => PT_CV_Settings::field_settings(),
							),
						),
					),
					// Pagination settings
					array(
						'label'			 => array(
							'text' => __( 'Pagination settings', PT_CV_TEXTDOMAIN ),
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => PT_CV_Settings::settings_pagination(),
							),
						),
					),
					// Other settings
					array(
						'label'			 => array(
							'text' => __( 'Other settings', PT_CV_TEXTDOMAIN ),
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => PT_CV_Settings::settings_other(),
							),
						),
					),
				);

				$options = apply_filters( PT_CV_PREFIX_ . 'display_settings', $options );
				echo PT_Options_Framework::do_settings( $options, $settings );
				?>
			</div>
			<!-- end Display Settings -->

			<?php
			do_action( PT_CV_PREFIX_ . 'setting_tabs_content', $settings );
			?>

		</div>

		<div class="clearfix"></div>
		<hr>
		<!-- Save -->
		<input type="submit" class="btn btn-primary pull-right <?php echo esc_attr( PT_CV_PREFIX ); ?>save-view" value="<?php _e( 'Save', PT_CV_TEXTDOMAIN ); ?>">
	</form>
</div>
