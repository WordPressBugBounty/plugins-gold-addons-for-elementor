<?php
/**
 * GoldAddons Activation Feedback
 *
 * This class encapsulates functionality related to sending activation feedback data.
 *
 * @package GoldAddons for Elementor
 * @since 1.2.5
 */

namespace GoldAddons;

// Direct access not allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GoldAddons_Activation_Feedback {
    /**
     * Class Constructor
     */
    function __construct() {
        add_action( 'wp_ajax_goldaddons_send_activation_data', [ $this, 'send_activation_feedback_data' ] );
    }

    /**
	 * Send activation feedback data and activate GoldAddons plugin
	 *
	 * @since    1.2.5
	 * @access   public
     * @return string Mail sent message
	 */
    public function send_activation_feedback_data() {
        $nonce = isset($_POST['nonce']) ? esc_html(sanitize_text_field($_POST['nonce'])) : ''; // phpcs:ignore
        
        if ( ! wp_verify_nonce( $nonce, 'gold_addons_nonce' ) ) {
            wp_send_json_error(
                [ 
                    'error' => [
                        'code' => 'invalid_nonce',
                        'label' => esc_html__( 'Invalid nonce!', 'gold-addons-for-elementor' ),
                        'message' => esc_html__( 'The nonce verification failed.', 'gold-addons-for-elementor' )
                    ]
                ]
            );
        }

        if(!get_option('gold_addons_activate_data_sent')) {
            update_option('gold_addons_activate_data_sent', 'yes');

            $site_url = get_bloginfo('url');

            $to = 'feedback@goldaddons.com';
            $subject = "GoldAddons plugin activated on $site_url";
            $message = "Activation data";

            $mail_sent = wp_mail($to, $subject, $message);

            if($mail_sent) {
                wp_send_json_success('Mail sent');
            } else {
                wp_send_json_error('Mail not sent');
            }
        }
    }
}