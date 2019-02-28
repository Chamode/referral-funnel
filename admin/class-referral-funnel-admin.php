<?php
use MailchimpAPI\Mailchimp;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       example.com
 * @since      1.0.0
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/admin
 * @author     Chamode <chamodeanjana@gmail.com>
 */
class Referral_Funnel_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Referral_Funnel_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Referral_Funnel_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/referral-funnel-admin.css', array(), $this->version, 'all');
        wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons', array(), $this->version, 'all');
        wp_enqueue_style('VuetifyCSS', 'https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css', array(), $this->version, 'all');
        wp_enqueue_style('BootstrapCDN', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), '4.0.0', 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Referral_Funnel_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Referral_Funnel_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.6/dist/vue.js', [], '2.6.6');
        wp_enqueue_script('vuetify', 'https://cdn.jsdelivr.net/npm/vuetify@1.5.1/dist/vuetify.min.js', [], '1.5.1');
        wp_enqueue_script('jquery', 'https: //code.jquery.com/jquery-3.2.1.slim.min.js', [], '3.2.1');
        // wp_enqueue_script('ajax', 'https: //cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', [], '1.12.9');
        // wp_enqueue_script('bootstrapcdnJS', 'https: //maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', [], '4.0.0');
        // wp_enqueue_scripts( 'axios','https: //unpkg.com/axios/dist/axios.min.js', [], '0.18.0');

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/referral-funnel-admin.js', [], $this->version, false);
        wp_enqueue_script('plugin-sidebar-js', plugin_dir_url(__FILE__) . '/js/block.build.js',
            array('wp-i18n', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components',
                'wp-data', 'wp-plugins', 'wp-edit-post', 'wp-api', 'wp-compose'), $this->version, false);
    }

    public function addAdminMenu()
    {
        require_once 'partials/referral-funnel-admin-display.php';
        require_once 'partials/referral-funnel-mailChimp-settings.php';
        require_once 'partials/add_user_temp.php';

        add_menu_page('Referral Funnel', 'Referral Funnel', 'manage_options', 'referral-funnel-dashboard');
        add_submenu_page('referral-funnel-dashboard', 'Referral Funnel Dashboard', 'Referral Funnel Dashboard',
            'manage_options', 'referral-funnel-dashboard', 'referral_funnel_admin_display');
        add_submenu_page('referral-funnel-dashboard', 'MailChimp Settings', 'MailChimp Settings',
            'manage_options', 'referral_funnel_mailChimp_settings', 'referral_funnel_mailChimp_settings');
        add_submenu_page('referral-funnel-dashboard', 'Add User', 'Add User',
            'manage_options', 'add_user_temp', 'add_user_temp');

    }
    //remove header menu from all except admins (required since we are gonna auto login users)
    public function remove_admin_bar()
    {
        remove_cap('subscriber', 'read');

        if (current_user_can('subscriber')) {
            add_filter('show_admin_bar', '__return_false');
        }

    }

    // register custom meta tag field
    public function referral_funnel_register_meta()
    {
        register_meta(
            'post', 'referral_funnel_meta_ftype', array(
                'show_in_rest' => true,
                'single' => true,
                'type' => 'boolean',

            )
        );
        register_meta(
            'post', 'referral_funnel_meta_refNo', array(
                'show_in_rest' => true,
                'single' => true,
                'type' => 'string',

            )
        );
        register_meta(
            'post', 'referral_funnel_meta_mailChimp', array(
                'show_in_rest' => true,
                'single' => true,
                'type' => 'string',

            )
        );

    }

    public function initialize_mailchimp()
    {

        add_option('referral_funnel_mc_username', '', '', 'yes');
        add_option('referral_funnel_mc_apikey', '', '', 'yes');
    }
    public function register_router()
    {

        register_rest_route('referral-funnel/v1', '/list/', array(
            'methods' => 'GET',
            'callback' => array($this, 'ajax_endpoint_getmembers'),
        ));

        register_rest_route('referral-funnel/v1', '/addlist/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_addlist'),
        ));
        register_rest_route('referral-funnel/v1', '/getmeta/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_getmeta'),
        ));

    }

    public function ajax_endpoint_getmembers()
    {
        try {
            $mailchimp = new MailChimp(get_option('referral_funnel_mc_apikey'));
            $result = $mailchimp
                ->lists('08bda300fd')
                ->members()
                ->get();
            $result = $result->getBody();
            // $result = json_decode($result, true);
            // $result = $result['members'];

            return $result;

        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
            return "Error";
        }
    }
    public function ajax_endpoint_addlist()
    {
        $page_path = $_POST['pageURL'];

        try {
            $mailchimp = new MailChimp(get_option('referral_funnel_mc_apikey'));
            $post_params = [
                'email_address' => $_POST['email'],
                'status' => 'subscribed',
            ];

            $mailchimp
                ->lists('08bda300fd')
                ->members()
                ->post($post_params);

            $user_id = wp_create_user($_POST['email'], '', $_POST['email']);
            if (!is_wp_error($user_id)) {
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id, true);
                return wp_get_current_user();
            }
            return "error loggin in";

        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
            return "Error";
        }

    }
    public function custom_endpoint_generator_get()
    {
        register_rest_route('referral-funnel/v1', '/author(?:/(?P<id>\d+))?', [
            'methods' => 'GET',
            'callback' => array($this, 'ajax_endpoint_custom'),
        ]);

    }
    public function ajax_endpoint_custom($request_data)
    {
        $parameters = $request_data->get_params();

        // print_r( $parameters) ;

        return $parameters;
    }
    public function ajax_endpoint_getmeta($request_data)
    {
        $page_path = $_POST['pageURL'];
        $user_email = $_POST['email'];

        $user = get_user_by('email', $user_email);
        $post = get_page_by_path(basename(untrailingslashit($page_path)));
        $postID = $post->ID;
        $userID = $user->ID;

        $newPath = rtrim($page_path, "/");

        $uniquePath = $newPath . '?pid=' . $postID . '&uid=' . $userID;
        $postMeta = get_post_meta($postID);

        return $uniquePath;

    }

}
