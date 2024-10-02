<?php
/**
 * Ajax
 *
 * The GoldAddons plugin ajax class.
 *
 * @package GoldAddons for Elementor
 * @since 1.0.8
 */

namespace GoldAddons;

// Direct access not allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Ajax {
    
    /**
     * API URL
     *
     * @since 1.0.4
     * @access private
     * @return string
     */
    private static $api = 'https://goldaddons.com/wp-json/lmfwc/v2';
    
    /**
     * Consumer Key
     *
     * @since 1.0.4
     * @access private
     * @return string
     */
    private static $consumer_key = 'ck_2a0d151fafecc68a7f204e3e307fd8248d29ed99';

    /**
     * Consumer Secret
     *
     * @since 1.0.4
     * @access private
     * @return string
     */
    private static $consumer_secret = 'cs_54b9d206dff89b4cb5c65f5b64d1c73fcf870ac1';

    /**
     * Endpoint Routes
     * 
     * @since 1.1.6
     * @access private
     * @return string[]
     */
    private static $routes = [
        'activate'      => '/licenses/activate/',
        'deactivate'    => '/licenses/deactivate/'
    ];
    
    
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
        
        add_action( 'wp_ajax_gold_addons_activate', [ $this, 'activate' ] );
        add_action( 'wp_ajax_gold_addons_deactivate', [ $this, 'deactivate' ] );
        
    }
    
    /**
     * Activate
     *
     * Activate the GoldAddons plugin with license key.
     *
     * @since 1.0.8
     * @access public
     * @return array
     */
    public function activate() {
        $license_key = isset( $_POST['license_key'] ) ? esc_attr( $_POST['license_key'] ) : '';
        $license_key = preg_replace('/[^a-zA-Z0-9]/', '', $license_key);

        $license_option = unserialize( base64_decode( get_option( '_goldaddons_license' ) ) );
        
        if ( ! empty( $license_key ) ) {
            
            if (isset($license_option) && !empty($license_option['licenseKey']) && $license_option['licenseKey'] === $license_key) {
                $token = isset($license_option['activationData']['token']) ?  $license_option['activationData']['token'] : '';
                $this->deactivate($license_key, $token);
            }

            $route = self::$routes['activate'] . $license_key;
            $this->response( $route );
        }
    }

    /**
     * Deactivate
     * 
     * Deactivate the GoldAddons plugin license key.
     * 
     * @since 1.0.8
     * @access public
     * @return array
     */
    public function deactivate($license_key, $token) {
        if ( ! empty( $license_key ) && ! empty($token)) {
            $route = self::$routes['deactivate'] . esc_attr( $license_key ) . '?token=' . esc_attr( $token );
            $this->response( $route );
        }
    }

    /**
     * Response
     *
     * The GoldAddons.com server API response.
     *
     * @param string $endpoint (required) The URL endpoint.
     *
     * @since 1.0.8
     * @access private
     * @return void
     */
    private function response( $endpoint ) {
        delete_option('_goldaddons_license');

        $params = add_query_arg( [
            'consumer_key'    => self::$consumer_key,
            'consumer_secret' => self::$consumer_secret,
        ], self::$api . $endpoint );

        $response = wp_remote_get( $params );

        if ( is_wp_error( $response ) ) {
            wp_send_json_error( [
                'error_message' => $response->get_error_message(),
            ] );
            return;
        }

        $json = json_decode( wp_remote_retrieve_body( $response ), true );

        if (isset($json['data']['errors']) && !empty($json['data']['errors']['lmfwc_rest_data_error'])) {
            foreach ($json['data']['errors']['lmfwc_rest_data_error'] as $key => $message) {
                $error['error_message'] = $message;
            }
            wp_send_json_error($error);
        }

        if (isset($json['code']) && 'rest_no_route' === $json['code']) {
            wp_send_json_error([
                'error_message' => $json['message']
            ]);
        }

        if (isset($json['data']) && !empty($json['data']['activationData'])) {
            $activation_data = $json['data'];

            update_option('_goldaddons_license', base64_encode(serialize($activation_data)));

            wp_send_json_success( $activation_data );
        }
    }
    
}

Ajax::get_instance();
