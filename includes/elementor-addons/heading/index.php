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

class Boka_Title extends Widget_Base {

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
        return 'Title';
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
        return __( 'Title', 'boka' );
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
            'boka_title_section',
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
            'title',
            [
                'label' => __( 'Title', 'boka' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Introducing BOKA Classic Demo', 'boka' ),
            ]
        );
        $this->add_control(
            'paragraph',
            [
                'label' => __( 'Paragraph', 'boka' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Default description', 'boka' )
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
        <div class="boka-heading text-<?php echo esc_attr( $settings['text_alignment'] ); ?>">
            <h2 class="margin-bottom-30 margin-null"><?php echo esc_html( $settings['title'] ); ?></h2>
            <div class="lead-text"><?php echo $settings['paragraph']; ?></div>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <div class="boka-heading text-{{{ settings.text_alignment }}}">
            <h2 class="margin-bottom-30 margin-null">{{{ settings.title }}}</h2>
            <div class="lead-text">{{{ settings.paragraph }}}</div>
        </div>
        <?php
    }


}

Plugin::instance()->widgets_manager->register( new Boka_Title() );