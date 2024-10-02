<?php
/**
 * PRO Widgets
 *
 * The GoldAddons plugin PRO widgets page.
 *
 * @package GoldAddons for Elementor
 * @since 1.0.8
 * @return mixed
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$plugin_data = get_plugin_data( GOLDADDONS_DIR . '/gold-addons-for-elementor.php' );
$version = isset( $plugin_data['Version'] ) ? $plugin_data['Version'] : ''; ?>

<div id="goldaddons-settings">
    <div class="goldaddons-head-wrapper">
        <h1>GoldAddons <span> For Elementor</span></h1>
        <div class="goldaddons-website">
            <div class="plugin-version">
                <?php _e( 'Version:', 'gold-addons-for-elementor' ); ?>
                <span><?php echo esc_html( $version ); ?></span>
            </div>
        </div>
    </div>
    <div class="ga-card" style="margin-top:50px;">
        <div class="ga-card-body">
            <div class="wrap about-wrap full-width-layout">
                <h3 class="aligncenter heading-pro">Pricing</h3>
                <div class="has-3-columns">
                    
                    <div class="ga-pricing-card column aligncenter">
                        <div class="ga-pricing-card-body">
                            <div class="ga-icon-box-icon mb-0">
                                <i class="fe-icon-star"></i>
                            </div>
                           <h3>Unlimited</h3>
                            <div class="ga-pricing-card-price yearly active"><span>$</span>4,99 <span style="font-size:12px;">/ month</span></div>
                            <span class="text-muted">unlimited websites</span>
                            <ul class="ga-pricing-card-features">
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    Lifetime updates
                                </li>
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                   Lifetime premium support
                                </li>
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    Full documentation provided
                                </li>
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    14 Days money back guarantee
                                </li>
                            </ul>
                            <div class="ga-pricing-card-button">
                                <a href="https://goldaddons.com/pricing/?add-to-cart=383" class="btn btn-primary" target="_blank">
                                    Buy Now
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div><!-- #goldaddons-settings -->