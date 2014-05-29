<?php
/**
 * Plugin Name.
 *
 * @package   Bike_Index_Sync_Admin
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 *
 * @package Bike_Index_Sync_Admin
 * @author  Your Name <email@example.com>
 */
class Bike_Index_Sync_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 */
		$plugin = Bike_Index_Sync::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_init', array( $this, 'bikeindex_sync_settings_init' ) );
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @TODO:
	 *
	 * - Rename "Bike_Index_Sync" to the name your plugin
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Bike_Index_Sync::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @TODO:
	 *
	 * - Rename "Bike_Index_Sync" to the name your plugin
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Bike_Index_Sync::VERSION );
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * @TODO:
		 *
		 * - Change 'Page Title' to the title of your plugin admin page
		 * - Change 'Menu Text' to the text for menu item for the plugin settings page
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Bike Index Widget Settings', $this->plugin_slug ),
			__( 'Bike Index Widget Settings', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * NOTE:     Actions are points in the execution of a page or process
	 *           lifecycle that WordPress fires.
	 *
	 *           Actions:    http://codex.wordpress.org/Plugin_API#Actions
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// @TODO: Define your action hook callback here
	}

	/**
	 * NOTE:     Filters are points of execution in which WordPress modifies data
	 *           before saving it or sending it to the browser.
	 *
	 *           Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *           Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// @TODO: Define your filter hook callback here
	}

	public function bikeindex_sync_settings_init()
	{
		register_setting( 'bike-index-sync-settings-group', 'bike-index-sync-settings', array( $this, 'bike_index_sync_settings_validate' ));
		add_settings_section('bike-index-sync-settings-section-one', 'API Connection Settings', array( $this, 'bike_index_sync_settings_text_general'), 'bike-index-sync-settings');

		add_settings_field('api_key', 'API Key', array( $this, 'bike_index_settings_api_key'), 'bike-index-sync-settings', 'bike-index-sync-settings-section-one');
		add_settings_field('api_secret', 'Organization ID', array( $this, 'bike_index_settings_org_key'), 'bike-index-sync-settings', 'bike-index-sync-settings-section-one');
		add_settings_field('attribution_author', 'Bike Posts Attribution Author', array( $this, 'bike_index_settings_attribution_author'), 'bike-index-sync-settings', 'bike-index-sync-settings-section-one');

		add_settings_field('sync_records', 'Sync Records Per Interval (One Hour)', array( $this, 'bike_index_settings_sync_records'), 'bike-index-sync-settings', 'bike-index-sync-settings-section-one');
	}

	public function bike_index_sync_settings_text_general() {
		echo '<p>General settings for Bike Index Sync</p>';
	}

	public function bike_index_sync_settings_text() {
		echo '<p>Sync Settings</p>';
	}

	public function bike_index_settings_api_key() {
		$options = get_option('bike-index-sync-settings');
		echo "<input id='api_key' name='bike-index-sync-settings[api_key]' size='40' type='text' value='{$options['api_key']}' />";
	}

	public function bike_index_settings_org_key() {
		$options = get_option('bike-index-sync-settings');
		echo "<input id='organization_id' name='bike-index-sync-settings[organization_id]' size='40' type='text' value='{$options['organization_id']}' />";
	}

	public function bike_index_settings_attribution_author() {
		$options = get_option('bike-index-sync-settings');
		if(isset($options['attribution_author']))
			$selected_user = $options['attribution_author'];
		else
			$selected_user = false;

		wp_dropdown_users(array('name' => 'bike-index-sync-settings[attribution_author]', 'selected' => $selected_user));

	}


	public function bike_index_settings_sync_records() {
		$options = get_option('bike-index-sync-settings');
		echo "<input id='sync_records' name='bike-index-sync-settings[sync_records]' size='40' type='text' value='{$options['sync_records']}' />";
	}


	/*
	* Validate bike-index connection credentials with the Service, display warning if not valid.
	*/

	public function bike_index_sync_settings_validate($input) {

		$this->api_key = $input['api_key'];
		$this->attribution_author = $input['attribution_author'];
		$this->organization_id = $input['organization_id'];

		//Force reload

		return $input;
	}


}