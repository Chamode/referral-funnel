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
        global $wp_roles; // global class wp-includes/capabilities.php
        $wp_roles->remove_cap('subscriber', 'read');

        if (current_user_can('subscriber')) {
            add_filter('show_admin_bar', '__return_false');
        }

    }

    // register custom meta tag field
    public function referral_funnel_register_meta()
    {
        register_meta(
            'post', 'referral_funnel_meta_listid', array(
                'show_in_rest' => true,
                'single' => true,
                'type' => 'string',

            )
        );
        register_meta(
            'post', 'referral_funnel_meta_workflowid', array(
                'show_in_rest' => true,
                'single' => true,
                'type' => 'string',

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
            'post', 'referral_funnel_meta_workflow_emailid', array(
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
            'callback' => array($this, 'ajax_endpoint_addlist_referred'),
        ));
        register_rest_route('referral-funnel/v1', '/addlist-unreferred/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_addlist_unreferred'),
        ));

        register_rest_route('referral-funnel/v1', '/getmeta/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_getmeta'),
        ));
        register_rest_route('referral-funnel/v1', '/init-referral-counter/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_init_referral_counter'),
        ));
        register_rest_route('referral-funnel/v1', '/disable-user/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_disable_user'),
        ));

    }

    public function ajax_endpoint_getmembers()
    {
        try {
            $subscribers = get_users(array('role' => 'subscriber'));
            $subsWithMeta = array();

            $count = 0;
            foreach ($subscribers as $user_id) {
                $specificMeta = get_user_meta($user_id->ID);
                $link = $specificMeta['reflink'][0];
                $pid = strstr($link, '&uid', true);
                $pid = trim(substr($pid, strpos($pid, '=') + 1));

                $refcounter = $specificMeta[$pid][0];
                $requiredref = $specificMeta['rf_current_required'][0];

                $subsWithMeta[$count]['data'] = $user_id->data;
                $subsWithMeta[$count]['meta'] = $specificMeta;
                $subsWithMeta[$count]['refcount'] = $refcounter;
                $subsWithMeta[$count]['currprogress'] = $refcounter . '/' . $requiredref;

                $count++;

            }

            return $subsWithMeta;

        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
            return "Error";
        }
    }
    public function ajax_endpoint_addlist_referred()
    {
        $page_path = $_POST['pageURL'];
        $pid = $_POST['pid'];
        $uid = $_POST['uid'];

        //get current user referral count
        $current_ref_count = get_user_meta($uid, $pid)[0];
        $new_ref_count = $current_ref_count + 1;
        try {
            $mailchimp = new MailChimp(get_option('referral_funnel_mc_apikey'));
            $post_params = [
                'email_address' => $_POST['email'],
                'status' => 'subscribed',
            ];

            $addtoList = $mailchimp
                ->lists('08bda300fd')
                ->members()
                ->post($post_params);

            // User creation and login is handled here. If the user has previously signed up, they will be auto logged in
            $user = wp_create_user($_POST['email'], '', $_POST['email']);
            if (!is_wp_error($user)) {
                if ($uid != $user->ID) {
                    update_user_meta($uid, $pid, $new_ref_count);
                }
                if (get_user_meta($uid, 'user_disabled') == []) {
                    add_user_meta($uid, 'user_disabled', "green");
                }
                wp_set_current_user($user);
                wp_set_auth_cookie($user, true);
                return get_user_meta($uid, 'user_disabled');
            } else {
                $user = get_user_by('email', $_POST['email']);
                if (!is_wp_error($user)) {
                    if ($uid != $user->ID) {
                        update_user_meta($uid, $pid, $new_ref_count);
                    }
                    if (get_user_meta($uid, 'user_disabled') == []) {
                        add_user_meta($uid, 'user_disabled', "green");
                    }

                    wp_set_current_user($user);
                    wp_set_auth_cookie($user, true);
                    return get_user_meta($uid, $pid);
                } else {
                    return $user->get_error_message();
                }

            }
            return "Code should not reach here";

        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
            return "Error";
        }

    }
    public function ajax_endpoint_addlist_unreferred()
    {
        $page_path = $_POST['pageURL'];

        $new_ref_count = $current_ref_count + 1;
        try {
            $mailchimp = new MailChimp(get_option('referral_funnel_mc_apikey'));
            $post_params = [
                'email_address' => $_POST['email'],
                'status' => 'subscribed',
            ];

            $addtoList = $mailchimp
                ->lists('08bda300fd')
                ->members()
                ->post($post_params);

            // User creation and login is handled here. If the user has previously signed up, the will be auto logged in
            $user = wp_create_user($_POST['email'], '', $_POST['email']);
            if (!is_wp_error($user)) {
                if (get_user_meta($uid, 'user_disabled') == []) {
                    add_user_meta($uid, 'user_disabled', "green");
                }

                wp_set_current_user($user);
                wp_set_auth_cookie($user, true);
                return $addtoList;
            } else {
                $user = get_user_by('email', $_POST['email']);
                if (!is_wp_error($user)) {
                    if (get_user_meta($uid, 'user_disabled') == []) {
                        add_user_meta($uid, 'user_disabled', "green");
                    }

                    wp_set_current_user($user);
                    wp_set_auth_cookie($user, true);
                    return $addtoList;
                } else {
                    return $user->get_error_message();
                }

            }
            return "Code should not reach here";

        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
            return "Error";
        }

    }
    public function ajax_endpoint_getmeta()
    {
        $page_path = $_POST['pageURL'];
        $user_email = $_POST['email'];

        $cleanPath = substr($page_path, 0, strpos($page_path, "?"));
        $cleanPath == '' ? $cleanPath = $page_path : $cleanPath = $cleanPath;
        $user = get_user_by('email', $user_email);
        $post = get_page_by_path(basename(untrailingslashit($cleanPath)));
        $postID = $post->ID;
        $userID = $user->ID;
        $postTitle = $post->post_title;
        $uniquePath = $this->generate_unique_path($cleanPath, $postID, $userID);
        if (get_user_meta($userID, 'reflink') == [] || get_user_meta($userID, $postID) == []) {
            add_user_meta($userID, 'reflink', $uniquePath);
            add_user_meta($userID, 'rf_postTitle', $postTitle);

        }

        return $uniquePath;

    }
    public function generate_unique_path($cleanPath, $postID, $userID)
    {
        return $cleanPath . '?pid=' . $postID . '&uid=' . $userID;
    }
    public function ajax_endpoint_init_referral_counter()
    {
        $pid = $_POST['pid'];
        $uid = $_POST['uid'];

        $post = get_post($pid);
        $postMeta = get_post_meta($pid);

        $meta_refNo = $postMeta['referral_funnel_meta_refNo'];
        $meta_listid = $postMeta['referral_funnel_meta_listid'];
        $meta_workflowid = $postMeta['referral_funnel_meta_workflowid'];
        $meta_email_id = $postMeta['referral_funnel_meta_workflow_emailid'];

        $user = get_user_by('id', $uid);
        $userID = $user->ID;
        $user_email = $user->data->user_email;

        if (get_user_meta($userID, $pid) == []) {
            add_user_meta($userID, $pid, 0);
            add_user_meta($userID, 'rf_current_email_id', $meta_email_id[0]);
            add_user_meta($userID, 'rf_current_required', $meta_refNo[0]);

        }

        $userMeta = get_user_meta($userID, $pid);

        if ($userMeta[0] == $meta_refNo[0]) {
            $sendemail = $this->send_email($meta_workflowid[0], $meta_email_id[0], $user_email, $userID);
            return $sendemail;
        }

        return 'You have ' . $userMeta[0] . '/' . $meta_refNo[0] . ' referrals';

    }
    public function send_email($meta_workflowid, $meta_email_id, $user_email, $userID)
    {
        $body = "Your email has been blocked";
        $user_disabled_array = get_user_meta($userID, 'user_disabled');
        $body = get_user_meta($userID, 'user_disabled');

        if ($user_disabled_array[0] == "green") {
            $api_key = get_option('referral_funnel_mc_apikey');
            $email = $user_email;

            $args = array(
                'method' => 'POST',
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
                ),
                'body' => json_encode(array(
                    'email_address' => $email,
                )),
            );
            $response = wp_remote_post('https://' . substr($api_key, strpos($api_key, '-') + 1) . '.api.mailchimp.com/3.0/automations/' . $meta_workflowid . '/emails/' . $meta_email_id . '/queue', $args);

            $body = "Email Sent";
        }
        // if ($response['response']['code'] == 204 && $body->status == $status) {
        //     echo 'The user has been successfully ' . $status . '.';
        // } else {
        //     echo '<b>' . $response['response']['code'] . $body->title . ':</b> ' . $body->detail;
        // }

        return $body;

    }
    public function ajax_endpoint_disable_user()
    {
        $user_email = $_POST['email'];
        $user_disabled = $_POST['user_disabled'];
        $array_count = $_POST['array_count'];

        $user = get_user_by('email', $user_email);

        $user_id = $user->ID;

        $user_disabled_array = get_user_meta($user_id, 'user_disabled');

        if ($user_disabled_array[0] == "red") {$user_disabled_array[0] = "green";} else { $user_disabled_array[0] = "red";}

        update_user_meta($user_id, 'user_disabled', $user_disabled_array[0]);

        return get_user_meta($user_id, 'user_disabled')[0];

    }
}
