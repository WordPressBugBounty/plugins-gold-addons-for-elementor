<?php
/*
 Plugin Name: Gold Addons for Elementor
 Plugin URI: https://goldaddons.com/
 Description: The Gold Addons plugin extends the capabilities of the Elementor page builder by introducing a new set of widgets.
 Version: 1.3.2
 Author: GoldAddons
 Author URI: https://goldaddons.com/pricing/
 License: GPLv3
 Text Domain: gold-addons-for-elementor
 Elementor tested up to: 3.23.4
*/

namespace GoldAddons;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit();
}

/**
 * GoldAddons_For_Elementor
 *
 * @since 1.0.0
 */
final class Plugin
{
    /**
     * Plugin Version
     * 
     * @since 1.3.2
     * @var string The plugin version.
     */
    public $version;

    /**
     * Plugin Version
     *
     * @since 1.0.0
     * @var string The plugin version.
     */
    const VERSION = '1.3.2';

    /**
     * Plugin Development
     *
     * @since 1.0.0
     * @var string The plugin development mode.
     */
    const DEVELOPMENT = false;

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * @var GoldAddons_For_Elementor The single instance of the class.
     */
    private static $_instance = null;

    /**
     * License
     *
     * @since 1.2.0
     * @return bool
     */
    private $license;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     * @static
     * @return GoldAddons_For_Elementor An instance of the class.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {
        if (self::DEVELOPMENT) {
            $this->version = esc_attr(uniqid());
        } else {
            $this->version = self::VERSION;
        }

        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts_on_front' ] );
    }

    /**
	 * Enqueue front scripts.
	 *
	 * Registers all front scripts and enqueues them.
	 *
	 * Fired by `wp_enqueue_scripts` action.
	 *
	 * @since 1.2.6
	 * @access public
	 */
	public function enqueue_scripts_on_front() {
		$gold_addons_feedback_fragments = [
			'url' => esc_url( admin_url('admin-ajax.php') ), 
			'nonce' => wp_create_nonce( 'gold_addons_nonce' ),
            'activation_data_sent' => esc_html(sanitize_text_field(get_option('gold_addons_activate_data_sent')))
		];

		wp_enqueue_script( 'gold-addons-activation-feedback', plugins_url('/gold-addons-for-elementor/assets/js/gold-addons-activation-feedback.js'), array( 'jquery' ), uniqid(), true );

		wp_localize_script( 
			'gold-addons-activation-feedback', 
			'gold_addons_activation_obj', 
			$gold_addons_feedback_fragments
		);
	}

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function i18n()
    {
        load_plugin_textdomain('gold-addons-for-elementor');
    }

