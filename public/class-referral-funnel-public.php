<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       example.com
 * @since      1.0.0
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/public
 * @author     Chamode <chamodeanjana@gmail.com>
 */
class Referral_Funnel_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/referral-funnel-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script('vuejs', "https://cdn.jsdelivr.net/npm/vue/dist/vue.js", array(), $this->version, false);
        wp_enqueue_script('momentjs', plugin_dir_url(__FILE__) . 'js/moment.js', array(), $this->version, false);
        wp_enqueue_script('jwtechlab-timer', plugin_dir_url(__FILE__) . 'js/referral-funnel-public.js', array('jquery', 'vuejs', 'momentjs'), $this->version, true);

    }

    public function options_referral_funnel_init()
    {
        add_option('referral_funnel_countdownstarttime', '', '', 'yes');
    }
    public function shortcode_referral_funnel_init()
    {
        add_shortcode('ref_funnel_timer', array($this, 'ref_funnel_timer_func'));
        add_shortcode('ref_funnel_unlock_content', array($this, 'ref_funnel_unlock_content_func'));

    }

    public function ref_funnel_timer_func()
    {
        $user_id = get_current_user_id();
        if ($user_id != 0) {
            $user_meta_time = get_user_meta($user_id, 'init_time');
            if ($user_meta_time == []) {
                add_user_meta($user_id, 'init_time', current_time('mysql'));
                wp_enqueue_script('ref_funnel_shortcode', plugin_dir_url(__FILE__) . 'js/timer-countdown.js', [], $this->version, false);
                return "User 1";

            } else {
                wp_enqueue_script('ref_funnel_shortcode', plugin_dir_url(__FILE__) . 'js/timer-countdown.js', [], $this->version, false);
                return "User 2";

            }
        } else {
            return "User not initialised";
        }
        return "Code should not reach here";

    }

    public function register_router()
    {

        register_rest_route('referral-funnel/v1', 'countdown', array(
            'methods' => 'GET',
            'callback' => array($this, 'ajax_endpoint_getcountdown'),
        ));
    }

    public function ajax_endpoint_getcountdown()
    {
        $user_id = get_current_user_id();
        $user_meta_time = get_user_meta(2, 'init_time');
        $maxTime = get_option('referral_funnel_countdownstarttime');

        $arrTimer = [$user_meta_time, $maxTime];
        return 'test';
    }

    public function ref_funnel_unlock_content_func()
    {
        // wp_enqueue_style('bootstrap4', 'https: //stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
wp_enqueue_style('bootstrap4', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), '4.0.0', 'all');

        wp_enqueue_script('ref_funnel_shortcode', plugin_dir_url(__FILE__) . 'js/sign-up.js', [], $this->version, false);
        
    }
}
