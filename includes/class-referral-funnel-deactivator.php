<?php

/**
 * Fired during plugin deactivation
 *
 * @link       example.com
 * @since      1.0.0
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/includes
 * @author     Chamode <chamodeanjana@gmail.com>
 */
class Referral_Funnel_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        delete_option('referral_funnel_mc_username');
        delete_option('referral_funnel_mc_apikey');
        delete_option('referral_funnel_countdownstarttime');


    }

}
