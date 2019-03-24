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

        register_rest_route('referral-funnel/v1', '/disable-user/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_disable_user'),
        ));
        register_rest_route('referral-funnel/v1', '/user-register/', array(
            'methods' => 'POST',
            'callback' => array($this, 'ajax_endpoint_register_user'),
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
        $pid = url_to_postid( $_POST['pageURL'] );
        $uid = $_POST['uid'];
        $data = json_decode(html_entity_decode(stripslashes($_POST['data'])));
        $user_email = $data[1]->value;

        // $userReferrer = get_user_by('id', $uid);
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
                $pid = url_to_postid( $link );

                $refcounter = $specificMeta[$pid][0];
                $requiredref = $specificMeta['rf_current_required'][0];
                $response[$count]['specificMeta'] = $specificMeta;
                $response[$count]['pid'] = $pid;

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
        $pid = url_to_postid($_POST['pageURL']);

        $uid = $_POST['uid'];
        $data = json_decode(html_entity_decode(stripslashes($_POST['data'])));
        $user_email = $data[1]->value;
        $user_name = $data[0]->value;
        $postMeta = $this->getPostMeta($_POST['pageURL']);
        $meta_baselink = $postMeta['referral_funnel_meta_baselink'];
        $response['pageUrl'] = $_POST['pageURL'];
        $response['postMeta'] = $postMeta;
        //get current user referral count
        $current_ref_count = get_user_meta($uid, $pid)[0];
        $new_ref_count = $current_ref_count + 1;

        //Check if user exists
        $user = get_user_by('email', $user_email); //THIS IS USER ID
        
        //If user account does not exist
        if (!is_wp_error($user)) {
            $response['create_user'] = 'creating';
            //Create User
            $user = wp_create_user($user_name, '', $user_email);

            add_user_meta($user, $postMeta['pid'], 0);
            add_user_meta($user, 'rf_current_email_id', 'Free Subscriber.');
            add_user_meta($user, 'rf_current_required', '0');
            add_user_meta($user, 'reflink', '-');
            add_user_meta($user, 'rf_postTitle', $postTitle = get_the_title($postMeta['pid']));
            $response['pose_title'] = get_the_title($postMeta['pid']);
        }

        update_user_meta($uid, $pid, $new_ref_count);

        if (get_user_meta($user, 'user_disabled') == []) {
            add_user_meta($user, 'user_disabled', "green");
        }

        wp_set_current_user($user);
        wp_set_auth_cookie($user, true);
        $response['user'] = $user;

        //Checks if the original user should get the email
        $userMeta = get_user_meta($uid, $_POST['pid']);
        $oriPost = get_post_meta($_POST['pid']);
        if ($userMeta[0] >= $oriPost['referral_funnel_meta_refNo'][0]) {
            $meta_workflowid = $oriPost['referral_funnel_meta_workflowid'];
            $meta_email_id = $oriPost['referral_funnel_meta_workflow_emailid'];
            $oriUser = get_user_by('id', $uid);
            $userID = $oriUser->ID;
            $user_email = $oriUser->data->user_email;

            $sendemail = $this->send_email($meta_workflowid[0], $meta_email_id[0], $user_email, $userID);
            return $sendemail;
        }
            
        return $response;
        // return get_user_meta($uid, $pid);

    }

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
        $postTitle = get_the_title($postID);
        $uniquePath = $this->generate_unique_path($baselink, $postID, $userID);
        add_user_meta($userID, 'reflink', $uniquePath);
        add_user_meta($userID, 'rf_postTitle', $postTitle);

        return $uniquePath;

    }

    public function ajax_endpoint_register_user()
    {
        $postMeta = $this->getPostMeta($_POST['pageURL']);
        $meta_baselink = $postMeta['referral_funnel_meta_baselink'];

        $data = json_decode(html_entity_decode(stripslashes($_POST['data'])));
        $user_email = $data[1]->value;
        $user_name = $data[0]->value;

        //Check if user exists
        $user = get_user_by('email', $user_email); //THIS IS USER ID

        //If user account does not exist
        if (!$user) {
            //Create User
            $user = wp_create_user($user_email, '', $user_email);
        }
        $response['postMeta'] = $this->getPostMeta($_POST['pageURL']);
        add_user_meta($user, url_to_postid( $meta_baselink[0] ), 0);
        add_user_meta($user, 'rf_current_email_id', $postMeta['referral_funnel_meta_workflow_emailid'][0]);
        add_user_meta($user, 'rf_current_required', $postMeta['referral_funnel_meta_refNo'][0]);

        $this->referral_generate_link($meta_baselink[0], $postMeta['pid'], $user_email);

        if (get_user_meta($user, 'user_disabled') == []) {
            add_user_meta($user, 'user_disabled', "green");
        }

        //Logs user in
        wp_set_current_user($user);
        wp_set_auth_cookie($user, true);

        $response['user'] = $user;
        $response['referrals']['goal'] = $postMeta['referral_funnel_meta_refNo'][0];
        $response['referrals']['currentProgress'] = 0;

        $response['link'] = $this->getRefLink($user->ID, $meta_baselink[0]);

        return $response;

    }

    public function generate_unique_path($cleanPath, $postID, $userID)
    {
        return $cleanPath . '?pid=' . $postID . '&uid=' . $userID;
    }

    public function ajax_endpoint_init_page()
    {
        $urlpid = url_to_postid( $_POST['pageURL'] );
        $urluid = $_POST['uid'];

        $response = array('success' => false);

        if (!wp_verify_nonce($_POST['_wpnonce'], 'wp_rest')) {
            return http_response_code(403);
        }

        $response['success'] = true;
        $postMeta = $this->getPostMeta($_POST['pageURL']);

        $meta_refNo = $postMeta['referral_funnel_meta_refNo'][0];
        $meta_listid = $postMeta['referral_funnel_meta_listid'];
        $meta_workflowid = $postMeta['referral_funnel_meta_workflowid'];
        $meta_email_id = $postMeta['referral_funnel_meta_workflow_emailid'];
        $meta_baselink = $postMeta['referral_funnel_meta_baselink'][0];

        //If Number of Referrals not set from Page creation Do not initialised
        if (($meta_refNo == '' || $meta_refNo == 0 || $meta_refNo == null) && $urlpid == '0' && $urluid == '0') {
            $response['init'] = false;
            $response['test'] = 'test';
            return $response;
        }

        $response['init'] = true;

        $user = wp_get_current_user();
        $response['user'] = $user;

        //Checks if user has signed up for this post
        if ( $user->ID != 0) {
            $meta = get_user_meta($user->ID);
            $response['hasUserSignedUp'] = array_key_exists($urlpid, $meta);
            return $response;
        }

        //Checks if user is logged in
        if ($user->ID === 0) {
            //If user not logged in do nothing
            return $response;
        }

        //If user is logged in, get all required data
        $uid = $user->ID;

        $user_email = $user->data->user_email;
        //Old Uniquepath
        $refLink = $this->getRefLink($uid, $meta_baselink);
        $response['uid'] = $uid;
        $response['pid'] = $postMeta['pid'];

        $response['referrals']['currentProgress'] = get_user_meta($uid, $postMeta['pid'])[0];
        $response['referrals']['goal'] = $meta_refNo;

        $response['shareLink'] = $refLink;


        return $response;

    }

    public function getRefLink($userID, $baselink)
    {
        $linkArray = get_user_meta($userID, 'reflink');
        $currentLink = '';

        //Finding the current ref link for the current page user is on
        foreach ($linkArray as $link) {
            if (strpos($link, $baselink) !== false) {
                $currentLink = $link;
                break;
            }
        }

        return $currentLink;
    }

    public function isUserSignedUp()
    {

    }

    public function getPostMeta($url)
    {
        $pid = url_to_postid($url);
        $postMeta = get_post_meta($pid);
        $postMeta['pid'] = $pid;

        return $postMeta;
    }
}
