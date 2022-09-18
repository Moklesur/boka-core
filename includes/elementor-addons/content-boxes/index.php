<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Blog block
 *
 * @since 1.0.0
 */

class Boka_Content_Boxes extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'Content Boxes';
    }

    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */

    public function get_title() {
        return __( 'Content Boxes', 'boka' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve oEmbed widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */

    public function get_icon() {
        return 'fa fa-cog';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */

    public function get_categories() {
        return [ 'boka' ];
    }


    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function register_controls() {

        $this->start_controls_section(
            'boka_content_boxes_section',
            [
                'label' => __( 'Setting', 'boka' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text_alignment',
            [
                'label' => __( 'Text Alignment', 'boka' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'boka' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'boka' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'boka' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'columns', [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => __( 'Columns', 'boka' ),
                'default' => __( '4' , 'boka' ),
                'options' => array(
                    '6' => __( 'Six', 'boka' ),
                    '4' => __( 'Three', 'boka' ),
                    '3' => __( 'Four', 'boka' )
                ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'block_content_divider',
            [
                'label' => __( 'Block Content', 'boka' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'media_icon',
            [
                'label' => __( 'Media or Icon?', 'boka' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'media' => [
                        'title' => __( 'Image', 'boka' ),
                        'icon' => 'fa fa-picture-o',
                    ],
                    'icon' => [
                        'title' => __( 'Icon', 'boka' ),
                        'icon' => 'fa fa-font',
                    ]
                ],
                'default' => 'media',
                'toggle' => true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'boka' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => __( 'Choose Icon', 'boka' ),
                'type' => \Elementor\Controls_Manager::ICON,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'iconColor', [
                'label' => __( 'Icon Color', 'boka' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-box .fa' => 'color: {{VALUE}}',
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __( 'Title', 'boka' ),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __( 'Content', 'boka' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'btn_text',
            [
                'label' => __( 'Button Text', 'boka' ),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'btn_url',
            [
                'label' => __( 'Button URL', 'boka' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'boka' ),
                'show_external' => true,
                'default' => [
                    'url' => '#'
                ],
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __( 'Items', 'boka' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __( 'Title', 'boka' )
                    ]
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function render() {
        $settings = $this->get_settings_for_display();

        ?>

        <div class="boka-content-box text-<?php echo esc_attr( $settings['text_alignment'] ); ?>">

            <?php foreach( $settings['list'] as $i => $contentBox ) : ?>
                <div class="col-md-<?php echo esc_attr( $settings['columns'] ); ?> col-sm-<?php echo esc_attr( $settings['columns'] ); ?> col-xs-12 margin-top-30">
                    <div class="content-box">
                        <?php
                        if ( $contentBox['media_icon'] == 'icon' ) :

                            if ( ! empty( $contentBox['icon'] ) ):
                                ?>
                                <div class="margin-bottom-30">
                                    <i class="fa <?php echo esc_attr( $contentBox['icon'] ); ?>"></i>
                                </div>
                            <?php
                            endif;
                        else :
                            if ( ! empty( $contentBox['image']['url'] ) ):
                                ?>
                                <img src="<?php echo esc_url( $contentBox['image']['url'] ); ?>" class="margin-bottom-30">
                            <?php
                            endif;
                        endif;

                        if ( ! empty( $contentBox['title'] ) ) : ?>
                            <h3 class="margin-null margin-bottom-30 font-weight-400"><?php echo esc_html( $contentBox['title'] ); ?></h3>
                        <?php endif;

                        if ( ! empty( $contentBox['content'] ) ) : ?>
                            <p class="margin-null"><?php echo esc_html( $contentBox['content'] ); ?></p>
                        <?php endif;

                        if ( ! empty( $contentBox['btn_text'] ) ) : ?>
                            <p class="margin-top-10 margin-null">
                                <a href="<?php echo esc_url( $contentBox['btn_url']['url'] ); ?>" class="read-more"><?php echo esc_html( $contentBox['btn_text'] ); ?> →</a>
                            </p>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
    }

    protected function _content_template() {
        ?>
        <# if ( settings.list.length ) { #>
        <div class="boka-content-box text-{{{ settings.text_alignment }}}">

            <# _.each( settings.list, function( item ) { #>

            <div class="col-md-{{{ settings.columns }}} col-sm-{{{ settings.columns }}} col-xs-12 margin-top-30">
                <div class="content-box">

                    <# if ( item.media_icon == 'icon' ) { #>
                    <div class="margin-bottom-30">
                        <i class="fa {{{ item.icon }}}"></i>
                    </div>
                    <# } #>

                    <# if ( item.media_icon == 'image' ) { #>
                    <div class="margin-bottom-30">
                        <img src="{{{ item.image.url] }}}" class="margin-bottom-30">
                    </div>
                    <# } #>

                    <# if ( item.title ) { #>
                    <h3 class="margin-null margin-bottom-30 font-weight-400">{{{ item.title }}}</h3>
                    <# } #>
                    <# if ( item.content ) { #>
                    <p class="margin-null">{{{ item.content }}}</p>
                    <# } #>
                    <# if ( item.btn_text ) { #>
                    <p class="margin-top-10 margin-null">
                        <a href="{{ item.btn_text.url }}" class="read-more">{{ item.btn_text }}  →</a>
                    </p>
                    <# } #>

                </div>
            </div>

            <# }); #>

        </div>
        <# } #>
        <?php
    }

}

Plugin::instance()->widgets_manager->register( new Boka_Content_Boxes() );