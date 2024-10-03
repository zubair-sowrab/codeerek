<?php

/**
 * Plugin Name: Element Pack Lite - Addons for Elementor
 * Plugin URI: http://elementpack.pro/
 * Description: The all-new <a href="https://elementpack.pro/">Element Pack</a> brings incredibly advanced, and super-flexible widgets, and A to Z essential addons to the Elementor page builder for WordPress. Explore expertly-coded widgets with first-class support by experts.
 * Version: 5.9.0
 * Author: BdThemes
 * Author URI: https://bdthemes.com/
 * Text Domain: bdthemes-element-pack
 * Domain Path: /languages
 * License: GPL3
 * Elementor requires at least: 3.22
 * Elementor tested up to: 3.24.4
 */


if ( ! function_exists( 'element_pack_pro_installed' ) ) {

	function element_pack_pro_installed() {

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$file_path         = 'bdthemes-element-pack/bdthemes-element-pack.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

if ( ! function_exists( '_is_ep_pro_activated_check' ) ) {

	function _is_ep_pro_activated_check() {

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$file_path         = 'bdthemes-element-pack/bdthemes-element-pack.php';
		$installed_plugins = get_plugins();

		if ( is_plugin_active( $file_path ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'element_pack_pro_activated' ) ) {
	function element_pack_pro_activated() {
		if ( function_exists( 'bdt_license_validation' ) ) {
			if ( bdt_license_validation() ) {
				return true;
			}
		}
		if ( ! function_exists( 'bdt_license_validation' ) ) {
			if ( bdt_license_validation() ) {
				return true;
			}
		}
		return false;
	}
}

if ( ! element_pack_pro_installed() ) {

	// Some pre defined value for easy use
	define( 'BDTEP_VER', '5.9.0' );
	define( 'BDTEP_TPL_DB_VER', '1.0.0' );
	define( 'BDTEP__FILE__', __FILE__ );
	if ( ! defined( 'BDTEP_TITLE' ) ) {
		define( 'BDTEP_TITLE', 'Element Pack' );
	} // Set your own name for plugin


	// Helper function here
	require_once( dirname( __FILE__ ) . '/includes/helper.php' );
	require_once( dirname( __FILE__ ) . '/includes/utils.php' );


	require_once BDTEP_INC_PATH . 'class-pro-widget-map.php';

	/**
	 * Plugin load here correctly
	 * Also loaded the language file from here
	 */
	function bdthemes_element_pack_load_plugin() {
		load_plugin_textdomain( 'bdthemes-element-pack', false, BDTEP_PNAME . '/languages' );

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', 'bdthemes_element_pack_fail_load' );

			return;
		}

		// Widgets filters here
		require_once( BDTEP_INC_PATH . 'element-pack-filters.php' );

		// Element pack widget and assets loader
		require_once( BDTEP_PATH . 'loader.php' );

		// Notice class
		require_once( BDTEP_ADMIN_PATH . 'admin-notice.php' );
	}

	add_action( 'plugins_loaded', 'bdthemes_element_pack_load_plugin', 9 );


	/**
	 * Check Elementor installed and activated correctly
	 */
	function bdthemes_element_pack_fail_load() {

		$screen = get_current_screen();

		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		$plugin = 'elementor/elementor.php';

		if ( _is_elementor_installed() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$admin_message  = '<p>' . esc_html__( 'Ops! Element Pack not working because you need to activate the Elementor plugin first.', 'bdthemes-element-pack' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'bdthemes-element-pack' ) ) . '</p>';
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$install_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$admin_message = '<p>' . esc_html__( 'Ops! Element Pack not working because you need to install the Elementor plugin', 'bdthemes-element-pack' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'bdthemes-element-pack' ) ) . '</p>';
		}

		echo '<div class="error">' . $admin_message . '</div>';
	}

	/**
	 * Check the elementor installed or not
	 */
	if ( ! function_exists( '_is_elementor_installed' ) ) {
		function _is_elementor_installed() {
			$file_path         = 'elementor/elementor.php';
			$installed_plugins = get_plugins();

			return isset( $installed_plugins[ $file_path ] );
		}
	}

	/**
	 * Added notice after install or upgrade to v6
	 *
	 * @param string $plugin
	 * @return void
	 */
	if ( ! function_exists( 'ep_activation_redirect' ) ) {
		function ep_activation_redirect( $plugin ) {
			if ( ! did_action( 'elementor/loaded' ) ) {
				return;
			}

			if ( $plugin == plugin_basename( BDTEP__FILE__ ) ) {
				exit( wp_redirect( admin_url( 'admin.php?page=element_pack_options' ) ) );
			}
		}
	}

	add_action( 'activated_plugin', 'ep_activation_redirect', 20 );

	/**
	 * Review Automation Integration
	 */

	if ( ! function_exists( 'rc_ep_lite_plugin' ) ) {
		function rc_ep_lite_plugin() {

			if ( defined( 'BDTEP_INC_PATH' ) ) {
				require_once BDTEP_INC_PATH . 'feedback-hub/start.php';

				rc_dynamic_init( array(
					'sdk_version'  => '1.0.0',
					'plugin_name'  => 'Element Pack Lite',
					'plugin_icon'  => BDTEP_ASSETS_URL . 'images/logo.svg',
					'slug'         => 'element_pack_options',
					'menu'         => array(
						'slug' => 'element_pack_options',
					),
					'review_url'   => 'https://bdt.to/element-pack-elementor-addons-review',
					'plugin_title' => 'Yay! Great that you\'re using Element Pack Lite',
					'plugin_msg'   => '<p>Loved using Element Pack on your website? Share your experience in a review and help us spread the love to everyone right now. Good words will help the community.</p>',
				) );

			}

		}
		add_action( 'admin_init', 'rc_ep_lite_plugin' );
	}


/**
 * SDK Integration
 */

	if (!function_exists('dci_plugin_element_pack_lite')) {
			function dci_plugin_element_pack_lite() {

				// Include DCI SDK.
				require_once dirname(__FILE__) . '/dci/start.php';

				wp_register_style( 'dci-sdk-ep-lite', plugins_url( 'dci/assets/css/dci.css', __FILE__ ), array(), '1.2.1', 'all' );
				wp_enqueue_style( 'dci-sdk-ep-lite' );

				dci_dynamic_init(array(
					'sdk_version'  => '1.2.1',
					'product_id'   => 4,
					'plugin_name'  => 'Element Pack Lite', // make simple, must not empty
					'plugin_title' => 'Love using Element Pack Lite? Congrats 🎉  ( Never miss an Important Update )', // You can describe your plugin title here
					'plugin_icon'  => BDTEP_ASSETS_URL . 'images/logo.svg',
					'api_endpoint' => 'https://analytics.bdthemes.com/wp-json/dci/v1/data-insights',
					'slug'                => 'bdthemes-element-pack-lite',
					'plugin_deactivate_id'=> 'bdthemes-element-pack-lite',
					'menu'         => array(
						'slug' => 'element_pack_options',
					),
					'public_key'   => 'pk_ilWmdZmKDWVCdkkKvf5SnD5ib3nZmLJr',
					'is_premium'   => true,
					'popup_notice'        => false,
					'deactivate_feedback' => true,
					'delay_time'   => [
						'time' => 3 * DAY_IN_SECONDS,
					],
					'plugin_msg'   => '<p>Be Top-contributor by sharing non-sensitive plugin data and create an impact to the global WordPress community today! You can receive valuable emails periodically.</p>',
				));
			}
			add_action('admin_init', 'dci_plugin_element_pack_lite');
	}
}