    /**
     * Define constants.
     *
     * @since 1.1.5
     * @access private
     */
    private function constants()
    {
        if (!defined('GOLDADDONS_VERSION')) {
            define('GOLDADDONS_VERSION', $this->version);
        }
        if (!defined('GOLDADDONS_BASENAME')) {
            define('GOLDADDONS_BASENAME', plugin_basename(__FILE__));
        }
        if (!defined('GOLDADDONS_DIR')) {
            define('GOLDADDONS_DIR', plugin_dir_path(__FILE__));
        }
        if (!defined('GOLDADDONS_PRO_DIR')) {
            define(
                'GOLDADDONS_PRO_DIR',
                WP_CONTENT_DIR . '/plugins/gold-addons-pro-for-elementor/'
            );
        }
        if (!defined('GOLDADDONS_URI')) {
            define('GOLDADDONS_URI', plugin_dir_url(__FILE__));
        }
        if (!defined('GOLDADDONS_CSS_URI')) {
            define('GOLDADDONS_CSS_URI', plugins_url('assets/css', __FILE__));
        }
        if (!defined('GOLDADDONS_IMAGES_URI')) {
            define('GOLDADDONS_IMAGES_URI', plugins_url('assets/images', __FILE__));
        }
        if (!defined('GOLDADDONS_WIDGETS_URI')) {
            define(
                'GOLDADDONS_WIDGETS_URI',
                plugins_url('assets/widgets', __FILE__)
            );
        }
        if (!defined('GOLDADDONS_VENDOR_URI')) {
            define(
                'GOLDADDONS_VENDOR_URI',
                plugins_url('assets/vendor', __FILE__)
            );
        }
    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     * @access public
     */
    public function init()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [
                $this,
                'admin_notice_missing_main_plugin',
            ]);
            return;
        }

        // Check for required Elementor version
        if (
            !version_compare(
                ELEMENTOR_VERSION,
                self::MINIMUM_ELEMENTOR_VERSION,
                '>='
            )
        ) {
            add_action('admin_notices', [
                $this,
                'admin_notice_minimum_elementor_version',
            ]);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [
                $this,
                'admin_notice_minimum_php_version',
            ]);
            return;
        }

        $this->constants();

        // Include the helper class.
        require_once __DIR__ . '/includes/class-helper.php';

        // Include admin.php file.
        if (is_admin()) {
            require_once __DIR__ . '/includes/admin/class-admin.php';
        }

        // Include functions.php file.
        require_once __DIR__ . '/includes/functions.php';

        // Editor style
        add_action('elementor/editor/after_enqueue_styles', [
            $this,
            'editor_styles',
        ]);

        // Editor scripts
        add_action('elementor/editor/after_enqueue_scripts', [
            $this,
            'editor_scripts',
        ]);

        // Register Widget Styles
        add_action('elementor/frontend/after_enqueue_styles', [
            $this,
            'register_widget_styles',
        ]);

        // Register Widget Scripts
        add_action('elementor/frontend/after_register_scripts', [
            $this,
            'register_widget_scripts',
        ]);

        // Register Widgets
        add_action('elementor/widgets/register', [$this, 'init_widgets']);

        // Localize Settings
        add_filter('elementor/editor/localize_settings', [
            $this,
            'promote_pro_elements',
        ]);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__(
                '"%1$s" requires "%2$s" to be installed and activated.',
                'gold-addons-for-elementor'
            ),
            '<strong>' .
                esc_html__('GoldAddons Plugin', 'gold-addons-for-elementor') .
                '</strong>',
            '<a href="' .
                admin_url() .
                'plugin-install.php?tab=plugin-information&plugin=elementor&TB_iframe=true&width=772&height=624" class="thickbox open-plugin-details-modal"><strong>' .
                esc_html__('Elementor Plugin', 'gold-addons-for-elementor') .
                '</strong></a>'
        );

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            $message
        );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__(
                '"%1$s" requires "%2$s" version %3$s or greater.',
                'gold-addons-for-elementor'
            ),
            '<strong>' .
                esc_html__('GoldAddons Plugin', 'gold-addons-for-elementor') .
                '</strong>',
            '<strong>' .
                esc_html__('Elementor', 'gold-addons-for-elementor') .
                '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            $message
        );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__(
                '"%1$s" requires "%2$s" version %3$s or greater.',
                'gold-addons-for-elementor'
            ),
            '<strong>' .
                esc_html__('GoldAddons Plugin', 'gold-addons-for-elementor') .
                '</strong>',
            '<strong>' .
                esc_html__('PHP', 'gold-addons-for-elementor') .
                '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            $message
        );
    }

    /**
     * Register Editor Styles
     *
     * Include editor styling file.
     *
     * @since 1.0.0
     * @access public
     */
    public function editor_styles()
    {
        wp_enqueue_style(
            'goldaddons-icons',
            plugins_url('assets/css/icons.min.css', __FILE__),
            [],
            $this->version
        );
        wp_enqueue_style(
            'goldaddons-editor',
            plugins_url('assets/css/editor.css', __FILE__),
            [],
            $this->version
        );
    }

    /**
     * Register Editor Scripts
     *
     * @since 1.2.0
     * @access public
     */
    public function editor_scripts()
    {
        wp_enqueue_script(
            'goldaddons-editor-promo',
            plugins_url('assets/js/utils.min.js', __FILE__),
            [],
            uniqid()
        );
    }

    /**
     * Register Widgets Styles
     *
     * Include widgets styling files.
     *
     * @since 1.0.0
     * @access public
     */
    public function register_widget_styles()
    {
        // FontAwesome as fallback
        wp_register_style(
            'font-awesome-5-all',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
            false,
            $this->version
        );

        wp_register_style(
            'font-awesome-4-shim',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/v4-shims.min.css',
            false,
            $this->version
        );

        wp_register_script(
            'font-awesome-4-shim',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/js/v4-shims.min.js',
            false,
            $this->version
        );

        // General
        wp_register_style(
            'goldaddons-icons',
            GOLDADDONS_CSS_URI . '/icons.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-general',
            GOLDADDONS_CSS_URI . '/general.min.css',
            [],
            $this->version
        );

        // Vendor
        wp_register_style(
            'goldaddons-magnific-popup',
            GOLDADDONS_VENDOR_URI . '/magnific-popup/magnific-popup.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-owl-carousel',
            GOLDADDONS_VENDOR_URI . '/owl-carousel/owl-carousel.min.css',
            [],
            $this->version
        );

        // Free widgets.
        wp_register_style(
            'goldaddons-alert',
            GOLDADDONS_WIDGETS_URI . '/alert/alert.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-button',
            GOLDADDONS_WIDGETS_URI . '/button/button.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-blog',
            GOLDADDONS_WIDGETS_URI . '/blog/blog.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-contact-form-7',
            GOLDADDONS_WIDGETS_URI . '/contact-form-7/contact-form-7.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-modal',
            GOLDADDONS_WIDGETS_URI . '/modal/modal.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-popover',
            GOLDADDONS_WIDGETS_URI . '/popover/popover.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-price-box',
            GOLDADDONS_WIDGETS_URI . '/price-box/price-box.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-team',
            GOLDADDONS_WIDGETS_URI . '/team/team.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-tooltip',
            GOLDADDONS_WIDGETS_URI . '/tooltip/tooltip.min.css',
            [],
            $this->version
        );

        // Pro widgets.
        wp_register_style(
            'goldaddons-3d-flip-box',
            GOLDADDONS_WIDGETS_URI . '/3d-flip-box/3d-flip-box.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-accordion',
            GOLDADDONS_WIDGETS_URI . '/accordion/accordion.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-portfolio',
            GOLDADDONS_WIDGETS_URI . '/portfolio/portfolio.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-countdown',
            GOLDADDONS_WIDGETS_URI . '/countdown/countdown.min.css',
            [],
            $this->version
        );
        wp_register_style(
            'goldaddons-progress-bar',
            GOLDADDONS_WIDGETS_URI . '/progress-bar/progress-bar.min.css',
            [],
            $this->version
        );
    }

    /**
     * Register Widgets Scripts
     *
     * Include widgets scripts files.
     *
     * @since 1.0.0
     * @access public
     */
    public function register_widget_scripts()
    {
        // Vendor
        wp_register_script(
            'goldaddons-popper',
            GOLDADDONS_VENDOR_URI . '/popper/popper.min.js',
            ['jquery'],
            $this->version
        );
        wp_register_script(
            'goldaddons-bootstrap',
            GOLDADDONS_VENDOR_URI . '/bootstrap/bootstrap.min.js',
            ['goldaddons-popper', 'jquery'],
            $this->version
        );
        wp_register_script(
            'goldaddons-isotope',
            GOLDADDONS_VENDOR_URI . '/isotope/isotope.pkgd.min.js',
            ['jquery'],
            $this->version,
            true
        );
        wp_register_script(
            'goldaddons-imagesloaded',
            GOLDADDONS_VENDOR_URI . '/imagesloaded/imagesloaded.pkgd.min.js',
            ['jquery'],
            $this->version,
            true
        );
        wp_register_script(
            'goldaddons-eventmove',
            GOLDADDONS_VENDOR_URI . '/eventmove/event.move.min.js',
            ['jquery'],
            $this->version,
            true
        );
        wp_register_script(
            'goldaddons-infinite-scroll',
            GOLDADDONS_VENDOR_URI . '/infinite-scroll/infinite-scroll.min.js',
            ['jquery'],
            $this->version
        );
        wp_register_script(
            'goldaddons-magnific-popup',
            GOLDADDONS_VENDOR_URI . '/magnific-popup/magnific-popup.min.js',
            ['jquery'],
            $this->version
        );
        wp_register_script(
            'goldaddons-magnific-popup-init',
            GOLDADDONS_VENDOR_URI .
                '/magnific-popup/magnific-popup-init.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-owl-carousel',
            GOLDADDONS_VENDOR_URI . '/owl-carousel/owl-carousel.min.js',
            ['jquery'],
            $this->version
        );
        wp_register_script(
            'goldaddons-owl-carousel-init',
            GOLDADDONS_VENDOR_URI . '/owl-carousel/owl-carousel-init.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-jquery-countdown',
            GOLDADDONS_VENDOR_URI . '/countdown/jquery.countdown.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-tweenmax',
            GOLDADDONS_VENDOR_URI . '/tweenmax/tweenmax.min.js',
            [],
            $this->version
        );
        wp_register_script(
			'lottie-js',
			GOLDADDONS_VENDOR_URI . '/lottie-js/lottie-js.min.js',
			[
				'jquery',
            ],
			$this->version
		);

        // Free widgets.
        wp_register_script(
            'goldaddons-alert',
            GOLDADDONS_WIDGETS_URI . '/alert/alert.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-blog',
            GOLDADDONS_WIDGETS_URI . '/blog/blog.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-image-carousel',
            GOLDADDONS_WIDGETS_URI . '/image-carousel/image-carousel.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-modal',
            GOLDADDONS_WIDGETS_URI . '/modal/modal.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-team',
            GOLDADDONS_WIDGETS_URI . '/team/team.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-countdown',
            GOLDADDONS_WIDGETS_URI . '/countdown/countdown.min.js',
            [],
            $this->version
        );
        wp_register_script(
            'goldaddons-progress-bar',
            GOLDADDONS_WIDGETS_URI . '/progress-bar/progress-bar.min.js',
            [],
            $this->version
        );
        

        // Pro widgets.
        wp_register_script(
            'goldaddons-portfolio',
            GOLDADDONS_WIDGETS_URI . '/portfolio/portfolio.min.js',
            [],
            $this->version
        );
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them.
     *
     * @param Widgets_Manager $widgets_manager Elementor widgets manager.
     *
     * @since 1.0.0
     * @access public
     */
    public function init_widgets($widgets_manager)
    {
        $widgets = wp_normalize_path(GOLDADDONS_DIR . '/widgets/*.php');
        foreach (glob($widgets) as $widget) {
            $GoldAddons_Widget = basename($widget, '.php');
            $GoldAddons_Widget = str_replace('-', ' ', $GoldAddons_Widget);
            $GoldAddons_Widget = ucwords($GoldAddons_Widget);
            $GoldAddons_Widget = str_replace(' ', '_', $GoldAddons_Widget);
            $GoldAddons_Widget = '\GoldAddons\Widget\\' . $GoldAddons_Widget;

            require_once $widget;

            $widgets_manager->register(new $GoldAddons_Widget());
        }
    }

    /**
     * List pro widgets
     *
     * @since 1.2.0
     */
    public function promote_pro_elements($config)
    {
        $this->license = unserialize( base64_decode( get_option('_goldaddons_license') ) );

        if (
            isset($this->license['licenseKey']) &&
            !empty($this->license['licenseKey']) &&
            isset($this->license['activationData']['token']) &&
            !empty($this->license['activationData']['token']) && 
            is_plugin_active(
                'gold-addons-pro-for-elementor/gold-addons-pro-for-elementor.php'
            )
        ) {
            $this->license = true;
        } else {
            $this->license = false;
        }

        if ($this->license) {
            return $config;
        }

        $promotion_widgets = [];

        if (isset($config['promotionWidgets'])) {
            $promotion_widgets = $config['promotionWidgets'];
        }

        $combine_array = array_merge($promotion_widgets, [
            [
                'name' => 'gold-addons-accordion',
                'title' => __('Accordion', 'gold-addons-for-elementor'),
                'icon' => 'gaicon eicon-accordion',
                'categories' => '["gold-addons-for-elementor"]',
            ],
            [
                'name' => 'gold-addons-pro-advanced-maps',
                'title' => __('Advanced Maps', 'gold-addons-for-elementor'),
                'icon' => 'gaicon eicon-google-maps',
                'categories' => '["gold-addons-for-elementor"]',
            ],
            [
                'name' => 'gold-addons-pro-facebook-feed',
                'title' => __('Facebook Feed', 'gold-addons-for-elementor'),
                'icon' => 'gaicon eicon-facebook-comments',
                'categories' => '["gold-addons-for-elementor"]',
            ],
            [
                'name' => 'gold-addons-3d-flip-box',
                'title' => __('3D Flip Box', 'gold-addons-for-elementor'),
                'icon' => 'gaicon eicon-flip-box',
                'categories' => '["gold-addons-for-elementor"]',
            ],
            [
                'name' => 'gold-addons-image-difference',
                'title' => __('Image Difference', 'gold-addons-for-elementor'),
                'icon' => 'gaicon eicon-image-rollover',
                'categories' => '["gold-addons-for-elementor"]',
            ],
            [
                'name' => 'gold-addons-typed',
                'title' => __('Typed', 'gold-addons-for-elementor'),
                'icon' => 'gaicon eicon-animation-text',
                'categories' => '["gold-addons-for-elementor"]',
            ],
            [
                'name' => 'gold-addons-portfolio',
                'title' => __('Portfolio', 'gold-addons-for-elementor'),
                'icon' => 'gaicon eicon-thumbnails-half',
                'categories' => '["gold-addons-for-elementor"]',
            ],
        ]);

        $config['promotionWidgets'] = $combine_array;

        return $config;
    }
}

Plugin::instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
