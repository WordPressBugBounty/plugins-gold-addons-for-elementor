<?php
/**
 * Gold AddonsProgress Bar.
 */

namespace GoldAddons\Widget;

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Progress_Bar
 */
class Progress_Bar extends Widget_Base {

	/**
	 * Retrieve Widget Name.
	 *
	 * @since 1.2.9
	 * @access public
	 */
	public function get_name() {
		return 'gold-addons-progress-bar';
	}

	/**
	 * Retrieve Widget Title.
	 *
	 * @since 1.2.9
	 * @access public
	 */
	public function get_title() {
		return __( 'Progress Bar', 'gold-addons-for-elementor' );
	}

	/**
	 * Retrieve Widget Icon.
	 *
	 * @since 1.2.9
	 * @access public
	 *
	 * @return string widget icon.
	 */
	public function get_icon() {
		return 'eicon-navigation-horizontal';
	}

	/**
	 * Retrieve Widget Categories.
	 *
	 * @since 1.2.9
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'gold-addons-for-elementor' ];
	}

	/**
	 * Retrieve Widget Dependent CSS.
	 *
	 * @since 1.2.9
	 * @access public
	 *
	 * @return array CSS style handles.
	 */
	public function get_style_depends() {
		return array(
			'goldaddons-progress-bar',
		);
	}

