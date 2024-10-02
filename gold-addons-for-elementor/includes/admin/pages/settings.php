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
$nonce          = isset( $_POST['goldaddons-settings-nonce'] ) ? $_POST['goldaddons-settings-nonce'] : '';
$updated        = '';

if ( isset( $nonce ) && $nonce && wp_verify_nonce( $nonce, 'goldaddons-settings' ) ) {
    $updated    = true;
    $data       = isset( $_POST['_goldaddons_settings'] ) ? $_POST['_goldaddons_settings'] : '';
    update_option( '_goldaddons_settings', serialize( $data ) );
}

$options            = unserialize( get_option( '_goldaddons_settings' ) );
$google_maps_api    = isset( $options['google_maps_api'] ) ? $options['google_maps_api'] : ''; ?>

<div id="goldaddons-settings" class="wrap">
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
        <div class="ga-card">
            <div class="ga-card-body">

                <?php if ( $updated ) : ?>
                <div class="alert alert-success">
                    <i class="fe-icon-check-square"></i>
                    <?php _e( 'Settings saved successfully!', 'gold-addons-for-elementor' ); ?>
                </div>
                <?php endif; ?>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="ga-advanced-maps-api"><?php _e( 'Google Maps API Key', 'gold-addons-for-elementor' ); ?></label></th>
                            <td>
                                <input id="ga-advanced-maps-api" name="_goldaddons_settings[google_maps_api]" type="text" class="regular-text" value="<?php echo esc_attr( $google_maps_api ); ?>" />
                                <p class="description"><?php _e( 'You can obtain your Google Maps API key from', 'gold-addons-for-elementor' ); ?>: <a href="https://console.cloud.google.com/google/maps-apis" target="_blank"><?php _e( 'here', 'gold-addons-for-elementor' ); ?></a></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <button class="btn btn-primary" type="submit">
                        <?php _e( 'Save Changes', 'gold-addons-for-elementor' ); ?>
                    </button>         
                </p>
            </div>
        </div>
    </form>
</div><!-- #goldaddons-settings -->
