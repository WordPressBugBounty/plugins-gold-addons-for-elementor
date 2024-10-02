<?php
/**
 * Settings
 *
 * The GoldAddons plugin admin settings page class.
 *
 * @package GoldAddons for Elementor
 * @since 1.0.4
 */

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Settings {
    
    /**
	 * Settings page ID for GoldAddons settings.
	 */
	const PAGE_ID = 'goldaddons';
    
    /**
	 * Go Pro menu priority.
	 */
	const MENU_PRIORITY_GO_PRO = 502;
    
    /**
	 * Settings page general tab slug.
	 */
	const TAB_GENERAL = 'general';
    
    /**
	 * Instance
	 *
	 * Single instance of this object.
	 *
	 * @since 1.0.8
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * Get Instance
	 *
	 * Access the single instance of this class.
	 *
	 * @since 1.0.8
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
    
    /**
	 * Register admin menu.
	 *
	 * Add new GoldAddons Settings admin menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function register_admin_menu() {
		add_menu_page(
			esc_html__( 'GoldAddons', 'gold-addons-for-elementor' ),
			esc_html__( 'GoldAddons', 'gold-addons-for-elementor' ),
			'manage_options',
			self::PAGE_ID,
			[ $this, 'display_general_page' ],
			'dashicons-awards',
			59
		);
		if( class_exists( 'GoldAddons\PRO\Plugin' ) ) {
			add_submenu_page(
				self::PAGE_ID,
				'',
				__( 'Settings', 'gold-addons-for-elementor' ),
				'manage_options',
				'goldaddons-settings',
				[ $this, 'display_settings_page' ]
			);
		}
	}
    
    /**
	 * Register GoldAddons Pro sub-menu.
	 *
	 * Add new GoldAddons Pro sub-menu under the main GoldAddons menu.
	 *
	 * Fired by `admin_menu` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function register_pro_menu() {
        add_submenu_page(
            self::PAGE_ID,
            '',
            esc_html__( 'Pricing', 'gold-addons-for-elementor' ),
            'manage_options',
            'goldaddons-pro-pricing',
            [ $this, 'display_pricing_page' ]
        );
		add_submenu_page(
			self::PAGE_ID,
			'',
			'<span style="font-weight:bold;color:gold;"><i class="dashicons dashicons-star-filled" style="font-size: 17px"></i> ' . esc_html__( 'Go Pro', 'gold-addons-for-elementor' ) . '</span>',
			'manage_options',
			'go_goldaddons_pro',
			[ $this, 'handle_external_redirects' ]
		);
	}
    
    /**
	 * Go GoldAddons Pro.
	 *
	 * Redirect the GoldAddons Pro page the clicking the GoldAddons Pro menu link.
	 *
	 * Fired by `admin_init` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function handle_external_redirects() {
		if ( empty( $_GET['page'] ) ) {
			return;
		}

		if ( 'go_goldaddons_pro' === $_GET['page'] ) {
			wp_redirect( 'https://goldaddons.com/pricing/?utm_source=wp-menu&utm_campaign=gopro&utm_medium=wp-dash' );
			die;
		}
        
	}
    
    /**
	 * On admin init.
	 *
	 * Preform actions on WordPress admin initialization.
	 *
	 * Fired by `admin_init` action.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function on_admin_init() {
		$this->handle_external_redirects();
	}
    
    /**
	 * Get settings page title.
	 *
	 * Retrieve the title for the settings page.
	 *
	 * @since 1.0.4
	 * @access protected
	 *
	 * @return string Settings page title.
	 */
	protected function get_page_title() {
		return esc_html__( 'GoldAddons', 'gold-addons-for-elementor' );
	}
    
    /**
	 * Display general page.
	 *
	 * Output the content for the general page.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function display_general_page() { 
        
        require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/pages/general.php' ) );
        
    }

	/**
	 * Display settings page.
	 *
	 * Output the content for the settings page.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function display_settings_page() { 
        
        require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/pages/settings.php' ) );
        
    }
    
    /**
     * Display pro widgets page.
     *
     * Output the content for the pro widgets page.
     *
     * @since 1.0.8
     * @access public
     * @return mixed
     */
    public function display_pricing_page() {
        
        require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/pages/pricing.php' ) );
        
    }
    
    /**
     * Save settings page.
     *
     * Store settings page saved details into database.
     *
     * @since 1.0.4
     * @access private
     */
    private function save_license() {
        if( isset( $_POST['goldaddons']['submit'] ) ) {
            
            // Store nonce in variable.
            $nonce = esc_attr( $_POST['goldaddons-settings-nonce'] );
            
            // If nonce not verified return early.
            if( ! wp_verify_nonce( $nonce, 'goldaddons-settings' ) ) {
                return;
            }
            
            // Remove submit from array.
            unset( $_POST['goldaddons']['submit'] );
            
            // Store license details in array.
            $license = isset( $_POST['goldaddons'] ) ? $_POST['goldaddons'] : '';
            
            // Validate License
            License::activate( $license );
        }
    }
    
    /**
	 * Settings page constructor.
	 *
	 * Initializing GoldAddons "Settings" page.
	 *
	 * @since 1.0.4
	 * @access public
	 */
	public function __construct() {
        
        add_action( 'admin_init', [ $this, 'on_admin_init' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 20 );
        
        if( ! class_exists( 'GoldAddons\PRO\Plugin' ) ) {
            add_action( 'admin_menu', [ $this, 'register_pro_menu' ], self::MENU_PRIORITY_GO_PRO );
        }
        
        $this->save_license();
    }
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
