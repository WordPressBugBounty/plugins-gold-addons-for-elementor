<?php
/**
 * General
 *
 * The GoldAddons plugin settings main page.
 *
 * @package GoldAddons for Elementor
 * @since 1.0.4
 * @since 1.0.8 Updated the code.
 * @return mixed
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$plugin_data    = get_plugin_data( GOLDADDONS_DIR . '/gold-addons-for-elementor.php' );
$version        = isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : '';
$license        = unserialize( base64_decode( get_option( '_goldaddons_license' ) ) );
$message        = '';

if (isset($license) && ! empty($license['createdAt']) && ! empty($license['expiresAt'])) { 
    $createdAt = isset($license['createdAt']) ? new DateTime($license['createdAt']) : '';
    $expiresAt = isset($license['expiresAt']) ? new DateTime($license['expiresAt']) : '';

    $currentDate    = new DateTime();
    $interval       = $expiresAt->diff($currentDate);
    $remainingDays  = $interval->days;
    $message = "Your license will expire in $remainingDays day(s).";
}
?>

<div id="goldaddons-settings">
    <div class="goldaddons-head-wrapper">
        <h1>GoldAddons <span><?php _e( 'For Elementor', 'gold-addons-for-elementor' ); ?></span></h1>
        <div class="goldaddons-website">
            <div class="plugin-version">
                <?php _e( 'Version:', 'gold-addons-for-elementor' ); ?>
                <span><?php echo esc_html( $version ); ?></span>
            </div>
        </div>
    </div>
    <form method="post">
        <?php wp_nonce_field( 'goldaddons-settings', 'goldaddons-settings-nonce' ); ?>
        <div id="ga-settings-license" class="ga-card">
            <div class="ga-card-body">
                <div class="ga-nav" style="display:flex;justify-content: center;margin-bottom: 20px;">
                    <a href="https://goldaddons.com/my-account/view-license-keys/" target="_blank" class="btn btn-primary"><?php _e( 'My License', 'gold-addons-for-elementor' ); ?></a>
                </div>
                <?php if (!empty($license['licenseKey']) && !empty($license['activationData']['token'])) : ?>
                        <div class="alert alert-success"><i class="fe-icon-info"></i> <?php _e( 'License is activated!', 'gold-addons-for-elementor' ); ?> <?php echo esc_html( $message ); ?></div>
                <?php endif; ?>
                <div class="license-form-wrapper">
                    <input id="goldaddons-license" name="goldaddons[key]" type="text" value="<?php echo isset($license['licenseKey']) ? esc_attr( $license['licenseKey'] ) : ''; ?>" placeholder="<?php echo 'e.g.: GANSWRLQRD3CJ5GNFTQ4GYVPRLYV'; ?>" class="form-control">
                    <button id="goldaddons-register" class="btn btn-primary" type="button">
                        <i class="dashicons dashicons-update spin hidden"></i>
                        <?php _e( 'Activate', 'gold-addons-for-elementor' ); ?>
                    </button>
                </div>
                
            </div>
        </div>
    </form>
</div><!-- #goldaddons-settings -->
