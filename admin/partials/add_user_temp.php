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

function add_user_temp()
{
    ?>
<h1>Temp page to add users</h1>
<form action="admin.php?page=add_user_temp" method="post">
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" aria-describedby="email" placeholder="email" name='email' value='<?php echo isset($_POST['email']) ? $_POST['email'] : $email; ?>' required>
  </div>
  <!-- <div class="form-group">
    <label for="APIkey">API Key</label>
    <input type="text" class="form-control" id="apikey" placeholder="API Key" name='apikey'  value='<?php echo isset($_POST['apikey']) ? $_POST['apikey'] : $apikey; ?>' required>
  </div> -->

  <button type="submit" class="btn btn-primary">Subscribe</button>
</form>


<?php

    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['email'])) {
        $email = $_POST['email'];
        // update_option('referral_funnel_mc_apikey', $_POST['apikey']);
        echo "<br>";
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

            wp_create_user($_POST['email'], '', $_POST['email']);
            $emailHead = current(explode('@', $email));

            echo '<div class="alert alert-success" role="alert">Successfully Subscribed </div>';
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
        }

    }

}

?>