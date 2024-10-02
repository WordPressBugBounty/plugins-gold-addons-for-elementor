<?php
/**
 * GoldAddons Deactivation Feedback
 *
 * This class encapsulates functionality related to sending deactivation feedback data.
 *
 * @package GoldAddons for Elementor
 * @since 1.2.5
 */

namespace GoldAddons;

// Direct access not allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GoldAddons_Deactivation_Feedback {
    /**
     * Class Constructor
     */
    function __construct() {
        add_action( 'wp_ajax_goldaddons_send_deactivation_data', [ $this, 'send_deactivation_feedback_data' ] );
        add_action( 'admin_footer', [ $this, 'generate_deactivation_modal' ]);
    }

    /**
	 * Send deactivation feedback data and deactivate GoldAddons plugin
	 *
	 * @since    1.2.5
	 * @access   public
     * @return string Mail sent message
	 */
    public function send_deactivation_feedback_data() {
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

        if(!get_option('gold_addons_deactivate_data_sent')) {
            update_option('gold_addons_deactivate_data_sent', 'yes');

            $reason = esc_html(sanitize_text_field($_POST["reason"]));
            $message = esc_html(sanitize_text_field($_POST["message"]));

            $final_reason = "";
            $final_message = "";
            $site_url = get_bloginfo('url');

            if($reason == "no-option-selected") {
                $final_reason = "No option selected";
            } elseif($reason == "found-better-plugin") {
                $final_reason = "I have found a better plugin for my needs";
            } elseif($reason == "i-dont-like-it") {
                $final_reason = "I dont like this plugin";
            } elseif($reason == "plugin-needs-improvement") {
                $final_reason = "This plugin needs improvement";
            } elseif($reason == "other") {
                $final_reason = "Other";
            }

            $to = 'feedback@goldaddons.com';
            $subject = "GoldAddons plugin deactivated on $site_url";
            $final_message = "Reason: $final_reason\nMessage: $message";

            $mail_sent = wp_mail($to, $subject, $final_message);

            deactivate_plugins(GOLDADDONS_DIR . 'gold-addons-for-elementor.php');

            if($mail_sent) {
                wp_send_json_success('Mail sent');
            } else {
                wp_send_json_error('Mail not sent');
            }
        }
    }

    /**
	 * Generate deactivation modal
	 *
	 * @since    1.2.5
	 * @access   public
	 */
    public function generate_deactivation_modal() {
        ?>
        <div id="gold-addons-deactivation-feedback-modal-container" style="display: none;">
            <div id="gold-addons-deactivation-feedback-modal">
                <div id="gold-addons-deactivation-feedback-modal-header">
                    <div id="gold-addons-deactivation-feedback-modal-x">
                        <img src="<?php echo esc_url(GOLDADDONS_IMAGES_URI . '/x.png'); ?>">
                    </div>
                </div>
                <div id="gold-addons-deactivation-feedback-modal-body">
                    <div class="gold-addons-deactivation-feedback-modal-body-elements">
                        <h2 id="deactivation-feedback-title"><?php esc_attr_e('Deactivation Feedback', 'gold-addons-for-elementor') ?></h2>
                        <label class="deactivation-feedback-label" for="gold-addons-deactivation-feedback-reason"><?php esc_html_e( 'Reason for deactivation', 'gold-addons-for-elementor' ); ?></label>
                    </div>
                    <div class="gold-addons-deactivation-feedback-modal-body-elements">
                        <select name="gold-addons-deactivation-feedback-options" id="gold-addons-deactivation-feedback-reason">
                            <option value="no-option-selected" selected><?php esc_html_e( 'Select option', 'gold-addons-for-elementor' ); ?></option>
                            <option value="found-better-plugin"><?php esc_html_e('I have found a better plugin for my needs', 'gold-addons-for-elementor' ); ?></option>
                            <option value="i-dont-like-it"><?php esc_html_e( 'I dont like this plugin', 'gold-addons-for-elementor' ); ?></option>
                            <option value="plugin-needs-improvement"><?php esc_html_e( 'This plugin needs improvement', 'gold-addons-for-elementor' ); ?></option>
                            <option value="other"><?php esc_html_e( 'Other', 'gold-addons-for-elementor' ); ?></option>
                        </select>
                    </div>
                    <div class="gold-addons-deactivation-feedback-modal-body-elements">
                        <label class="deactivation-feedback-label" for="gold-addons-deactivation-feedback-message"><?php esc_html_e( 'Message', 'gold-addons-for-elementor' ); ?></label>
                        <textarea id="gold-addons-deactivation-feedback-message" placeholder="<?php esc_attr_e( 'Your message...', 'gold-addons-for-elementor' ); ?>" rows="5"></textarea>
                    </div>
                </div>
                <div id="gold-addons-deactivation-feedback-modal-footer">
                    <button id="send-gold-addons-deactivation-feedback-btn">
                        <i id="gold-addons-spinner" class="dashicons dashicons-update gold-addons-animated-360 deactivate-gold-addons-spinner" style="display: none;"></i>
                        <?php esc_html_e( 'Deactivate', 'gold-addons-for-elementor' ); ?>
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
}