	/**
	 * Retrieve Widget Dependent JS.
	 *
	 * @since 1.2.9
	 * @access public
	 *
	 * @return array JS script handles.
	 */
	public function get_script_depends() {
		return array(
			'lottie-js',
			'goldaddons-progress-bar',
		);
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget keywords.
	 */
	public function get_keywords() {
		return array( 'ga', 'gold', 'circle', 'chart', 'line', 'graph', 'percent' );
	}

	/**
	 * Retrieve Widget Support URL.
	 *
	 * @access public
	 *
	 * @return string support URL.
	 */
	public function get_custom_help_url() {
		return 'https://goldaddons.com/support/';
	}

	/**
	 * Register Progress Bar controls.
	 *
	 * @since 1.2.9
	 * @access protected
	 */
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->start_controls_section(
			'goldaddons_progressbar_labels',
			array(
				'label' => __( 'Progress Bar Settings', 'gold-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'       => __( 'Type', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'line'        => __( 'Line', 'gold-addons-for-elementor' ),
					'half-circle' => __( 'Half Circle', 'gold-addons-for-elementor' ),
					'circle'      => __( 'Circle', 'gold-addons-for-elementor' ),
					'dots'        => __( 'Dots', 'gold-addons-for-elementor' ),
				),
				'default'     => 'line',
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'dot_size',
			array(
				'label'       => __( 'Dot Size', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 60,
					),
				),
				'default'     => array(
					'size' => 25,
					'unit' => 'px',
				),
				'condition'   => array(
					'layout_type' => 'dots',
				),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .progress-segment' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'dot_spacing',
			array(
				'label'       => __( 'Spacing', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'     => array(
					'size' => 8,
					'unit' => 'px',
				),
				'condition'   => array(
					'layout_type' => 'dots',
				),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .progress-segment:not(:first-child):not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 ); margin-left: calc( {{SIZE}}{{UNIT}}/2 )',
					'{{WRAPPER}} .progress-segment:first-child' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 )',
					'{{WRAPPER}} .progress-segment:last-child' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 )',
				),
			)
		);

		$this->add_responsive_control(
			'circle_size',
			array(
				'label'     => __( 'Size', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 50,
						'max'  => 500,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 200,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-wrap, {{WRAPPER}} .gold-addons-progressbar-hf-container' => 'width: {{SIZE}}px; height: {{SIZE}}px',
					'{{WRAPPER}} .gold-addons-progressbar-hf-circle-wrap' => 'width: {{SIZE}}{{UNIT}}; height: calc({{SIZE}} / 2 * 1{{UNIT}});',
					'{{WRAPPER}} .gold-addons-progressbar-hf-labels' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'layout_type' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_select_label',
			array(
				'label'       => __( 'Labels', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'left_right_labels',
				'options'     => array(
					'left_right_labels' => __( 'Left & Right Labels', 'gold-addons-for-elementor' ),
					'more_labels'       => __( 'Multiple Labels', 'gold-addons-for-elementor' ),
				),
				'label_block' => true,
				'condition'   => array(
					'layout_type!' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_left_label',
			array(
				'label'       => __( 'Left Label', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'My Skill', 'gold-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => array(
					'goldaddons_progressbar_select_label' => 'left_right_labels',
				),
			)
		);

		$this->add_responsive_control(
			'title_width',
			array(
				'label'      => __( 'Title Max Width', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-left-label' => 'max-width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'layout_type' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_right_label',
			array(
				'label'       => __( 'Right Label', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( '50%', 'gold-addons-for-elementor' ),
				'label_block' => true,
				'condition'   => array(
					'goldaddons_progressbar_select_label' => 'left_right_labels',
					'layout_type!'                     => array( 'half-circle', 'circle' ),
				),
			)
		);

		$common_conditions = array(
			'layout_type' => array( 'half-circle', 'circle' ),
		);

		$this->add_control(
			'icon_type',
			array(
				'label'     => __( 'Icon Type', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'icon'      => __( 'Icon', 'gold-addons-for-elementor' ),
					'image'     => __( 'Custom Image', 'gold-addons-for-elementor' ),
					'animation' => __( 'Lottie Animation', 'gold-addons-for-elementor' ),
					'svg'       => __( 'SVG Code', 'gold-addons-for-elementor' ),
				),
				'default'   => 'icon',
				'separator' => 'before',
				'condition' => $common_conditions,
			)
		);

		$this->add_control(
			'icon_select',
			array(
				'label'     => __( 'Select an Icon', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => array_merge(
					$common_conditions,
					array(
						'icon_type' => 'icon',
					)
				),
			)
		);

		$this->add_control(
			'image_upload',
			array(
				'label'     => __( 'Upload Image', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array_merge(
					$common_conditions,
					array(
						'icon_type' => 'image',
					)
				),
			)
		);

		$this->add_control(
			'custom_svg',
			array(
				'label'       => __( 'SVG Code', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => 'You can use these sites to create SVGs: <a href="https://danmarshall.github.io/google-font-to-svg-path/" target="_blank">Google Fonts</a> and <a href="https://boxy-svg.com/" target="_blank">Boxy SVG</a>',
				'condition'   => array_merge(
					$common_conditions,
					array(
						'icon_type' => 'svg',
					)
				),
			)
		);

		$this->add_control(
			'lottie_url',
			array(
				'label'       => __( 'Animation JSON URL', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => array_merge(
					$common_conditions,
					array(
						'icon_type' => 'animation',
					)
				),
			)
		);

		$this->add_control(
			'draw_svg',
			array(
				'label'     => __( 'Draw Icon', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'classes'   => 'editor-pa-control-disabled',
				'condition' => array_merge(
					$common_conditions,
					array(
						'icon_type'             => array( 'icon', 'svg' ),
						'icon_select[library]!' => 'svg',
					)
				),
			)
		);

		$animation_conds = array(
			'terms' => array(
				array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'layout_type',
							'value' => 'half-circle',
						),
						array(
							'name'  => 'layout_type',
							'value' => 'circle',
						),
					),
				),
				array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'icon_type',
							'value' => 'animation',
						),
						array(
							'terms' => array(
								array(
									'relation' => 'or',
									'terms'    => array(
										array(
											'name'  => 'icon_type',
											'value' => 'icon',
										),
										array(
											'name'  => 'icon_type',
											'value' => 'svg',
										),
									),
								),
								array(
									'name'  => 'draw_svg',
									'value' => 'yes',
								),
							),
						),
					),
				),
			),
		);

		$this->add_control(
			'lottie_loop',
			array(
				'label'        => __( 'Loop', 'gold-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default'      => 'true',
				'conditions'   => $animation_conds,
			)
		);

		$this->add_control(
			'lottie_reverse',
			array(
				'label'        => __( 'Reverse', 'gold-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'conditions'   => $animation_conds,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => __( 'Icon Size', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array_merge(
					$common_conditions,
					array(
						'icon_type!' => 'svg',
					)
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 30,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-content i' => 'font-size: {{SIZE}}px',
					'{{WRAPPER}} .gold-addons-progressbar-circle-content svg, {{WRAPPER}} .gold-addons-progressbar-circle-content img' => 'width: {{SIZE}}px !important; height: {{SIZE}}px !important',
				),
			)
		);

		$this->add_responsive_control(
			'svg_icon_width',
			array(
				'label'      => __( 'Width', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 600,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'default'    => array(
					'size' => 100,
					'unit' => 'px',
				),
				'condition'  => array_merge(
					$common_conditions,
					array(
						'icon_type' => 'svg',
					)
				),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-content svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'svg_icon_height',
			array(
				'label'      => __( 'Height', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
					'em' => array(
						'min' => 1,
						'max' => 30,
					),
				),
				'condition'  => array_merge(
					$common_conditions,
					array(
						'icon_type' => 'svg',
					)
				),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-content svg' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'show_percentage_value',
			array(
				'label'     => __( 'Show Percentage Value', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
				'condition' => array(
					'layout_type' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$repeater = new REPEATER();

		$repeater->add_control(
			'text',
			array(
				'label'       => __( 'Label', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
				'placeholder' => __( 'label', 'gold-addons-for-elementor' ),
				'default'     => __( 'label', 'gold-addons-for-elementor' ),
			)
		);

		$repeater->add_control(
			'number',
			array(
				'label'   => __( 'Percentage', 'gold-addons-for-elementor' ),
				'dynamic' => array( 'active' => true ),
				'type'    => Controls_Manager::TEXT,
				'default' => 50,
			)
		);

		$this->add_control(
			'goldaddons_progressbar_multiple_label',
			array(
				'label'     => __( 'Label', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::REPEATER,
				'default'   => array(
					array(
						'text'   => __( 'Label', 'gold-addons-for-elementor' ),
						'number' => 50,
					),
				),
				'fields'    => $repeater->get_controls(),
				'condition' => array(
					'goldaddons_progressbar_select_label' => 'more_labels',
					'layout_type!'                     => 'circle',
				),
			)
		);

		$this->add_control(
			'goldaddons_progress_bar_space_percentage_switcher',
			array(
				'label'       => __( 'Enable Percentage', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => __( 'Enable percentage for labels', 'gold-addons-for-elementor' ),
				'condition'   => array(
					'goldaddons_progressbar_select_label' => 'more_labels',
					'layout_type!'                     => 'circle',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_select_label_icon',
			array(
				'label'     => __( 'Labels Indicator', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'line_pin',
				'options'   => array(
					''         => __( 'None', 'gold-addons-for-elementor' ),
					'line_pin' => __( 'Pin', 'gold-addons-for-elementor' ),
					'arrow'    => __( 'Arrow', 'gold-addons-for-elementor' ),
				),
				'condition' => array(
					'goldaddons_progressbar_select_label' => 'more_labels',
					'layout_type!'                     => 'circle',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_more_labels_align',
			array(
				'label'     => __( 'Labels Alignment', 'premuim-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'gold-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'gold-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'gold-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'condition' => array(
					'goldaddons_progressbar_select_label' => 'more_labels',
					'layout_type!'                     => 'circle',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_progress_percentage',
			array(
				'label'   => __( 'Value', 'gold-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
				'default' => 50,
			)
		);

		$this->add_control(
			'goldaddons_progressbar_progress_style',
			array(
				'label'     => __( 'Style', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'solid'    => __( 'Solid', 'gold-addons-for-elementor' ),
					'stripped' => __( 'Striped', 'gold-addons-for-elementor' ),
					'gradient' => __( 'Animated Gradient', 'gold-addons-for-elementor' ),
				),
				'condition' => array(
					'layout_type' => 'line',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_speed',
			array(
				'label' => __( 'Speed (milliseconds)', 'gold-addons-for-elementor' ),
				'type'  => Controls_Manager::NUMBER,
			)
		);

		$this->add_control(
			'goldaddons_progressbar_progress_animation',
			array(
				'label'     => __( 'Animated', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'goldaddons_progressbar_progress_style' => 'stripped',
					'layout_type'                        => 'line',
				),
			)
		);

		$this->add_control(
			'gradient_colors',
			array(
				'label'       => __( 'Gradient Colors', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Enter Colors separated with \' , \'.', 'gold-addons-for-elementor' ),
				'default'     => '#6EC1E4,#54595F',
				'label_block' => true,
				'condition'   => array(
					'layout_type'                        => 'line',
					'goldaddons_progressbar_progress_style' => 'gradient',
				),
			)
		);

		$this->add_control(
			'half_prefix_label',
			array(
				'label'     => __( 'Prefix Label', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array( 'active' => true ),
				'default'   => __( '0', 'gold-addons-for-elementor' ),
				'condition' => array(
					'layout_type' => 'half-circle',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'half_suffix_label',
			array(
				'label'     => __( 'Suffix Label', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array( 'active' => true ),
				'default'   => __( '100%', 'gold-addons-for-elementor' ),
				'condition' => array(
					'layout_type' => 'half-circle',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pa_docs',
			array(
				'label' => __( 'Helpful Documentations', 'gold-addons-for-elementor' ),
			)
		);

		$doc1_url = 'https://goldaddons.com/docs/progress-bar-widget/';

		$this->add_control(
			'doc_1',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf( '<a href="%s" target="_blank">%s</a>', $doc1_url, __( 'Gettings started »', 'gold-addons-for-elementor' ) ),
				'content_classes' => 'editor-pa-doc',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'goldaddons_progressbar_progress_bar_settings',
			array(
				'label' => __( 'Progress Bar', 'gold-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'goldaddons_progressbar_progress_bar_height',
			array(
				'label'       => __( 'Height', 'gold-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'size' => 25,
				),
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}} .gold-addons-progressbar-bar-wrap, {{WRAPPER}} .gold-addons-progressbar-bar' => 'height: {{SIZE}}px;',
				),
				'condition'   => array(
					'layout_type' => 'line',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_progress_bar_radius',
			array(
				'label'      => __( 'Border Radius', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-bar-wrap, {{WRAPPER}} .gold-addons-progressbar-bar, {{WRAPPER}} .progress-segment' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'layout_type!' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'circle_border_width',
			array(
				'label'     => __( 'Border Width', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-base, {{WRAPPER}} .gold-addons-progressbar-circle div, {{WRAPPER}} .gold-addons-progressbar-circle-inner, {{WRAPPER}} .gold-addons-progressbar-hf-circle-progress' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .gold-addons-progressbar-hf-label-left' => 'transform: translateX( calc( {{SIZE}} / 4 * 1{{UNIT}} ) )',
				),
				'condition' => array(
					'layout_type' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'circle_base_border_color',
			array(
				'label'     => __( 'Border Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-base, {{WRAPPER}} .gold-addons-progressbar-circle-inner' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'layout_type' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'fill_colors_title',
			array(
				'label' => __( 'Fill', 'gold-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'goldaddons_progressbar_progress_color',
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .gold-addons-progressbar-bar, {{WRAPPER}} .segment-inner',
				'condition' => array(
					'layout_type!' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'circle_fill_color',
			array(
				'label'     => __( 'Select Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'condition' => array(
					'layout_type' => array( 'half-circle', 'circle' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle div, {{WRAPPER}} .gold-addons-progressbar-hf-circle-progress' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'base_colors_title',
			array(
				'label' => __( 'Base', 'gold-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'goldaddons_progressbar_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .gold-addons-progressbar-bar-wrap:not(.gold-addons-progressbar-dots), {{WRAPPER}} .gold-addons-progressbar-circle-base, {{WRAPPER}} .progress-segment, {{WRAPPER}} .gold-addons-progressbar-circle-inner',
			)
		);

		$this->add_responsive_control(
			'goldaddons_progressbar_container_margin',
			array(
				'label'      => __( 'Margin', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-bar-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'layout_type!' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'goldaddons_progressbar_labels_section',
			array(
				'label'     => __( 'Labels', 'gold-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'goldaddons_progressbar_select_label' => 'left_right_labels',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_left_label_hint',
			array(
				'label' => __( 'Title', 'gold-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'goldaddons_progressbar_left_label_color',
			array(
				'label'     => __( 'Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-left-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'left_label_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .gold-addons-progressbar-left-label',
			)
		);

		$this->add_responsive_control(
			'goldaddons_progressbar_left_label_margin',
			array(
				'label'      => __( 'Margin', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-left-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_right_label_hint',
			array(
				'label'     => __( 'Percentage', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'goldaddons_progressbar_right_label_color',
			array(
				'label'     => __( 'Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-right-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'right_label_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .gold-addons-progressbar-right-label',
			)
		);

		$this->add_responsive_control(
			'goldaddons_progressbar_right_label_margin',
			array(
				'label'      => __( 'Margin', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-right-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style',
			array(
				'label'     => __( 'Icon', 'gold-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layout_type' => array( 'half-circle', 'circle' ),
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .gold-addons-drawable-icon *, {{WRAPPER}} svg:not([class*="gold-addons-"])' => 'fill: {{VALUE}};',
				),
				'condition' => array(
					'icon_type' => array( 'icon', 'svg' ),
				),
			)
		);

		$this->add_control(
			'svg_color',
			array(
				'label'     => __( 'After Draw Fill Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => false,
				'separator' => 'after',
				'condition' => array(
					'icon_type' => array( 'icon', 'svg' ),
					'draw_svg'  => 'yes',
				),
			)
		);

		$this->add_control(
			'icon_background_color',
			array(
				'label'     => __( 'Background Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-icon, {{WRAPPER}} .gold-addons-progressbar-circle-content svg' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'icon_type!' => 'image',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'icon_border',
				'selector' => '{{WRAPPER}} .gold-addons-progressbar-circle-icon, {{WRAPPER}} .gold-addons-progressbar-circle-content svg',
			)
		);

		$this->add_responsive_control(
			'icon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-icon, {{WRAPPER}} .gold-addons-progressbar-circle-content svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_margin',
			array(
				'label'      => __( 'Margin', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => __( 'Padding', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-circle-icon, {{WRAPPER}} .gold-addons-progressbar-circle-content svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'goldaddons_progressbar_multiple_labels_section',
			array(
				'label'     => __( 'Multiple Labels', 'gold-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'goldaddons_progressbar_select_label' => 'more_labels',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_multiple_label_color',
			array(
				'label'     => __( 'Labels\' Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-center-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => __( 'Labels\' Typography', 'gold-addons-for-elementor' ),
				'name'     => 'more_label_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .gold-addons-progressbar-center-label',
			)
		);

		$this->add_control(
			'goldaddons_progressbar_value_label_color',
			array(
				'label'     => __( 'Percentage Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'condition' => array(
					'goldaddons_progress_bar_space_percentage_switcher' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-percentage' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => __( 'Percentage Typography', 'gold-addons-for-elementor' ),
				'name'      => 'percentage_typography',
				'condition' => array(
					'goldaddons_progress_bar_space_percentage_switcher' => 'yes',
				),
				'global'    => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector'  => '{{WRAPPER}} .gold-addons-progressbar-percentage',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'goldaddons_progressbar_multiple_labels_arrow_section',
			array(
				'label'     => __( 'Arrow', 'gold-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'goldaddons_progressbar_select_label' => 'more_labels',
					'goldaddons_progressbar_select_label_icon' => 'arrow',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_arrow_color',
			array(
				'label'     => __( 'Color', 'goldaddons_elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'condition' => array(
					'goldaddons_progressbar_select_label_icon' => 'arrow',
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-arrow' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'goldaddons_arrow_size',
			array(
				'label'      => __( 'Size', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'condition'  => array(
					'goldaddons_progressbar_select_label_icon' => 'arrow',
				),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-arrow' => 'border-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'goldaddons_progressbar_multiple_labels_pin_section',
			array(
				'label'     => __( 'Indicator', 'gold-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'goldaddons_progressbar_select_label' => 'more_labels',
					'goldaddons_progressbar_select_label_icon' => 'line_pin',
				),
			)
		);

		$this->add_control(
			'goldaddons_progressbar_line_pin_color',
			array(
				'label'     => __( 'Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'condition' => array(
					'goldaddons_progressbar_select_label_icon' => 'line_pin',
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-pin' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'goldaddons_pin_size',
			array(
				'label'      => __( 'Size', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'condition'  => array(
					'goldaddons_progressbar_select_label_icon' => 'line_pin',
				),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-pin' => 'border-left-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'goldaddons_pin_height',
			array(
				'label'      => __( 'Height', 'gold-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'condition'  => array(
					'goldaddons_progressbar_select_label_icon' => 'line_pin',
				),
				'selectors'  => array(
					'{{WRAPPER}} .gold-addons-progressbar-pin' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'prefix_suffix_style',
			array(
				'label'     => __( 'Prefix & Suffix', 'gold-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layout_type' => 'half-circle',
				),
			)
		);

		$this->add_responsive_control(
			'labels_top_spacing',
			array(
				'label'     => __( 'Top Spacing', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 300,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-hf-labels' => 'margin-top: {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'prefix_title',
			array(
				'label' => __( 'Prefix', 'gold-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'prefix_label_color',
			array(
				'label'     => __( 'Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-hf-label-left' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'prefix_label_typo',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .gold-addons-progressbar-hf-label-left',
			)
		);

		$pfx_direction = is_rtl() ? 'right' : 'left';
		$sfx_direction = is_rtl() ? 'left' : 'right';

		$this->add_responsive_control(
			'prefix_spacing',
			array(
				'label'     => __( 'Spacing', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-hf-label-left' => 'margin-' . $pfx_direction . ': {{SIZE}}px;',
				),
			)
		);

		$this->add_control(
			'suffix_title',
			array(
				'label' => __( 'Suffix', 'gold-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'suffix_label_color',
			array(
				'label'     => __( 'Color', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-hf-label-right' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'suffix_label_typo',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .gold-addons-progressbar-hf-label-right',
			)
		);

		$this->add_responsive_control(
			'suffix_spacing',
			array(
				'label'     => __( 'Spacing', 'gold-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .gold-addons-progressbar-hf-label-right' => 'margin-' . $sfx_direction . ': {{SIZE}}px;',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Progress Bar widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$settings['magic_scroll'] = $settings['magic_scroll'] ?? '';

		$this->add_inline_editing_attributes( 'gold-addons_progressbar_left_label' );
		$this->add_render_attribute( 'gold-addons_progressbar_left_label', 'class', 'gold-addons-progressbar-left-label' );

		$this->add_inline_editing_attributes( 'gold-addons_progressbar_right_label' );
		$this->add_render_attribute( 'gold-addons_progressbar_right_label', 'class', 'gold-addons-progressbar-right-label' );

		$length = isset( $settings['goldaddons_progressbar_progress_percentage']['size'] ) ? $settings['goldaddons_progressbar_progress_percentage']['size'] : $settings['goldaddons_progressbar_progress_percentage'];

		$style = $settings['goldaddons_progressbar_progress_style'];
		$type  = $settings['layout_type'];

		$progressbar_settings = array(
			'progress_length' => $length,
			'speed'           => ! empty( $settings['goldaddons_progressbar_speed'] ) ? $settings['goldaddons_progressbar_speed'] : 1000,
			'type'            => $type,
			'mScroll'         => $settings['magic_scroll'] ?? '',
		);

		if ( 'dots' === $type ) {
			$progressbar_settings['dot']     = $settings['dot_size']['size'];
			$progressbar_settings['spacing'] = $settings['dot_spacing']['size'];
		}

		$this->add_render_attribute( 'progressbar', [
			'class' => 'gold-addons-progressbar-container'
		] );

		if ( 'stripped' === $style ) {
			$this->add_render_attribute( 'progressbar', 'class', 'gold-addons-progressbar-striped' );
		} elseif ( 'gradient' === $style ) {
			$this->add_render_attribute( 'progressbar', 'class', 'gold-addons-progressbar-gradient' );
			$progressbar_settings['gradient'] = $settings['gradient_colors'];
		}

		if ( 'yes' === $settings['goldaddons_progressbar_progress_animation'] ) {
			$this->add_render_attribute( 'progressbar', 'class', 'gold-addons-progressbar-active' );
		}

		$this->add_render_attribute( 'progressbar', 'data-settings', wp_json_encode( $progressbar_settings ) );

		if ( 'circle' !== $type && 'half-circle' !== $type ) {
			$this->add_render_attribute( 'wrap', 'class', 'gold-addons-progressbar-bar-wrap' );

			if ( 'dots' === $type ) {
				$this->add_render_attribute( 'wrap', 'class', 'gold-addons-progressbar-dots' );
			}
		} else {

			$class = 'half-circle' === $type ? '-hf' : '';

			$this->add_render_attribute( 'wrap', 'class', 'gold-addons-progressbar' . $class . '-circle-wrap' );

		}

		if ( 'yes' === $settings['draw_svg'] ) {

			$this->add_render_attribute(
				'progressbar',
				'class',
				array(
					'elementor-invisible',
					'gold-addons-drawer-hover',
				)
			);
		}

		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'progressbar' ) ); ?>>

			<?php if ( 'left_right_labels' === $settings['goldaddons_progressbar_select_label'] ) : ?>
				<p <?php echo wp_kses_post( $this->get_render_attribute_string( 'gold-addons_progressbar_left_label' ) ); ?>>
					<?php echo wp_kses_post( $settings['goldaddons_progressbar_left_label'] ); ?>
				</p>
				<p <?php echo wp_kses_post( $this->get_render_attribute_string( 'gold-addons_progressbar_right_label' ) ); ?>>
					<?php echo wp_kses_post( 'yes' !== $settings['magic_scroll'] ? $settings['goldaddons_progressbar_right_label'] : '0%' ); ?>
				</p>
			<?php endif; ?>

			<?php if ( 'more_labels' === $settings['goldaddons_progressbar_select_label'] ) : ?>
				<div class="gold-addons-progressbar-container-label" style="position:relative;">
				<?php
				$direction = is_rtl() ? 'right' : 'left';

				foreach ( $settings['goldaddons_progressbar_multiple_label'] as $item ) {
					if ( 'center' === $this->get_settings( 'gold-addons_progressbar_more_labels_align' ) ) {
						if ( 'yes' === $settings['goldaddons_progress_bar_space_percentage_switcher'] ) {
							if ( 'arrow' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-45%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p><p class="gold-addons-progressbar-arrow" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} elseif ( 'line_pin' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-45%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p><p class="gold-addons-progressbar-pin" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} else {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-45%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p></div>';
							}
						} else {
							if ( 'arrow' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-45%);">' . esc_attr( $item['text'] ) . '</p><p class="gold-addons-progressbar-arrow" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} elseif ( 'line_pin' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-45%)">' . esc_attr( $item['text'] ) . '</p><p class="gold-addons-progressbar-pin" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} else {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-45%);">' . esc_attr( $item['text'] ) . '</p></div>';
							}
						}
					} elseif ( 'left' === $this->get_settings( 'gold-addons_progressbar_more_labels_align' ) ) {
						if ( 'yes' === $settings['goldaddons_progress_bar_space_percentage_switcher'] ) {
							if ( 'arrow' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-10%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p><p class="gold-addons-progressbar-arrow" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} elseif ( 'line_pin' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-2%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p><p class="gold-addons-progressbar-pin" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} else {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-2%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p></div>';
							}
						} else {
							if ( 'arrow' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-10%);">' . esc_attr( $item['text'] ) . '</p><p class="gold-addons-progressbar-arrow" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} elseif ( 'line_pin' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-2%);">' . esc_attr( $item['text'] ) . '</p><p class="gold-addons-progressbar-pin" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} else {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-2%);">' . esc_attr( $item['text'] ) . '</p></div>';
							}
						}
					} else {
						if ( 'yes' === $settings['goldaddons_progress_bar_space_percentage_switcher'] ) {
							if ( 'arrow' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-82%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p><p class="gold-addons-progressbar-arrow" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} elseif ( 'line_pin' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-95%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p><p class="gold-addons-progressbar-pin" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} else {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-96%);">' . esc_attr( $item['text'] ) . ' <span class="gold-addons-progressbar-percentage">' . esc_attr( $item['number'] ) . '%</span></p></div>';
							}
						} else {
							if ( 'arrow' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-71%);">' . esc_attr( $item['text'] ) . '</p><p class="gold-addons-progressbar-arrow" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} elseif ( 'line_pin' === $settings['goldaddons_progressbar_select_label_icon'] ) {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-97%);">' . esc_attr( $item['text'] ) . '</p><p class="gold-addons-progressbar-pin" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%; transform:translateX(50%);"></p></div>';
							} else {
								echo '<div class="gold-addons-progressbar-multiple-label" style="' . esc_attr( $direction . ':' . $item['number'] ) . '%;"><p class = "gold-addons-progressbar-center-label" style="transform:translateX(-96%);">' . esc_attr( $item['text'] ) . '</p></div>';
							}
						}
					}
				}
				?>
				</div>
			<?php endif; ?>

			<?php if ( 'circle' !== $type ) : ?>
				<div class="clearfix"></div>
			<?php endif; ?>

			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrap' ) ); ?>>
				<?php if ( 'line' === $type ) : ?>
					<div class="gold-addons-progressbar-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
				<?php elseif ( 'circle' === $type ) : ?>

					<div class="gold-addons-progressbar-circle-base"></div>
					<div class="gold-addons-progressbar-circle">
						<div class="gold-addons-progressbar-circle-left"></div>
						<div class="gold-addons-progressbar-circle-right"></div>
					</div>

					<?php $this->render_progressbar_content(); ?>

				<?php elseif ( 'half-circle' === $type ) : ?>

					<div class="gold-addons-progressbar-hf-container">
						<div class="gold-addons-progressbar-hf-circle">
							<div class="gold-addons-progressbar-hf-circle-progress"></div>
						</div>

						<div class="gold-addons-progressbar-circle-inner"></div>
					</div>

					<?php $this->render_progressbar_content(); ?>

				<?php endif; ?>
			</div>

			<?php if ( 'half-circle' === $type ) : ?>
				<div class="gold-addons-progressbar-hf-labels">
					<span class="gold-addons-progressbar-hf-label-left">
						<?php echo wp_kses_post( $settings['half_prefix_label'] ); ?>
					</span>
					<span class="gold-addons-progressbar-hf-label-right">
						<?php echo wp_kses_post( $settings['half_suffix_label'] ); ?>
					</span>
				</div>
			<?php endif; ?>

		</div>

		<?php
	}

	/**
	 * Get Progressbar Content
	 *
	 * @since 4.9.13
	 * @access private
	 */
	private function render_progressbar_content() {

		$settings = $this->get_settings_for_display();

		$icon_type = $settings['icon_type'];

		if ( 'icon' === $icon_type || 'svg' === $icon_type ) {

			$this->add_render_attribute( 'icon', 'class', 'gold-addons-drawable-icon' );

			if ( ( 'yes' === $settings['draw_svg'] && 'icon' === $icon_type ) || 'svg' === $icon_type ) {
				$this->add_render_attribute( 'icon', 'class', 'gold-addons-progressbar-circle-icon' );
			}

			if ( 'yes' === $settings['draw_svg'] ) {

				if ( 'icon' === $icon_type ) {

					$this->add_render_attribute( 'icon', 'class', $settings['icon_select']['value'] );

				}

				$this->add_render_attribute(
					'icon',
					array(
						'class'            => 'gold-addons-svg-drawer',
						'data-svg-reverse' => $settings['lottie_reverse'],
						'data-svg-loop'    => $settings['lottie_loop'],
						'data-svg-sync'    => $settings['svg_sync'],
						'data-svg-hover'   => $settings['svg_hover'],
						'data-svg-fill'    => $settings['svg_color'],
						'data-svg-frames'  => $settings['frames'],
						'data-svg-yoyo'    => $settings['svg_yoyo'],
						'data-svg-point'   => $settings['lottie_reverse'] ? $settings['end_point']['size'] : $settings['start_point']['size'],
					)
				);

			} else {
				$this->add_render_attribute( 'icon', 'class', 'gold-addons-svg-nodraw' );
			}
		} elseif ( 'animation' === $icon_type ) {
			$this->add_render_attribute(
				'progress_lottie',
				array(
					'class'               => array(
						'gold-addons-progressbar-circle-icon',
						'gold-addons-lottie-animation',
					),
					'data-lottie-url'     => $settings['lottie_url'],
					'data-lottie-loop'    => $settings['lottie_loop'],
					'data-lottie-reverse' => $settings['lottie_reverse'],
				)
			);
		}

		?>

			<div class="gold-addons-progressbar-circle-content">

				<?php
				if ( 'icon' === $icon_type ) :
					if ( 'yes' !== $settings['draw_svg'] ) :
						Icons_Manager::render_icon(
							$settings['icon_select'],
							array(
								'class'       => array( 'gold-addons-progressbar-circle-icon', 'gold-addons-svg-nodraw', 'gold-addons-drawable-icon' ),
								'aria-hidden' => 'true',
							)
						);
					else :
						?>
							<i <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon' ) ); ?>></i>
						<?php
					endif;

				elseif ( 'svg' === $icon_type ) :
					?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon' ) ); ?>>
						<?php $this->print_unescaped_setting( 'custom_svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<?php
				elseif ( 'image' === $icon_type ) :
					?>
					<img class="gold-addons-progressbar-circle-icon" src="<?php echo esc_attr( $settings['image_upload']['url'] ); ?>">
				<?php else : ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'progress_lottie' ) ); ?>></div>
				<?php endif; ?>

				<p <?php echo wp_kses_post( $this->get_render_attribute_string( 'gold-addons_progressbar_left_label' ) ); ?>>
					<?php echo wp_kses_post( $settings['goldaddons_progressbar_left_label'] ); ?>
				</p>
				<?php if ( 'yes' === $settings['show_percentage_value'] ) : ?>
					<?php if ( 'yes' === $settings['show_percentage_value'] ) : ?>
						<p <?php echo wp_kses_post( $this->get_render_attribute_string( 'gold-addons_progressbar_right_label' ) ); ?>>0%</p>
					<?php endif; ?>
				<?php endif; ?>
			</div>

		<?php

	}
}
