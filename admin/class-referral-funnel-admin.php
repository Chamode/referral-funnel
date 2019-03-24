<?php

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

        wp_enqueue_script('vue', plugin_dir_url(__FILE__) . 'js/vue.min.js', [], '2.6.6');
        wp_enqueue_script('vuetify', 'https://cdn.jsdelivr.net/npm/vuetify@1.5.1/dist/vuetify.min.js', [], '1.5.1');
        wp_enqueue_script('jquery', 'https: //code.jquery.com/jquery-3.2.1.slim.min.js', [], '3.2.1');
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/referral-funnel-admin.js', [], $this->version, false);
        wp_enqueue_script('plugin-sidebar-js', plugin_dir_url(__FILE__) . '/js/block.build.js',
            array('wp-i18n', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components',
                'wp-data', 'wp-plugins', 'wp-edit-post', 'wp-api', 'wp-compose'), $this->version, false);
    }

    public function addAdminMenu()
    {
        require_once 'partials/referral-funnel-admin-display.php';
        require_once 'partials/referral-funnel-mailChimp-settings.php';

        add_menu_page('Referral Funnel', 'Referral Funnel', 'manage_options', 'referral-funnel-dashboard', '', 'dashicons-admin-links');
        add_submenu_page('referral-funnel-dashboard', 'Referral Funnel Dashboard', 'Referral Funnel Dashboard',
            'manage_options', 'referral-funnel-dashboard', 'referral_funnel_admin_display');
        add_submenu_page('referral-funnel-dashboard', 'MailChimp Settings', 'MailChimp Settings',
            'manage_options', 'referral_funnel_mailChimp_settings', 'referral_funnel_mailChimp_settings');

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
        register_meta(
            'post', 'referral_funnel_meta_baselink', array(
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
        register_rest_route('referral-funnel/v1', '/user-authentication/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_user_authentication'),
        ));
        register_rest_route('referral-funnel/v1', '/init-page/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_init_page'),
        ));
        register_rest_route('referral-funnel/v1', '/check-user/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_check_user'),
        ));

    }
    public function ajax_endpoint_check_user()
    {
        $pid = $_POST['pid'];
        $uid = $_POST['uid'];
        $data = json_decode(html_entity_decode(stripslashes($_POST['data'])));
        $user_email = $data[1]->value;

        $userReferrer = get_user_by('id', $uid);
        $userRefd = get_user_by('email', $user_email);

        if ($userRefd->ID == $uid) {
            return true;
        }

        if ($userRefd != false) {
            $meta = get_user_meta($userRefd->ID);
            return array_key_exists($pid, $meta);
        }
        return false;
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
        $pid = $_POST['pid'];
        $uid = $_POST['uid'];
        $data = json_decode(html_entity_decode(stripslashes($_POST['data'])));
        $user_email = $data[1]->value;
        $user_name = $data[0]->value;

        //get current user referral count
        $current_ref_count = get_user_meta($uid, $pid)[0];
        $new_ref_count = $current_ref_count + 1;
        try {
            // $mailchimp = new MailChimp(get_option('referral_funnel_mc_apikey'));
            // $post_params = [
            //     'email_address' => $_POST['email'],
            //     'status' => 'subscribed',
            // ];

            // $addtoList = $mailchimp
            //     ->lists('08bda300fd')
            //     ->members()
            //     ->post($post_params);

            // User creation and login is handled here. If the user has previously signed up, they will be auto logged in
            $user = wp_create_user($user_name, '', $user_email);
            if (!is_wp_error($user)) {
                if ($uid != $user->ID) {
                    update_user_meta($uid, $pid, $new_ref_count);
                }
                if (get_user_meta($user, 'user_disabled') == []) {
                    add_user_meta($user, 'user_disabled', "green");
                }
                wp_set_current_user($user);
                wp_set_auth_cookie($user, true);
                return get_user_meta($uid, $pid);

            } else {
                $user = get_user_by('email', $user_email);
                if (!is_wp_error($user)) {
                    if ($uid != $user->ID) {
                        update_user_meta($uid, $pid, $new_ref_count);
                    }
                    if (get_user_meta($user, 'user_disabled') == []) {
                        add_user_meta($user, 'user_disabled', "green");
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
    // public function ajax_endpoint_addlist_unreferred()
    // {
    //     $page_path = $_POST['pageURL'];

    //     $new_ref_count = $current_ref_count + 1;
    //     try {
    //         $mailchimp = new MailChimp(get_option('referral_funnel_mc_apikey')); //authenticate Mailchimp
    //         //set up parameters based on user input
    //         $post_params = [
    //             'email_address' => $_POST['email'],
    //             'status' => 'subscribed',
    //         ];

    //         //add list function (library is used)
    //         $addtoList = $mailchimp
    //             ->lists('08bda300fd')
    //             ->members()
    //             ->post($post_params);

    //         // User creation and login is handled here. If the user has previously signed up, the will be auto logged in
    //         $user = wp_create_user($_POST['email'], '', $_POST['email']);
    //         if (!is_wp_error($user)) {
    //             if (get_user_meta($uid, 'user_disabled') == []) {
    //                 add_user_meta($uid, 'user_disabled', "green");
    //             }

    //             wp_set_current_user($user);
    //             wp_set_auth_cookie($user, true);
    //             return $addtoList;
    //         } else {
    //             $user = get_user_by('email', $_POST['email']);
    //             if (!is_wp_error($user)) {
    //                 if (get_user_meta($uid, 'user_disabled') == []) {
    //                     add_user_meta($uid, 'user_disabled', "green");
    //                 }

    //                 wp_set_current_user($user);
    //                 wp_set_auth_cookie($user, true);
    //                 return $addtoList;
    //             } else {
    //                 return $user->get_error_message();
    //             }

    //         }
    //         return "Code should not reach here";

    //     } catch (Exception $e) {
    //         echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
    //         return "Error";
    //     }

    // }

    // public function ajax_endpoint_init_referral_counter()
    // {
    //     $pid = $_POST['pid'];
    //     $uid = $_POST['uid'];

    //     $post = get_post($pid);
    //     $postMeta = get_post_meta($pid);

    //     $meta_refNo = $postMeta['referral_funnel_meta_refNo'];
    //     $meta_listid = $postMeta['referral_funnel_meta_listid'];
    //     $meta_workflowid = $postMeta['referral_funnel_meta_workflowid'];
    //     $meta_email_id = $postMeta['referral_funnel_meta_workflow_emailid'];

    //     if ($meta_refNo[0] == '' || $meta_refNo[0] == 0 || $meta_refNo[0] == null) {
    //         return 'Referral Plugin Not Initialised.';
    //     }

    //     $user = get_user_by('id', $uid);
    //     $userID = $user->ID;
    //     $user_email = $user->data->user_email;

    //     if (get_user_meta($userID, $pid) == []) {
    //         add_user_meta($userID, $pid, 0);
    //         add_user_meta($userID, 'rf_current_email_id', $meta_email_id[0]);
    //         add_user_meta($userID, 'rf_current_required', $meta_refNo[0]);

    //     }

    //     $userMeta = get_user_meta($userID, $pid);

    //     if ($userMeta[0] >= $meta_refNo[0]) {
    //         $sendemail = $this->send_email($meta_workflowid[0], $meta_email_id[0], $user_email, $userID);
    //         return $sendemail;
    //     }

    //     return 'You have ' . $userMeta[0] . '/' . $meta_refNo[0] . ' referrals';

    // }
    public function send_email($meta_workflowid, $meta_email_id, $user_email, $userID)
    {
        $body = "Your email has been blocked";
        $user_disabled_array = get_user_meta($userID, 'user_disabled');

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
    public function referral_generate_link($baselink, $postID, $user_email)
    {

        $user = get_user_by('email', $user_email);
        $userID = $user->ID;
        $uniquePath = $this->generate_unique_path($baselink, $postID, $userID);
        if (get_user_meta($userID, 'reflink') == [] && get_user_meta($userID, $postID) == []) {
            add_user_meta($userID, 'reflink', $uniquePath);
            add_user_meta($userID, 'rf_postTitle', $postTitle);

        }

        return $uniquePath;

    }
    public function ajax_endpoint_user_authentication()
    {
        $pid = url_to_postid($_POST['pageURL']);
        $postMeta = get_post_meta($pid);
        $meta_baselink = $postMeta['referral_funnel_meta_baselink'];

        $data = json_decode(html_entity_decode(stripslashes($_POST['data'])));
        $user_email = $data[1]->value;
        $user_name = $data[1]->value;

        // User creation and login is handled here. If the user has previously signed up, the will be auto logged in
        $user = wp_create_user($user_name, '', $user_email);
        if (!is_wp_error($user)) {
            if (get_user_meta($user, 'user_disabled') == []) {
                add_user_meta($user, 'user_disabled', "green");
            }
            wp_set_current_user($user);
            wp_set_auth_cookie($user, true);

            $link = $this->referral_generate_link($meta_baselink[0], $pid, $user_email);

            return $link;
        } else {
            $user = get_user_by('email', $user_email);
            if (!is_wp_error($user)) {
                if (get_user_meta($uid, 'user_disabled') == []) {
                    add_user_meta($uid, 'user_disabled', "green");
                }
                wp_set_current_user($user);
                wp_set_auth_cookie($user, true);
                $link = referral_generate_link($postID, $data);

                $link = $this->referral_generate_link($meta_baselink[0], $pid, $user_email);

            } else {
                return $user->get_error_message();
            }
        }
        return;

    }

    public function generate_unique_path($cleanPath, $postID, $userID)
    {
        return $cleanPath . '?pid=' . $postID . '&uid=' . $userID;
    }

    public function ajax_endpoint_init_page()
    {
        $response = array('success' => false);

        if (!wp_verify_nonce($_POST['_wpnonce'], 'wp_rest')) {
            return http_response_code(403);
        }

        $response['userData'] = wp_get_current_user();

        $uid = $response['userData']->ID;
        $pid = url_to_postid($_POST['pageURL']);

        // $post = get_post($pid);
        $postMeta = get_post_meta($pid);

        $meta_refNo = $postMeta['referral_funnel_meta_refNo'];
        $meta_listid = $postMeta['referral_funnel_meta_listid'];
        $meta_workflowid = $postMeta['referral_funnel_meta_workflowid'];
        $meta_email_id = $postMeta['referral_funnel_meta_workflow_emailid'];
        $meta_baselink = $postMeta['referral_funnel_meta_baselink'];

        if ($meta_refNo[0] == '' || $meta_refNo[0] == 0 || $meta_refNo[0] == null) {
            $response['message'] = 'Referral Plugin Not Initialised.';
            return $response;
        }

        $response['success'] = true;

        $user = get_user_by('id', $uid);
        $userID = $user->ID;
        $user_email = $user->data->user_email;
        $uniquePath = $this->referral_generate_link($meta_baselink[0], $pid, $user_email);

        if (get_user_meta($userID, $pid) == []) {
            add_user_meta($userID, $pid, 0);
            add_user_meta($userID, 'rf_current_email_id', $meta_email_id[0]);
            add_user_meta($userID, 'rf_current_required', $meta_refNo[0]);

        }

        $userMeta = get_user_meta($userID, $pid);

        if ($userMeta[0] >= $meta_refNo[0]) {
            $sendemail = $this->send_email($meta_workflowid[0], $meta_email_id[0], $user_email, $userID);
            return $sendemail;
        }

        $response['referrals']['currentProgress'] = $userMeta[0];
        $response['referrals']['goal'] = $meta_refNo[0];

        $response['shareLink'] = $uniquePath;

        return $response;

    }
}
