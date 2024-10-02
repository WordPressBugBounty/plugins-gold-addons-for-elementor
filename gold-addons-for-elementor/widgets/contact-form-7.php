<?php
/**
 * Blog
 *
 * The GoldAddons Blog widget for Elementor.
 *
 * @package GoldAddons
 * @subpackage GoldAddons for Elementor
 * @since 1.1.5
 */

namespace GoldAddons\Widget;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

use GoldAddons\Helper;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;

class Contact_Form_7 extends Widget_Base {
    /**
     * Retrieve contact form 7 widget name.
     *
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'goldaddons-contact-form-7';
    }

    /**
     * Retrieve contact form 7 widget title.
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Contact Form 7', 'gold-addons-for-elementor' );
    }

    /**
     * Retrieve the list of categories the contact form 7 widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['gold-addons-for-elementor'];
    }

    /**
     * Retrieve contact form 7 widget icon.
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-email-field';
    }

    /**
     * Get keywords.
     * 
     * @since 1.1.5
     * @access public
     * @return array
     */
    public function get_keywords() {
        return [
            'contact form',
            'ga contact form',
            'form styler',
            'elementor form',
            'feedback',
            'cf7',
            'ga cf7',
            'ga contact form 7',
            'ga',
            'gold addons',
            'goldaddons'
        ];
    }

    /**
     * Get style depends.
     * 
     * @since 1.1.5
     * @access public
     * @return array
     */
    public function get_style_depends() {
        return [
            'goldaddons-general',
            'goldaddons-contact-form-7'
        ];
    }

