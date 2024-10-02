<?php
/**
 * Admin
 *
 * The GoldAddons plugin admin class.
 *
 * @package GoldAddons for Elementor
 * @since 1.0.3
 */

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin {
    
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
	 * Ajax
	 * 
	 * The ajax object holder.
	 * 
	 * @since 1.1.5
	 * @access private
	 * @return null|object
	 */
	private $ajax;

	/**
	 * Settings
	 * 
	 * The settings object holder/
	 * 
	 * @since 1.1.5
	 * @access private
	 * @return null|object
	 */
	private $settings;

	/**
	 * Update
	 * 
	 * The update object holder.
	 * 
	 * @since 1.1.5
	 * @access private
	 * @return null|object
	 */
	private $update;

	/**
	 * Notifications
	 * 
	 * The notifications object holder.
	 * 
	 * @since 1.1.5
	 * @access private
	 * @return null|object
	 */
	private $notifications;

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
	 * Admin constructor.
	 *
	 * Initializing GoldAddons in WordPress admin.
	 *
	 * @since 1.0.3
	 * @access public
	 */
    public function __construct() {
        if( ! is_admin() ) {
            return;
        }
        
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        
        if( ! class_exists( 'GoldAddons\PRO\Plugin' ) ) {
            add_filter( 'plugin_action_links_' . GOLDADDONS_BASENAME, [ $this, 'plugin_action_links' ] );
        }
        
        // Include Admin Files
        require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/class-ajax.php' ) );
        require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/class-settings.php' ) );
        require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/class-notifications.php' ) );
		require( wp_normalize_path( GOLDADDONS_DIR . 'includes/vendor/updater/plugin-update-checker.php' ) );
		require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/class-goldaddons-activation-feedback.php' ) );
		require_once( wp_normalize_path( GOLDADDONS_DIR . 'includes/admin/class-goldaddons-deactivation-feedback.php' ) );
        
        // Initialize
        $this->ajax          = Ajax::get_instance();
        $this->settings      = Settings::get_instance();
        $this->notifications = Notifications::get_instance();
		$goldAddonsActivationFeedback = new GoldAddons_Activation_Feedback();
		$goldAddonsDeactivationFeedback = new GoldAddons_Deactivation_Feedback();
        
        // If GoldAddons Pro active let's start the updater class.
        if ( class_exists( 'GoldAddons\PRO\Plugin' ) ) {
            $myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
				'https://update.goldaddons.com/?action=get_metadata&slug=gold-addons-pro-for-elementor',
				GOLDADDONS_PRO_DIR . 'gold-addons-pro-for-elementor.php', //Full path to the main plugin file or functions.php.
				'gold-addons-pro-for-elementor'
			);
        }
    }
    
    /**
	 * Enqueue admin scripts.
	 *
	 * Registers all the admin scripts and enqueues them.
	 *
	 * Fired by `admin_enqueue_scripts` action.
	 *
	 * @since 1.0.3
	 * @access public
	 */
    public function enqueue_scripts() {
        $current_screen = get_current_screen();
        
        wp_enqueue_script( 'gold-addons-back', GOLDADDONS_URI . 'assets/js/back.min.js', [], uniqid() );
        
        if( 'toplevel_page_goldaddons' == $current_screen->id || 'goldaddons_page_goldaddons-pro-pricing' == $current_screen->id || 'goldaddons_page_goldaddons-settings' == $current_screen->id ) {
            wp_enqueue_style( 'gold-addons-admin', GOLDADDONS_URI . 'assets/css/admin.css', [], uniqid() );
            wp_enqueue_script( 'gold-addons-admin', GOLDADDONS_URI . 'assets/js/admin.js', [], uniqid() );
            wp_localize_script( 'gold-addons-admin', '_GoldAddons', [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'label_success' => __( 'Congratulations! Your license key is successfully activated.', 'gold-addons-for-elementor' ),
				'label_deactivated' => __( 'Your license key is successfully deactivated.', 'gold-addons-for-elementor' ),
                'label_notice' => __( 'Please insert your license key below.', 'gold-addons-for-elementor' ),
                'label_warning' => __( 'Your license key is invalid.', 'gold-addons-for-elementor' ),
                'label_key' => __( 'Please enter your license key.', 'gold-addons-for-elementor' )
            ] );
        }

		$gold_addons_feedback_fragments = [
			'url' => esc_url( admin_url('admin-ajax.php') ), 
			'nonce' => wp_create_nonce( 'gold_addons_nonce' ),
			'activation_data_sent' => esc_html(sanitize_text_field(get_option('gold_addons_activate_data_sent'))),
			'deactivation_data_sent' => esc_html(sanitize_text_field(get_option('gold_addons_deactivate_data_sent')))
		];

		wp_enqueue_script( 'gold-addons-activation-feedback', GOLDADDONS_URI . 'assets/js/gold-addons-activation-feedback.js', array( 'jquery' ), uniqid(), false );

		wp_localize_script( 
			'gold-addons-activation-feedback', 
			'gold_addons_activation_obj', 
			$gold_addons_feedback_fragments
		);

		if($current_screen->id == "plugins") {
			wp_enqueue_style( 'gold-addons-modal', GOLDADDONS_URI . 'assets/css/gold-addons-modal.css', [], uniqid() );

			wp_enqueue_script( 'gold-addons-deactivation-feedback', GOLDADDONS_URI . 'assets/js/gold-addons-deactivation-feedback.js', array( 'jquery' ), uniqid(), false );

			wp_localize_script( 
				'gold-addons-deactivation-feedback', 
				'gold_addons_deactivation_obj', 
				$gold_addons_feedback_fragments
			);
		}
    }
    
    /**
	 * Plugin action links.
	 *
	 * Adds action links to the plugin list table
	 *
	 * Fired by `plugin_action_links` filter.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @param array $links An array of plugin action links.
	 *
	 * @return array An array of plugin action links.
	 */
    public function plugin_action_links( $links ) {
        $links['go_pro'] = sprintf( 
            '<a href="%1$s" target="_blank" style="color:gold;font-weight:bold;">%2$s</a>', 
            esc_url( 'https://goldaddons.com/pricing/' ), 
            esc_html__( 'Go Pro', 'gold-addons-for-elementor' ) 
        );

		return $links;
    }
    
}

Admin::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
