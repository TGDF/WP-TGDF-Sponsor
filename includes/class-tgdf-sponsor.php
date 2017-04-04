<?php
/**
 * Class TGDF_Sponsor
 * @author Aotokitsuruya
 */
class TGDF_Sponsor
{

    /**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

    /**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    /**
     * Setup plugin and load dependencies
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        $this->plugin_name = 'TGDFSponsor';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();

    }

    /**
	 * Load the required dependencies for this plugin.
     *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tgdf-sponsor-i18n.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tgdf-sponsor-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tgdf-sponsor-public.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tgdf-sponsor-rest-controller.php';

    }

    /**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

        $i18n = new TGDF_Sponsor_I18n();
        add_action( 'plugins_loaded', array( $i18n, 'load_textdomain' ));

    }


    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $admin = new TGDF_Sponsor_Admin();
        add_action( 'init', array( $admin, 'create_post_type' ) );
        add_action( 'init', array( $admin, 'create_taxonomy' ) );
        add_action( 'after_setup_theme', array( $admin, 'add_image_size' ) );
        add_action( 'add_meta_boxes', array( $admin, 'add_link_meta_boxes') );
        add_action( 'save_post', array( $admin, 'save_link_meta' ), 10, 2 );
        add_action( 'image_size_names_choose', array( $admin, 'register_image_size_names') );

    }
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $public = new TGDF_Sponsor_Public();

    }

    /**
	 * Initialize Plugin
	 *
	 * @since    1.0.0
	 */
    public function init() {

        $this->define_admin_hooks();
        $this->define_public_hooks();
	}
}
