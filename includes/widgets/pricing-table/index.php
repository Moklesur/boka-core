<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Pricing_Table
 *
 * @since 1.0.0
 */

class bring_back_Pricing_Table extends Widget_Base {

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
        return 'boka-price-table';
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
        return __( 'Pricing Table', 'boka' );
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
        return 'fas fa-table';
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
        return [ 'bring_back' ];
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
            'Pricing_Table_section',
            [
                'label' => __( 'Setting', 'boka' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'name', [
                'label' => __( 'Plan Name', 'boka' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'price', [
                'label' => __( 'Price', 'boka' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'content', [
                'label' => __( 'Content', 'boka' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'label_block' => true,
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
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->add_control(
            'list',
            [
                'label' => __( 'Pricing Table', 'boka' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
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

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $list = $settings['list'];

        if ( $list ) { ?>

            <div class="pricing-slider">
                <?php

                foreach ( $list as $item ) {
                    ?>
                    <div class="item">
                        <!-- .pricing-item start -->
                        <div class="pricing-item">
                            <?php  if ( esc_html( $item['name'] ) != '' ) { ?>
                                <p class="text-uppercase pricing-title mb-30"><?php echo esc_html( $item['name'] ); ?></p>
                            <?php }

                            if ( esc_html( $item['price'] ) != '' ) { ?>
                                <h2 class="pricing-price m-0"><?php echo esc_html( $item['price'] ); ?></h2>
                            <?php }

                            if ( esc_html( $item['content'] ) != '' ) { ?>
                                <div class="pricing-content">
                                    <?php

                                    echo wp_kses(
                                        $item['content'],
                                        array(
                                            'a' => array(
                                                'href' => array(),
                                                'title' => array()
                                            ),
                                            'p' => array(),
                                            'h2' => array(),
                                            'h3' => array(),
                                            'h4' => array(),
                                            'h5' => array(),
                                            'h6' => array(),
                                            'ul' => array(),
                                            'li' => array(),
                                            'strong' => array(),
                                            'span' => array(),
                                            'br' => array()
                                        )
                                    );
                                    ?>
                                </div>
                            <?php }

                            if ( esc_html( $item['btn_text'] ) != '' ) { ?>
                                <a href="<?php echo esc_url( $item['btn_url']['url'] ); ?>" class="btn"><?php echo esc_html( $item['btn_text'] ); ?></a>
                            <?php } ?>
                        </div>
                        <!-- .pricing-item end -->
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register( new bring_back_Pricing_Table() );