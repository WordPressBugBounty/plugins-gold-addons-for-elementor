<?php
/**
 *  Helper Class
 * 
 * @package GoldAddons for Elementor
 * @since 1.1.5
 */

 namespace GoldAddons;

 // Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Helper {

    /**
     * Get Contact Form 7 [ if exists ]
     * 
     * @access public
     * @return array
     */
    public static function get_wpcf7_list() {
        $options = array();

        if ( function_exists( 'wpcf7' ) ) {
            $wpcf7_form_list = get_posts( array(
                'post_type' => 'wpcf7_contact_form',
                'showposts' => 999,
            ) );
            $options[0] = esc_html__( 'Select a Contact Form', 'gold-addons-for-elementor' );
            if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) {
                foreach ( $wpcf7_form_list as $post ) {
                    $options[$post->ID] = $post->post_title;
                }
            } else {
                $options[0] = esc_html__( 'Create a Form First', 'gold-addons-for-elementor' );
            }
        }
        return $options;
    }

}
