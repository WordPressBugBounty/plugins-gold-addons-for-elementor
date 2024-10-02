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

<div id="goldaddons-settings" class="wrap">
    <div class="goldaddons-head-wrapper">
        <h1>GoldAddons<span> For Elementor</span></h1>
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
                                <i class="fe-icon-user"></i>
                            </div>
                            <h3>Personal</h3>
                            <div class="ga-pricing-card-price yearly active"><span>$</span>39</div>
                            <span class="text-muted">1 website</span>
                            <ul class="ga-pricing-card-features">
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    Lifetime updates
                                </li>
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    1 Year premium support
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
                                <a href="https://goldaddons.com/pricing/?add-to-cart=381" class="btn btn-primary" target="_blank">
                                    Buy Now
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ga-pricing-card column aligncenter border-primary">
                        <div class="ga-pricing-card-body">
                            <div class="ga-icon-box-icon mb-0">
                                <i class="fe-icon-users"></i>
                            </div>
                            <h3>Business</h3>
                            <div class="ga-pricing-card-price yearly active"><span>$</span>59</div>
                            <span class="text-muted">3 websites</span>
                            <ul class="ga-pricing-card-features">
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    Lifetime updates
                                </li>
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    1 Year premium support
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
                                <a href="https://goldaddons.com/pricing/?add-to-cart=382" class="btn btn-primary" target="_blank">
                                    Buy Now
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ga-pricing-card column aligncenter">
                        <div class="ga-pricing-card-body">
                            <div class="ga-icon-box-icon mb-0">
                                <i class="fe-icon-star"></i>
                            </div>
                           <h3>Unlimited</h3>
                            <div class="ga-pricing-card-price yearly active"><span>$</span>79</div>
                            <span class="text-muted">unlimited websites</span>
                            <ul class="ga-pricing-card-features">
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    Lifetime updates
                                </li>
                                <li>
                                    <i class="fe-icon-check-circle text-muted"></i>
                                    1 Year premium support
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
    <div class="ga-card">
        <div class="ga-card-body">
            <div class="wrap about-wrap full-width-layout">
                <h3 class="aligncenter heading-pro">PRO Widgets</h3>
                <div class="has-3-columns">
                    
                    <div class="ga-icon-box column aligncenter">
                        <div class="ga-icon-box-icon">
                            <i class="fe-icon-align-justify"></i>
                        </div>
                        <h3 class="ga-icon-box-title">Accordion Widget</h3>
                        <p class="ga-icon-box-text">Create an unlimited accordions and apply custom styling to it with many great features.</p>
                        <a href="https://goldaddons.com/widgets/accordion/" class="ga-icon-box-link" target="_blank">
                            Learn more <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="ga-icon-box column aligncenter">
                        <div class="ga-icon-box-icon">
                            <i class="fe-icon-briefcase"></i>
                        </div>
                        <h3 class="ga-icon-box-title">Portfolio Widget</h3>
                        <p class="ga-icon-box-text">Create avesome portfolio sections with GoldAddons PRO Portfolio widget.</p>
                        <a href="https://goldaddons.com/widgets/portfolio/" class="ga-icon-box-link" target="_blank">
                            Learn more <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="ga-icon-box column aligncenter">
                        <div class="ga-icon-box-icon">
                            <i class="fe-icon-rotate-cw"></i>
                        </div>
                        <h3 class="ga-icon-box-title">3D Flip Box Widget</h3>
                        <p class="ga-icon-box-text">Create awesome 3D flip boxes with front/back area text or images. Pure CSS3 animations without jQuery code.</p>
                        <a href="https://goldaddons.com/widgets/3d-flip-box/" class="ga-icon-box-link" target="_blank">
                            Learn more <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                </div>
                <div class="has-3-columns">
                    
                    <div class="ga-icon-box column aligncenter">
                        <div class="ga-icon-box-icon">
                            <i class="fe-icon-map"></i>
                        </div>
                        <h3 class="ga-icon-box-title">Advanced Maps</h3>
                        <p class="ga-icon-box-text">Create advanced Google maps with GoldAddons PRO Advanced Maps widget.</p>
                        <a href="https://goldaddons.com/widgets/advanced-maps/" class="ga-icon-box-link" target="_blank">
                            Learn more <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="ga-icon-box column aligncenter">
                        <div class="ga-icon-box-icon">
                            <i class="fe-icon-facebook"></i>
                        </div>
                        <h3 class="ga-icon-box-title">Facebook Feed</h3>
                        <p class="ga-icon-box-text">Load your Facebook page news directly on your website.</p>
                        <a href="https://goldaddons.com/widgets/facebook-feed/" class="ga-icon-box-link" target="_blank">
                            Learn more <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="ga-icon-box column aligncenter">
                        <div class="ga-icon-box-icon">
                            <i class="fe-icon-image"></i>
                        </div>
                        <h3 class="ga-icon-box-title">Image Difference</h3>
                        <p class="ga-icon-box-text">Upload 2 images and show the difference.</p>
                        <a href="https://goldaddons.com/widgets/image-difference/" class="ga-icon-box-link" target="_blank">
                            Learn more <i class="fe-icon-arrow-right"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div><!-- #goldaddons-settings -->