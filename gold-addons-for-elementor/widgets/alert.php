<?php
/**
 * Alert
 *
 * The GoldAddons Alert widget for Elementor.
 *
 * @package GoldAddons
 * @subpackage GoldAddons for Elementor
 * @since 1.1.2
 */

namespace GoldAddons\Widget;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;

class Alert extends Widget_Base {
    
    /**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.1.2
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'gold-addons-alert';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.1.2
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Alert', 'gold-addons-for-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.1.2
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-alert';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.1.2
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'gold-addons-for-elementor' ];
	}

    /**
	 * Set widget keywords.
	 * 
	 * @since 1.1.5
	 * @access public
	 * @return array
	 */
	public function get_keywords() {
		return [
			'alert',
			'ga alert',
			'goldaddons',
			'gold addons'
		];
	}

    /**
     * Include style depends.
     * 
     * @since 1.1.5
     * @access public
     * @return array
     */
    public function get_style_depends() {
        return [
            'font-awesome',
            'goldaddons-icons',
            'goldaddons-general',
            'goldaddons-alert'
        ];
    }

    /**
     * Include script depends.
     * 
     * @since 1.1.5
     * @access public
     * @return array
     */
    public function get_script_depends() {
        return [
            'goldaddons-alert'
        ];
    }

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1.2
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'gold-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'type',
			[
				'label' => __( 'Alert Type', 'gold-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
                'options' => [
                    'info' => __( 'Info', 'gold-addons-for-elementor' ),
                    'success' => __( 'Success', 'gold-addons-for-elementor' ),
                    'warning' => __( 'Warning', 'gold-addons-for-elementor' ),
                    'danger' => __( 'Danger', 'gold-addons-for-elementor' ),
                    'custom' => __( 'Custom', 'gold-addons-for-elementor' )
                ],
                'default' => 'info'
			]
		);
        
        $this->add_control(
            'dismissible',
            [
                'label' => __( 'Show dismiss icon?', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'gold-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'gold-addons-for-elementor' ),
                'return_Value' => 'yes',
                'default' => 'yes'
            ]
        );
        
        $this->add_control(
            'icon',
            [
                'label' => __( 'Alert Icon', 'gold-addons-for-elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::ICON,
                'options' => goldaddons_icons(),
                'default' => 'ga-icon-info'
            ]
        );
        
        $this->add_control(
            'content',
            [
                'label' => __( 'Content', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'This is alert default content.', 'gold-addons-for-elementor' )
            ]
        );

		$this->end_controls_section();
        
        $this->start_controls_section(
            'styling',
            [
                'label' => __( 'Colors', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'type' => 'custom'
                ]
            ]
        );
        
        $this->add_control(
            'background',
            [
                'label' => __( 'Background Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-alert-custom' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .ga-alert-custom::before' => 'border-color: {{VALUE}};'
                ],
                'condition' => [
                    'type' => 'custom'
                ]
            ]
        );
        
        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-alert-custom i' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'type' => 'custom'
                ]
            ]
        );
        
        $this->add_control(
            'color',
            [
                'label' => __( 'Text Color', 'gold-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ga-alert-custom' => 'color: {{VALUE}};'
                ],
                'condition' => [
                    'type' => 'custom'
                ]
            ]
        );
        
        $this->end_controls_section();
        
         $this->start_controls_section(
            'typography',
            [
                'label' => __( 'Typography', 'gold-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'gold-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .ga-alert',
			]
		);
        
        $this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
        extract( $settings ); 
        
        $class[] = 'ga-alert';

        isset( $type ) ? $class[] = 'ga-alert-' . $type : '';
        'yes' == $dismissible ? $class[] = 'ga-alert-dismissible' : '';
        
        $this->add_render_attribute(
            'wrapper',
            [
                'class' => implode( ' ', $class ) . ' show fade'
            ]
        );
        
        ?>

        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            
            <?php if( 'yes' == $dismissible ) : ?>
            <span class="ga-close"></span>
            <?php endif; ?>
            
            <?php if( ! empty( $icon ) ) : ?>
            <i class="<?php echo esc_attr( $icon ); ?>"></i>
            <?php endif; ?>
            
            <?php if( ! empty( $content ) ) echo $content; ?>
		</div>

    <?php
	}
    
}
