<?php
/**
 * Recent Blog Widget.
 *
 * @package boka
 */

class Boka_Recent_Blog_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'boka-recent-blog-widget',
			__( 'boka Recent Blog Widget', 'boka' ),
			array(
				'description' => __( 'boka Recent Blog', 'boka' ),
			),
			array(),

			array(
				'layout_style' => array(
					'type' => 'select',
					'label' => __( 'Layout', 'boka' ),
					'default' => 'default',
					'options' => array(
						'default' => __( 'Default', 'boka' ),
						'two-column' => __( 'Two Columns', 'boka' )
					)
				),
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Heading', 'boka' ),
				),
				'post_limit' => array(
					'type' => 'number',
					'label' => __( 'Post Limit', 'boka' ),
                    'default' => '3'
				),
			)

		);
	}

	function get_template_name( $instance ) {
		return 'default';
	}
}

siteorigin_widget_register( 'boka-recent-blog-widget', __FILE__, 'Boka_Recent_Blog_Widget' );