    /**
     * Register contact form 7 widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @access protected
     */
    protected function register_controls() {
        /*-----------------------------------------------------------------------------------*/
        /*    CONTENT TAB
        /*-----------------------------------------------------------------------------------*/
        if ( ! function_exists( 'wpcf7' ) ) {
            $this->start_controls_section(
                'global_warning',
                [
                    'label' => __( 'Warning!', 'gold-addons-for-elementor' ),
                ]
            );

            $this->add_control(
                'global_warning_text',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __( '<strong>Contact Form 7</strong> is not installed/activated on your site. Please install and activate <strong>Contact Form 7</strong> first.', 'gold-addons-for-elementor' ),
                    'content_classes' => 'ga-warning',
                ]
            );

            $this->end_controls_section();
        } else {
            /**
             * Content Tab: Contact Form
             * -------------------------------------------------
             */
            $this->start_controls_section(
                'section_info_box',
                [
                    'label' => __( 'Contact Form', 'gold-addons-for-elementor' ),
                ]
            );

            $this->add_control(
                'contact_form_list',
                [
                    'label' => esc_html__( 'Select Form', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => Helper::get_wpcf7_list(),
                    'default' => '0',
                ]
            );

            $this->add_control(
                'form_title',
                [
                    'label' => __( 'Form Title', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'On', 'gold-addons-for-elementor' ),
                    'label_off' => __( 'Off', 'gold-addons-for-elementor' ),
                    'return_value' => 'yes',
                ]
            );

            $this->add_control(
                'form_title_text',
                [
                    'label' => esc_html__( 'Title', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'label_block' => true,
                    'default' => '',
                    'condition' => [
                        'form_title' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'form_description',
                [
                    'label' => __( 'Form Description', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'On', 'gold-addons-for-elementor' ),
                    'label_off' => __( 'Off', 'gold-addons-for-elementor' ),
                    'return_value' => 'yes',
                ]
            );

            $this->add_control(
                'form_description_text',
                [
                    'label' => esc_html__( 'Description', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => '',
                    'condition' => [
                        'form_description' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'labels_switch',
                [
                    'label' => __( 'Labels', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_on' => __( 'Show', 'gold-addons-for-elementor' ),
                    'label_off' => __( 'Hide', 'gold-addons-for-elementor' ),
                    'return_value' => 'yes',
                ]
            );

            $this->end_controls_section();

            /**
             * Content Tab: Errors
             * -------------------------------------------------
             */
            $this->start_controls_section(
                'section_errors',
                [
                    'label' => __( 'Errors', 'gold-addons-for-elementor' ),
                ]
            );

            $this->add_control(
                'error_messages',
                [
                    'label' => __( 'Error Messages', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'show',
                    'options' => [
                        'show' => __( 'Show', 'gold-addons-for-elementor' ),
                        'hide' => __( 'Hide', 'gold-addons-for-elementor' ),
                    ],
                    'selectors_dictionary' => [
                        'show' => 'block',
                        'hide' => 'none',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ga-contact-form-7 .wpcf7-not-valid-tip' => 'display: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_control(
                'validation_errors',
                [
                    'label' => __( 'Validation Errors', 'gold-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'show',
                    'options' => [
                        'show' => __( 'Show', 'gold-addons-for-elementor' ),
                        'hide' => __( 'Hide', 'gold-addons-for-elementor' ),
                    ],
                    'selectors_dictionary' => [
                        'show' => 'block',
                        'hide' => 'none',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ga-contact-form-7 .wpcf7-validation-errors' => 'display: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        /*-----------------------------------------------------------------------------------*/
        /*    STYLE TAB
        /*-----------------------------------------------------------------------------------*/
        /**
         * Style Tab: Form Container
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_container_style',
            [
                'label' => __( 'Form Container', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'contact_form_background',
                'label' => __( 'Background', 'gold-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .ga-contact-form',
            ]
        );

        $this->add_responsive_control(
            'contact_form_alignment',
            [
                'label' => esc_html__( 'Form Alignment', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options' => [
                    'default' => [
                        'title' => __( 'Default', 'gold-addons-for-elementor' ),
                        'icon' => 'fa fa-ban',
                    ],
                    'left' => [
                        'title' => esc_html__( 'Left', 'gold-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'gold-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'gold-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'default',
            ]
        );

        $this->add_responsive_control(
            'contact_form_max_width',
            [
                'label' => esc_html__( 'Form Max Width', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1500,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7-wrapper .ga-contact-form.ga-contact-form-7' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'contact_form_margin',
            [
                'label' => esc_html__( 'Margin', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'contact_form_padding',
            [
                'label' => esc_html__( 'Form Padding', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'contact_form_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'contact_form_border',
                'selector' => '{{WRAPPER}} .ga-contact-form',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'contact_form_box_shadow',
                'selector' => '{{WRAPPER}} .ga-contact-form',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Title & Description
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_fields_title_description',
            [
                'label' => __( 'Title & Description', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'heading_alignment',
            [
                'label' => __( 'Alignment', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'gold-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'gold-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'gold-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .ga-contact-form-7-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => __( 'Title', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .ga-contact-form-7-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .ga-contact-form-7-title',
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
            ]
        );

        $this->add_control(
            'description_heading',
            [
                'label' => __( 'Description', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_text_color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .ga-contact-form-7-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .ga-contact-form-7-description',
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Input & Textarea
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_fields_style',
            [
                'label' => __( 'Input & Textarea', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_fields_style' );

        $this->start_controls_tab(
            'tab_fields_normal',
            [
                'label' => __( 'Normal', 'gold-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'field_bg',
            [
                'label' => __( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'field_text_color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select, {{WRAPPER}} .ga-contact-form-7 .wpcf7-list-item-label' => 'color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'input_spacing',
            [
                'label' => __( 'Spacing', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '0',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form p:not(:last-of-type) .wpcf7-form-control-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label' => __( 'Padding', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_indent',
            [
                'label' => __( 'Text Indent', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'text-indent: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_width',
            [
                'label' => __( 'Input Width', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_height',
            [
                'label' => __( 'Input Height', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'textarea_width',
            [
                'label' => __( 'Textarea Width', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'textarea_height',
            [
                'label' => __( 'Textarea Height', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'label' => __( 'Border', 'gold-addons-for-elementor' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_radius',
            [
                'label' => __( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-date, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select',
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_box_shadow',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-text, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-quiz, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-textarea, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control.wpcf7-select',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_fields_focus',
            [
                'label' => __( 'Focus', 'gold-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'field_bg_focus',
            [
                'label' => __( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form textarea:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'input_border_focus',
                'label' => __( 'Border', 'gold-addons-for-elementor' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form textarea:focus',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'focus_box_shadow',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input:focus, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form textarea:focus',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Label Section
         */
        $this->start_controls_section(
            'section_label_style',
            [
                'label' => __( 'Labels', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'labels_switch' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_error_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __( 'if <strong>label</strong> spacing doesn\'t worked, please update <strong>label</strong> display', 'gold-addons-for-elementor' ),
                'content_classes' => 'ga-warning',
            ]
        );
        $this->add_control(
            'label_disply_type',
            [
                'label' => __( 'Display', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __( 'Default', 'gold-addons-for-elementor' ),
                    'inherit' => __( 'Inherit', 'gold-addons-for-elementor' ),
                    'initial' => __( 'Initial', 'gold-addons-for-elementor' ),
                    'inline' => __( 'Inline', 'gold-addons-for-elementor' ),
                    'inline-block' => __( 'Inline Block', 'gold-addons-for-elementor' ),
                    'flex' => __( 'Flex', 'gold-addons-for-elementor' ),
                    'inline-flex' => __( 'Inline Flex', 'gold-addons-for-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form label, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form .wpcf7-quiz-label' => 'display: {{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'text_color_label',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form label' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ga-contact-form-7 label' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'labels_switch' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_spacing',
            [
                'label' => __( 'Spacing', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form label, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form .wpcf7-quiz-label' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'labels_switch' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_label',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form label, {{WRAPPER}} .ga-contact-form-7 .wpcf7-form .wpcf7-quiz-label',
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
                'condition' => [
                    'labels_switch' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Placeholder Section
         */
        $this->start_controls_section(
            'section_placeholder_style',
            [
                'label' => __( 'Placeholder', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'placeholder_switch',
            [
                'label' => __( 'Show Placeholder', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __( 'Yes', 'gold-addons-for-elementor' ),
                'label_off' => __( 'No', 'gold-addons-for-elementor' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'text_color_placeholder',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'placeholder_switch' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_placeholder',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form-control::-webkit-input-placeholder',
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
                'condition' => [
                    'placeholder_switch' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Radio & Checkbox
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_radio_checkbox_style',
            [
                'label' => __( 'Radio & Checkbox', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'custom_radio_checkbox',
            [
                'label' => __( 'Custom Styles', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'gold-addons-for-elementor' ),
                'label_off' => __( 'No', 'gold-addons-for-elementor' ),
                'return_value' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'radio_checkbox_size',
            [
                'label' => __( 'Size', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '15',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .ga-custom-radio-checkbox input[type="radio"]' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_radio_checkbox_style' );

        $this->start_controls_tab(
            'radio_checkbox_normal',
            [
                'label' => __( 'Normal', 'gold-addons-for-elementor' ),
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_checkbox_color',
            [
                'label' => __( 'Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .ga-custom-radio-checkbox input[type="radio"]' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'radio_checkbox_border_width',
            [
                'label' => __( 'Border Width', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 15,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .ga-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .ga-custom-radio-checkbox input[type="radio"]' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_checkbox_border_color',
            [
                'label' => __( 'Border Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .ga-custom-radio-checkbox input[type="radio"]' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'checkbox_heading',
            [
                'label' => __( 'Checkbox', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'checkbox_border_radius',
            [
                'label' => __( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-custom-radio-checkbox input[type="checkbox"], {{WRAPPER}} .ga-custom-radio-checkbox input[type="checkbox"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_heading',
            [
                'label' => __( 'Radio Buttons', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_border_radius',
            [
                'label' => __( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ga-custom-radio-checkbox input[type="radio"], {{WRAPPER}} .ga-custom-radio-checkbox input[type="radio"]:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'radio_checkbox_checked',
            [
                'label' => __( 'Checked', 'gold-addons-for-elementor' ),
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'radio_checkbox_color_checked',
            [
                'label' => __( 'Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-custom-radio-checkbox input[type="checkbox"]:checked:before, {{WRAPPER}} .ga-custom-radio-checkbox input[type="radio"]:checked:before' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'custom_radio_checkbox' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Submit Button
         */
        $this->start_controls_section(
            'section_submit_button_style',
            [
                'label' => __( 'Submit Button', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => __( 'Alignment', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'gold-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'gold-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'gold-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form p:nth-last-of-type(1)' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]' => 'display:inline-block;',
                ],
                'condition' => [
                    'button_width_type' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'button_width_type',
            [
                'label' => __( 'Width', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'full-width' => __( 'Full Width', 'gold-addons-for-elementor' ),
                    'custom' => __( 'Custom', 'gold-addons-for-elementor' ),
                ],
                'prefix_class' => 'ga-contact-form-7-button-',
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => __( 'Width', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_width_type' => 'custom',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'gold-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label' => __( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_normal',
                'label' => __( 'Border', 'gold-addons-for-elementor' ),
                'default' => '1px',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __( 'Border Radius', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __( 'Padding', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => __( 'Margin Top', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]',
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'gold-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => __( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label' => __( 'Border Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-form input[type="submit"]:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Errors
         */
        $this->start_controls_section(
            'section_error_style',
            [
                'label' => __( 'Errors', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'error_messages_heading',
            [
                'label' => __( 'Error Messages', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_error_messages_style' );

        $this->start_controls_tab(
            'tab_error_messages_alert',
            [
                'label' => __( 'Alert', 'gold-addons-for-elementor' ),
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->add_control(
            'error_alert_text_color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-not-valid-tip' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->add_responsive_control(
            'error_alert_spacing',
            [
                'label' => __( 'Spacing', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-not-valid-tip' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_error_messages_fields',
            [
                'label' => __( 'Fields', 'gold-addons-for-elementor' ),
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->add_control(
            'error_field_bg_color',
            [
                'label' => __( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-not-valid' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->add_control(
            'error_field_color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-not-valid' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'error_field_border',
                'label' => __( 'Border', 'gold-addons-for-elementor' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-not-valid',
                'separator' => 'before',
                'condition' => [
                    'error_messages' => 'show',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'validation_errors_heading',
            [
                'label' => __( 'Validation Errors', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'validation_errors' => 'show',
                ],
            ]
        );

        $this->add_control(
            'validation_errors_bg_color',
            [
                'label' => __( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-validation-errors' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'validation_errors' => 'show',
                ],
            ]
        );

        $this->add_control(
            'validation_errors_color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-validation-errors' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'validation_errors' => 'show',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'validation_errors_typography',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-validation-errors',
                'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
                'separator' => 'before',
                'condition' => [
                    'validation_errors' => 'show',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'validation_errors_border',
                'label' => __( 'Border', 'gold-addons-for-elementor' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-validation-errors',
                'separator' => 'before',
                'condition' => [
                    'validation_errors' => 'show',
                ],
            ]
        );

        $this->add_responsive_control(
            'validation_errors_margin',
            [
                'label' => __( 'Margin', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-validation-errors' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'validation_errors' => 'show',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: After Submit Feedback
         */
        $this->start_controls_section(
            'section_after_submit_feedback_style',
            [
                'label' => __( 'After Submit Feedback', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'contact_form_after_submit_feedback_typography',
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ok',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'contact_form_after_submit_feedback_color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ng' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ok' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'contact_form_after_submit_feedback_background',
                'label' => __( 'Background', 'gold-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ok',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'contact_form_after_submit_feedback_border',
                'label' => __( 'Border', 'gold-addons-for-elementor' ),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ng, {{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ok',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'contact_form_after_submit_feedback_border_radius',
            [
                'label' => esc_html__( 'Radius', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1500,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ng' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ok' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'contact_form_after_submit_feedback_border_margin',
            [
                'label' => esc_html__( 'Margin', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ng' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ok' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'contact_form_after_submit_feedback_border_padding',
            [
                'label' => esc_html__( 'Padding', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ng' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ga-contact-form-7 .wpcf7-mail-sent-ok' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @access protected
     */
    protected function render() {
        if ( ! function_exists( 'wpcf7' ) ) {
            return;
        }

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'contact-form', 'class', [
            'ga-contact-form',
            'ga-contact-form-7',
            'ga-contact-form-' . esc_attr( $this->get_id() ),
        ] );

        if ( $settings['labels_switch'] != 'yes' ) {
            $this->add_render_attribute( 'contact-form', 'class', 'labels-hide' );
        }

        if ( $settings['placeholder_switch'] == 'yes' ) {
            $this->add_render_attribute('contact-form', 'class', 'placeholder-show');
        }

        if ( $settings['custom_radio_checkbox'] == 'yes' ) {
            $this->add_render_attribute( 'contact-form', 'class', 'ga-custom-radio-checkbox' );
        }

        if ( $settings['contact_form_alignment'] == 'left' ) {
            $this->add_render_attribute( 'contact-form', 'class', 'ga-contact-form-align-left' );
        } elseif ( $settings['contact_form_alignment'] == 'center' ) {
            $this->add_render_attribute( 'contact-form', 'class', 'ga-contact-form-align-center' );
        } elseif ($settings['contact_form_alignment'] == 'right') {
            $this->add_render_attribute( 'contact-form', 'class', 'ga-contact-form-align-right' );
        } else {
            $this->add_render_attribute( 'contact-form', 'class', 'ga-contact-form-align-default' );
        }

        if ( ! empty( $settings['contact_form_list'] ) ) {
            echo '<div class="ga-contact-form-7-wrapper">
                <div ' . $this->get_render_attribute_string( 'contact-form' ) . '>';
            if ( $settings['form_title'] == 'yes' || $settings['form_description'] == 'yes' ) {
                echo '<div class="ga-contact-form-7-heading">';
                if ( $settings['form_title'] == 'yes' && $settings['form_title_text'] != '' ) {
                    echo '<h3 class="ga-contact-form-title ga-contact-form-7-title">
                            ' . esc_attr( $settings['form_title_text'] ) . '
                        </h3>';
                }
                if ( $settings['form_description'] == 'yes' && $settings['form_description_text'] != '' ) {
                    echo '<div class="ga-contact-form-description ga-contact-form-7-description">
                            ' . $this->parse_text_editor( $settings['form_description_text'] ) . '
                        </div>';
                }
                echo '</div>';
            }
            echo do_shortcode('[contact-form-7 id="' . $settings['contact_form_list'] . '" ]');
            echo '</div>
            </div>';
        }
    }
}
