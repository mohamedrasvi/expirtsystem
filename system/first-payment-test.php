<?php
// Include library
include_once 'lib/GoCardless.php';
// Application Error settings....
error_reporting(E_ALL);
ini_set('display_errors','On');

$env = $_POST['rdTestEnv'];
$amt = $_POST['txtAmt'];

$firstName = $_POST['txtFirstName'];
$lastName = $_POST['txtLastName'];
$email = $_POST['txtEmailAddress'];


//$env = 'production';
if ($env == 'sandbox') {
                $appId = '3GVXY8PJ78WCEX4K8TA31YRB8ADWQA558YC46AJPFSKDZ3BPBZEEHP5052SN5A8W';
                $app_secret = 'A6PF1SAK1GZVF63KEBN6ZZXF2N9A5ZQ96FPAERB43ZT1FEYWGQQW6AVG6T1QYYF0';
                $merchant_id = '07FSZSE75F';
                $access_token = '9BA5YTMYBXM2J0SKWC08628GB88VNA8GJFCSJFPQW1EK5Z26CVMGJXSHWX49K8B5';
            } else {
                $appId = 'G5Y825A5YEVAPE03VJYSFMANNYHZRNTK7RGS19CBF0424XHSQKVHKM6PX561F5DC';
                $app_secret = '9W36S2DEP4D24GMAXPSMQ8BYETKRY69RBS8M175RW901M0GN3SV08PDQZDAPE5QC';
                $merchant_id = '07FSZSE75F';
                $access_token = '4N4BV7P1AG2VBWC055TR1F47MCXTHHTVFY5CE5EWR6G22E2GQ50CH6YW8J9AYHV0';
            }

// Sandbox is the default - uncomment to change to production
// GoCardless::$environment = 'production';

// Config vars
$account_details = array(
  'app_id'        => $appId,
  'app_secret'    => $app_secret,
  'merchant_id'   => $merchant_id,
  'access_token'  => $access_token
);

GoCardless::$environment = $env;
// Initialize GoCardless
GoCardless::set_account_details($account_details);

// New pre-authorization
$payment_details = array(
  'max_amount'      => $amt,
  'interval_length' => 1,
  'interval_unit'   => 'month',
  'redirect_uri' => 'https://portal.pluspro.com/modules/gateways/gocardless/redirect.php',
  'user'    => array(
    'first_name'  => $firstName,
    'last_name'   => $lastName,
    'email'       => $email
    )
);

$pre_auth_url = GoCardless::new_pre_authorization_url($payment_details);
header("Location: $pre_auth_url");
exit;
