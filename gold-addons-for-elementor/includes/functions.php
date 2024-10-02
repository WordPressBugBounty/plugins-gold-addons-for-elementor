<?php

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Retrieve Blog Categories
 *
 * @since 1.0.3
 * @return array
 */
function goldaddons_get_blog_categories() {
    $categories = get_categories();
    
    foreach( $categories as $category ) {
        $id = esc_attr( $category->term_id );
        $cat[$id] = esc_html( $category->name );
    }
    
    return $cat;
}

/**
 * Add new "Gold Addons" Category to The Elementor
 *
 * @since 1.0.0
 */
function goldaddons_add_elementor_widget_categories( $elements_manager ) {
    
    // Add New Elementor Category
	$elements_manager->add_category(
		'gold-addons-for-elementor',
		[
			'title' => esc_attr__( 'Gold Addons', 'gold-addons-for-elementor' ),
			'icon' => 'fa fa-plug',
		]
	);
    
}
add_action( 'elementor/elements/categories_registered', 'goldaddons_add_elementor_widget_categories' );

/**
 * Custom Excerpt Length
 *
 * @since 1.0.3
 */
function goldaddons_the_excerpt( $settings) {
    $length = isset( $settings['excerpt_length'] ) ? $settings['excerpt_length'] : '55';
    $readmore = isset( $settings['excerpt_readmore'] ) ? $settings['excerpt_readmore'] : esc_html__( 'Read More', 'gold-addons-for-elementor' );
    
	$excerpt = get_the_excerpt();
	$length++;

	if ( mb_strlen( $excerpt ) > $length ) {
		$subex = mb_substr( $excerpt, 0, $length - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
        // Post tags.
        if( 'yes' == $settings['post_tags'] ) {
            echo '<div class="ga-blog-post-tags">';
                the_tags( '', ' ', '' );
            echo '</div>';
        }
        if( 'yes' == $settings['readmore_link'] ) {
		  echo '<p><a href="'. get_the_permalink() .'" class="ga-link-readmore">'. $readmore . '</a></p>';
        }
	} else {
		echo $excerpt;
	}
}

/**
 * Widget Blog Pagination
 *
 * @since 1.0.3
 */
function goldaddons_pagination( $query = null, $settings = null ) {
    $big        = 999999999;
    $translated = esc_html__( 'Page', 'gold-addons-for-elementor' );
    $prev_link  = get_previous_posts_link( __( '&laquo; Older Entries', 'gold-addons-for-elementor' ) );
    $next_link  = get_next_posts_link( __( 'Newer Entries &raquo;', 'gold-addons-for-elementor' ) );
    
    if( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    }
    elseif( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else { 
        $paged = 1; 
    }
    
    if( 'pagination' !== $settings['load_posts_type'] ) {
        $btn_txt = isset( $settings['load_more_button_txt'] ) ? esc_html( $settings['load_more_button_txt'] ) : esc_html__( 'Load More', 'gold-addons-for-elementor' );
        $class   = ' ga-infinite';
        $display = ' style="display:none;"';
        $loader  = '<div class="ga-posts-load-status">';
            $loader .= '<div class="loader-ellips infinite-scroll-request">';
                $loader .= '<span class="loader-ellips__dot"></span>';
                $loader .= '<span class="loader-ellips__dot"></span>';
                $loader .= '<span class="loader-ellips__dot"></span>';
                $loader .= '<span class="loader-ellips__dot"></span>';
            $loader .= '</div>';
            $loader .= '<p class="infinite-scroll-last">'. esc_html__( 'End of content.', 'gold-addons-for-elementor' ) .'</p>';
            $loader .= '<p class="infinite-scroll-error">'. esc_html__( 'No more posts to load.', 'gold-addons-for-elementor' ) .'</p>';
        $loader .= '</div>';
        if( 'load_more_button' == $settings['load_posts_type'] ) {
            $loader .= '<p id="infinite-load-more">';
                $loader .= '<a id="ga-infinite-load-more-btn" class="ga-infinite-load-more-btn ga-button"><i class="fa fa-spinner fa-pulse fa-fw"></i> '. $btn_txt .'</a>';
            $loader .= '</p>';
        }
    } else {
        $class   = '';
        $display = '';
        $loader  = '';
    }
    
    if( $query->max_num_pages > 1 ) {
        
        echo $loader;
        
        echo '<div id="goldaddons-pagination" class="goldaddons-pagination'. $class .'"'. $display .'>';
        
            echo paginate_links( array(
                'base'                  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'                => '?paged=%#%',
                'current'               => max( 1, $paged ),
                'prev_text'             => '<i class="fa fa-angle-double-left"></i>',
                'next_text'             => '<i class="fa fa-angle-double-right"></i>',
                'total'                 => $query->max_num_pages,
                'type'                  => 'list',
                'before_page_number'    => '<span class="screen-reader-text">' . $translated . '</span>'
            ) );
        
        echo '</div>';
        
    }
}

/**
 * GoldAddons Icons
 *
 * The GoldAddons plugin icons.
 *
 * @since 1.1.2
 * @return array
 */
function goldaddons_icons() {
    return [
        'ga-icon-activity' => 'activity',
        'ga-icon-airplay' => 'airplay',
        'ga-icon-alert-circle' => 'circle',
        'ga-icon-alert-octagon' => 'octagon',
        'ga-icon-alert-triangle' => 'triangle',
        'ga-icon-align-center' => 'center',
        'ga-icon-align-justify' => 'justify',
        'ga-icon-align-left' => 'align-left',
        'ga-icon-align-right' => 'align-right',
        'ga-icon-anchor' => 'anchor',
        'ga-icon-aperture' => 'aperture',
        'ga-icon-archive' => 'archive',
        'ga-icon-arrow-down-circle' => 'arrow-down-circle',
        'ga-icon-arrow-down-left' => 'arrow-down-left',
        'ga-icon-arrow-down-right' => 'arrow-down-right',
        'ga-icon-arrow-down' => 'arrow-down',
        'ga-icon-arrow-left-circle' => 'arrow-left-circle',
        'ga-icon-arrow-left' => 'arrow-left',
        'ga-icon-arrow-right-circle' => 'arrow-right-circle',
        'ga-icon-arrow-right' => 'arrow-right',
        'ga-icon-arrow-up-circle' => 'arrow-up-circle',
        'ga-icon-arrow-up-left' => 'arrow-up-left',
        'ga-icon-arrow-up-right' => 'arrow-up-right',
        'ga-icon-arrow-up' => 'arrow-up',
        'ga-icon-at-sign' => 'at-sign',
        'ga-icon-award' => 'award',
        'ga-icon-bar-chart-2' => 'bar-chart-2',
        'ga-icon-bar-chart' => 'bar-chart',
        'ga-icon-battery-charging' => 'battery-charging',
        'ga-icon-battery' => 'battery',
        'ga-icon-bell-off' => 'bell-off',
        'ga-icon-bell' => 'bell',
        'ga-icon-bluetooth' => 'bluetooth',
        'ga-icon-bold' => 'bold',
        'ga-icon-book-open' => 'book-open',
        'ga-icon-book' => 'book',
        'ga-icon-bookmark' => 'bookmark',
        'ga-icon-box' => 'box',
        'ga-icon-briefcase' => 'briefcase',
        'ga-icon-calendar' => 'calendar',
        'ga-icon-camera-off' => 'camera-off',
        'ga-icon-camera' => 'camera',
        'ga-icon-cast' => 'cast',
        'ga-icon-check-circle' => 'check-circle',
        'ga-icon-check-square' => 'check-square',
        'ga-icon-check' => 'check',
        'ga-icon-chevron-down' => 'chevron-down',
        'ga-icon-chevron-left' => 'chevron-left',
        'ga-icon-chevron-right' => 'chevron-right',
        'ga-icon-chevron-up' => 'chevron-up',
        'ga-icon-chevrons-down' => 'chevrons-down',
        'ga-icon-chevrons-left' => 'chevrons-left',
        'ga-icon-chevrons-right' => 'chevrons-right',
        'ga-icon-chevrons-up' => 'chevrons-up',
        'ga-icon-chrome' => 'chrome',
        'ga-icon-circle' => 'circle',
        'ga-icon-clipboard' => 'clipboard',
        'ga-icon-clock' => 'clock',
        'ga-icon-cloud-drizzle' => 'cloud-drizzle',
        'ga-icon-cloud-lightning' => 'cloud-lightning',
        'ga-icon-cloud-off' => 'cloud-off',
        'ga-icon-cloud-rain' => 'cloud-rain',
        'ga-icon-cloud-snow' => 'cloud-snow',
        'ga-icon-cloud' => 'cloud',
        'ga-icon-code' => 'code',
        'ga-icon-codepen' => 'codepen',
        'ga-icon-codesandbox' => 'codesanbox',
        'ga-icon-coffee' => 'coffee',
        'ga-icon-columns' => 'columns',
        'ga-icon-command' => 'command',
        'ga-icon-compass' => 'compass',
        'ga-icon-copy' => 'copy',
        'ga-icon-corner-down-left' => 'corner-down-left',
        'ga-icon-corner-down-right' => 'corner-down-right',
        'ga-icon-corner-left-down' => 'corner-left-down',
        'ga-icon-corner-left-up' => 'corner-left-up',
        'ga-icon-corner-right-down' => 'corner-right-down',
        'ga-icon-corner-right-up' => 'corner-right-up',
        'ga-icon-corner-up-left' => 'corner-up-left',
        'ga-icon-corner-up-right' => 'corner-up-right',
        'ga-icon-cpu' => 'cpu',
        'ga-icon-credit-card' => 'credit-card',
        'ga-icon-crop' => 'crop',
        'ga-icon-crosshair' => 'crosshair',
        'ga-icon-database' => 'database',
        'ga-icon-delete' => 'delete',
        'ga-icon-disc' => 'disc',
        'ga-icon-dollar-sign' => 'dollar-sign',
        'ga-icon-download-cloud' => 'download-cloud',
        'ga-icon-download' => 'download',
        'ga-icon-droplet' => 'droplet',
        'ga-icon-edit-2' => 'edit-2',
        'ga-icon-edit-3' => 'edit-3',
        'ga-icon-edit' => 'edit',
        'ga-icon-external-link' => 'external-link',
        'ga-icon-eye-off' => 'eye-off',
        'ga-icon-eye' => 'eye',
        'ga-icon-facebook' => 'facebook',
        'ga-icon-fast-forward' => 'fast-forward',
        'ga-icon-feather' => 'feather',
        'ga-icon-figma' => 'figma',
        'ga-icon-file-minus' => 'file-minus',
        'ga-icon-file-plus' => 'file-plus',
        'ga-icon-file-text' => 'file-text',
        'ga-icon-file' => 'file',
        'ga-icon-film' => 'film',
        'ga-icon-filter' => 'filter',
        'ga-icon-flag' => 'flag',
        'ga-icon-folder-minus' => 'folder-minus',
        'ga-icon-folder-plus' => 'folder-plus',
        'ga-icon-folder' => 'folder',
        'ga-icon-framer' => 'framer',
        'ga-icon-frown' => 'frown',
        'ga-icon-gift' => 'gift',
        'ga-icon-git-branch' => 'git-branch',
        'ga-icon-git-commit' => 'git-commit',
        'ga-icon-git-merge' => 'git-merge',
        'ga-icon-git-pull-request' => 'git-pull-request',
        'ga-icon-github' => 'github',
        'ga-icon-gitlab' => 'gitlab',
        'ga-icon-globe' => 'globe',
        'ga-icon-grid' => 'grid',
        'ga-icon-hard-drive' => 'hard-drive',
        'ga-icon-hash' => 'hash',
        'ga-icon-headphones' => 'headphones',
        'ga-icon-heart' => 'heart',
        'ga-icon-help-circle' => 'help-circle',
        'ga-icon-hexagon' => 'hexagon',
        'ga-icon-home' => 'home',
        'ga-icon-image' => 'image',
        'ga-icon-inbox' => 'inbox',
        'ga-icon-info' => 'info',
        'ga-icon-instagram' => 'instagram',
        'ga-icon-italic' => 'italic',
        'ga-icon-key' => 'key',
        'ga-icon-layers' => 'layers',
        'ga-icon-layout' => 'layout',
        'ga-icon-life-buoy' => 'life-buoy',
        'ga-icon-link-2' => 'link-2',
        'ga-icon-link' => 'link',
        'ga-icon-linkedin' => 'linkedin',
        'ga-icon-list' => 'list',
        'ga-icon-loader' => 'loader',
        'ga-icon-lock' => 'lock',
        'ga-icon-log-in' => 'log-in',
        'ga-icon-log-out' => 'log-out',
        'ga-icon-mail' => 'mail',
        'ga-icon-map-pin' => 'map-pin',
        'ga-icon-map' => 'map',
        'ga-icon-maximize-2' => 'maximize-2',
        'ga-icon-maximize' => 'maximize',
        'ga-icon-meh' => 'meh',
        'ga-icon-menu' => 'menu',
        'ga-icon-message-circle' => 'message-circle',
        'ga-icon-message-square' => 'message-square',
        'ga-icon-mic-off' => 'mic-off',
        'ga-icon-mic' => 'mic',
        'ga-icon-minimize-2' => 'minimize-2',
        'ga-icon-minimize' => 'minimize',
        'ga-icon-minus-circle' => 'minus-circle',
        'ga-icon-minus-square' => 'minus-square',
        'ga-icon-minus' => 'minus',
        'ga-icon-monitor' => 'monitor',
        'ga-icon-moon' => 'moon',
        'ga-icon-more-horizontal' => 'more-horizontal',
        'ga-icon-more-vertical' => 'more-vertical',
        'ga-icon-mouse-pointer' => 'mouse-pointer',
        'ga-icon-move' => 'move',
        'ga-icon-music' => 'music',
        'ga-icon-navigation-2' => 'navigation-2',
        'ga-icon-navigation' => 'navigation',
        'ga-icon-octagon' => 'octagon',
        'ga-icon-package' => 'package',
        'ga-icon-paperclip' => 'paperclip',
        'ga-icon-pause-circle' => 'pause-circle',
        'ga-icon-pause' => 'pause',
        'ga-icon-pen-tool' => 'pen-tool',
        'ga-icon-percent' => 'percent',
        'ga-icon-phone-call' => 'phone-call',
        'ga-icon-phone-forwarded' => 'phone-forwarded',
        'ga-icon-phone-incoming' => 'phone-incoming',
        'ga-icon-phone-missed' => 'phone-missed',
        'ga-icon-phone-off' => 'phone-off',
        'ga-icon-phone-outgoing' => 'phone-outgoing',
        'ga-icon-phone' => 'phone',
        'ga-icon-pie-chart' => 'pie-chart',
        'ga-icon-play-circle' => 'play-circle',
        'ga-icon-play' => 'play',
        'ga-icon-plus-circle' => 'plus-circle',
        'ga-icon-plus-square' => 'plus-square',
        'ga-icon-plus' => 'plus',
        'ga-icon-pocket' => 'pocket',
        'ga-icon-power' => 'power',
        'ga-icon-printer' => 'printer',
        'ga-icon-radio' => 'radio',
        'ga-icon-refresh-ccw' => 'refresh-ccw',
        'ga-icon-repeat' => 'repeat',
        'ga-icon-rewind' => 'rewind',
        'ga-icon-rotate-ccw' => 'rotate-ccw',
        'ga-icon-rotate-cw' => 'rotate-cw',
        'ga-icon-rss' => 'rss',
        'ga-icon-save' => 'save',
        'ga-icon-scissors' => 'scissors',
        'ga-icon-search' => 'search',
        'ga-icon-send' => 'send',
        'ga-icon-server' => 'server',
        'ga-icon-settings' => 'settings',
        'ga-icon-share-2' => 'share-2',
        'ga-icon-share' => 'share',
        'ga-icon-shield-off' => 'shield-off',
        'ga-icon-shield' => 'shield',
        'ga-icon-shopping-bag' => 'shopping-bag',
        'ga-icon-shopping-cart' => 'shopping-cart',
        'ga-icon-shuffle' => 'shuffle',
        'ga-icon-sidebar' => 'sidebar',
        'ga-icon-skip-back' => 'skip-back',
        'ga-icon-skip-forward' => 'skip-forward',
        'ga-icon-slack' => 'slack',
        'ga-icon-slash' => 'slash',
        'ga-icon-sliders' => 'sliders',
        'ga-icon-smartphone' => 'smartphone',
        'ga-icon-smile' => 'smile',
        'ga-icon-speaker' => 'speaker',
        'ga-icon-square' => 'square',
        'ga-icon-star' => 'star',
        'ga-icon-stop-circle' => 'stop-circle',
        'ga-icon-sun' => 'sun',
        'ga-icon-sunrise' => 'sunrise',
        'ga-icon-sunset' => 'sunset',
        'ga-icon-tablet' => 'tablet',
        'ga-icon-tag' => 'tag',
        'ga-icon-target' => 'target',
        'ga-icon-terminal' => 'terminal',
        'ga-icon-thermometer' => 'thermometer',
        'ga-icon-thumbs-down' => 'thumbs-down',
        'ga-icon-thumbs-up' => 'thumbs-up',
        'ga-icon-toggle-left' => 'toggle-left',
        'ga-icon-toggle-right' => 'toggle-right',
        'ga-icon-tool' => 'tool',
        'ga-icon-trash-2' => 'trash-2',
        'ga-icon-trash' => 'trash',
        'ga-icon-trello' => 'trello',
        'ga-icon-trending-down' => 'trending-down',
        'ga-icon-trending-up' => 'trending-up',
        'ga-icon-triangle' => 'triangle',
        'ga-icon-truck' => 'truck',
        'ga-icon-tv' => 'tv',
        'ga-icon-twitch' => 'twitch',
        'ga-icon-twitter' => 'twitter',
        'ga-icon-type' => 'type',
        'ga-icon-umbrella' => 'umbrella',
        'ga-icon-underline' => 'underline',
        'ga-icon-unlock' => 'unlock',
        'ga-icon-upload-cloud' => 'upload-cloud',
        'ga-icon-upload' => 'upload',
        'ga-icon-user-check' => 'user-check',
        'ga-icon-user-minus' => 'user-minus',
        'ga-icon-user-plus' => 'user-plus',
        'ga-icon-user-x' => 'user-x',
        'ga-icon-user' => 'user',
        'ga-icon-users' => 'users',
        'ga-icon-video-off' => 'video-off',
        'ga-icon-video' => 'video',
        'ga-icon-voicemail' => 'voicemail',
        'ga-icon-volume-1' => 'volume-1',
        'ga-icon-volume-2' => 'volume-2',
        'ga-icon-volume-x' => 'volume-x',
        'ga-icon-volume' => 'volume',
        'ga-icon-watch' => 'watch',
        'ga-icon-wifi-off' => 'wifi-off',
        'ga-icon-wifi' => 'wifi',
        'ga-icon-wind' => 'wind',
        'ga-icon-x-circle' => 'x-circle',
        'ga-icon-x-octagon' => 'x-octagon',
        'ga-icon-x-square' => 'x-square',
        'ga-icon-x' => 'x',
        'ga-icon-youtube' => 'youtube',
        'ga-icon-zap-off' => 'zap-off',
        'ga-icon-zap' => 'zap',
        'ga-icon-zoom-in' => 'zoom-in',
        'ga-icon-zoom-out' => 'zoom-out'
    ];
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
