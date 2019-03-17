<?php

use MailchimpAPI\Mailchimp;

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       example.com
 * @since      1.0.0
 *
 * @package    Referral_Funnel
 * @subpackage Referral_Funnel/admin/partials
 */

function referral_funnel_mailChimp_settings()
{
    $username = get_option('referral_funnel_mc_username');
    $apikey = get_option('referral_funnel_mc_apikey');
    $countdownmaxtime = get_option('referral_funnel_countdownstarttime');
    ?>
<div>
<h1>MailChimp Authentication</h1>
<form action="admin.php?page=referral_funnel_mailChimp_settings" method="post">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" aria-describedby="username" placeholder="Username" name='username' value='<?php echo isset($_POST['username']) ? $_POST['username'] : $username; ?>' required>
  </div>
  <div class="form-group">
    <label for="APIkey">API Key</label>
    <input type="text" class="form-control" id="apikey" placeholder="API Key" name='apikey'  value='<?php echo isset($_POST['apikey']) ? $_POST['apikey'] : $apikey; ?>' required>
  </div>
  <div class="form-group">
    <label for="countdownmaxtime">Countdown Max Time</label>
    <input type="text" class="form-control" id="apikey" placeholder="Countdown Max Time" name='countdownmaxtime'  value='<?php echo isset($_POST['countdownmaxtime']) ? $_POST['countdownmaxtime'] : $countdownmaxtime; ?>' required>
  </div>
  <button type="submit" class="btn btn-primary">Authenticate</button>
</form>



</div>
<?php

    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['username']) and isset($_POST['apikey']) and isset($_POST['countdownmaxtime'])) {
        $username = $_POST['username'];
        update_option('referral_funnel_mc_username', $_POST['username']);
        update_option('referral_funnel_mc_apikey', $_POST['apikey']);
        update_option('referral_funnel_countdownstarttime', $_POST['countdownmaxtime']);

        echo "<br>";
        try {
            $mailchimp = new MailChimp($_POST['apikey']);
            echo '<div class="alert alert-success" role="alert">Successfully Authenticated </div>';
            echo '<div>
                    <p>Use [ref_funnel_timer] to display the countdown timer.</p>
                    <p>Use [ref_funnel_unlock_content] to display generated link and number of referrals. </p>
                  </div>';
        }
        catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
        }


    }

}

?>
