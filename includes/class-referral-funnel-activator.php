<?php

/**
 * Fired during plugin activation
 *
 * @link       example.com
 * @since      1.0.0
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/includes
 * @author     Chamode <chamodeanjana@gmail.com>
 */
class Referral_Funnel_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        add_action('mailchimp_options', $plugin_admin, 'initialize_mailchimp');
        add_action('public_options_ref_funnel', $plugin_public, 'options_referral_funnel_init');

	}


}
