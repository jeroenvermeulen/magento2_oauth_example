<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = [
    'oauth_consumer_key' => preg_replace("/[^a-z0-9 ]/", '', $_POST['oauth_consumer_key']),
    'oauth_consumer_secret' => preg_replace("/[^a-z0-9 ]/", '', $_POST['oauth_consumer_secret']),
    'store_base_url' => filter_input(INPUT_POST, 'store_base_url', FILTER_SANITIZE_URL),
    'oauth_verifier' => preg_replace("/[^a-z0-9 ]/", '', $_POST['oauth_verifier'])
];

// We are storing the received data in the temp directory with 'oauth_consumer_key' as key.
// You could also use a database for that.
$dataFile = sprintf('%s/%s.json', sys_get_temp_dir(), $data['oauth_consumer_key']);
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
?>
Thank you Magento, now please send the user to 'login.php'.
