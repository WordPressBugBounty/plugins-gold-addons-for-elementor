<?php
/**
 * Notifications
 *
 * The GoldAddons plugin admin notifications.
 *
 * @package GoldAddons for Elementor
 * @since 1.0.4
 */

namespace GoldAddons;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Notifications {
    
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
     * Class Constructor
     */
    function __construct() {
        
        add_action( 'admin_notices', [ $this, 'gapro_not_installed__notice' ] );
		add_action( 'admin_notices', [ $this, 'goldaddons_promo' ] );
        
    }
    
    /**
     * GAPRO not Installed
     *
     * @since 1.0.4
	 * @access public
	 * @return mixed
     */
    public function gapro_not_installed__notice() {
        $license = unserialize( base64_decode( get_option( '_goldaddons_license' ) ) );
        if( ! empty($license['licenseKey']) && ! empty($license['activationData']['token']) && ! is_plugin_active( 'gold-addons-pro-for-elementor/gold-addons-pro-for-elementor.php' ) ) {
            echo '<div class="notice notice-info is-dismissible">';
                echo '<p>'. sprintf( '%s <a href="%s" target="_blank">%s</a> %s <a href="%s" target="_blank">%s</a>', esc_html__( 'GoldAddons for Elementor license is activated successfully ! However it seems that you have not installed or activated', 'gold-addons-for-elementor' ), 'https://goldaddons.com/my-account/downloads/', 'GoldAddons PRO for Elementor', esc_html__( 'plugin so premium features are not enabled.', 'gold-addons-for-elementor' ), 'https://goldaddons.com/documentation/', esc_html__( 'Guide', 'gold-addons-for-elementor' ) ) .'</p>';
            echo '</div>';
        }
    }

	/**
	 * GoldAddons Promo
	 * 
	 * @since 1.1.5
	 * @access public
	 * @return mixed
	 */
	public function goldaddons_promo() {
		if ( isset( $_GET['goldaddons-promo-close'] ) && !empty( $_GET['goldaddons-promo-close'] ) ) {
			set_transient( '_goldaddons_promo_closed', true, 168 * HOUR_IN_SECONDS ); // Once per week.
		}

		if ( !get_transient( '_goldaddons_promo_closed' ) && !is_plugin_active( 'gold-addons-pro-for-elementor/gold-addons-pro-for-elementor.php') ) {
			echo '<div class="notice notice-info is-dismissible">';
			echo '<h2>GoldAddons Pro for Elementor is now at $4.99/month for <strong>unlimited websites, lifetime support and lifetime updates</strong> <a href="https://goldaddons.com/pricing/" target="_blank" style="color:green;">Buy Now</a> or <a href="?goldaddons-promo-close=1">Do not show</a></h2>';
			echo '</div>';
		}

		if ( isset( $_GET['goldaddons-smartaipress-promo-close'] ) && !empty( $_GET['goldaddons-smartaipress-promo-close'] ) ) {
			set_transient( '_goldaddons_smartaipress_promo_notification', true, 24 * HOUR_IN_SECONDS ); // Once a day.
		}

		if ( !get_transient( '_goldaddons_smartaipress_promo_notification' ) ) {
			echo '<div class="notice notice-info is-dismissible">';
			echo '<h2>Unlock the power of <span style="color:red;">Artificial Intelligence</span> on your WordPress site with <span style="color:red;">SmartAIPress</span> – the ultimate plugin for enhancing content creation, improving user engagement, and boosting SEO effortlessly. <a href="'. esc_url( admin_url('plugin-install.php?s=smartaipress&tab=search&type=term') ) .'" style="color:green;">Check Now</a> or <a href="?goldaddons-smartaipress-promo-close=1">Do not show</a></h2>';
			echo '</div>';	
		}
	}

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
