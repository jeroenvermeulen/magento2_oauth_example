<!DOCTYPE html>
<html lang="en-US">
<head>
    <style>
        form {border: 0; margin: 0 auto; padding: 0.5em; ; width: fit-content;}
        label {display: inline-block; width: 10em; margin: 0.2em; }
        input {display: inline-block; width: 30em; margin: 0.2em; }
        input.ro { background-color: #cccccc; border: 1px inset; }
        form > div {align: center; margin: 0 auto; width: fit-content;}
    </style>
</head>
<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './vendor/autoload.php';

$consumerKey = preg_replace("/[^a-z0-9 ]/", '', $_POST['oauth_consumer_key']);
$dataFile = sprintf('%s/%s.json', sys_get_temp_dir(), $consumerKey);
if (!file_exists($dataFile)) {
    throw new Exception(sprintf("Invalid consumer key: '%s'", $consumerKey));
}
$data = json_decode(file_get_contents($dataFile), true);
$callbackUrl = filter_input(INPUT_POST, 'callback_url', FILTER_SANITIZE_URL);

$credentials = new \OAuth\Common\Consumer\Credentials(
    $data['oauth_consumer_key'],
    $data['oauth_consumer_secret'],
    rtrim($data['store_base_url'],'/')
);
$oAuthClient = new OauthClient($credentials);
$requestToken = $oAuthClient->requestRequestToken();
$accessToken = $oAuthClient->requestAccessToken(
    $requestToken->getRequestToken(),
    $data['oauth_verifier'],
    $requestToken->getRequestTokenSecret()
);
?>
<form action="#" onsubmit="return false;">
<?php foreach ($accessToken->getExtraParams() as $key => $value): ?>
    <div>
        <label for="<?php echo htmlspecialchars($key) ?>"><?php echo htmlspecialchars($key) ?></label>
        <input type="text" class="ro" readonly id="<?php echo htmlspecialchars($key) ?>" value="<?php echo htmlspecialchars($value); ?>"/>
    </div>
<?php endforeach; ?>
    <div>
        <label for="request_token">Request Token:</label>
        <input type="text" class="ro" readonly id="request_token" value="<?php echo htmlspecialchars($accessToken->getRequestToken()); ?>"/>
    </div>
    <div>
        <label for="request_token_secret">Request Token Secret:</label>
        <input type="text" class="ro" readonly id="request_token_secret" value="<?php echo htmlspecialchars($accessToken->getRequestTokenSecret()); ?>"/>
    </div>
    <div>
        <label for="access_token">Access Token:</label>
        <input type="text" class="ro" readonly id="access_token" value="<?php echo htmlspecialchars($accessToken->getAccessToken()); ?>"/>
    </div>
    <div>
        <label for="access_token_secret">Access Token Secret:</label>
        <input type="text" class="ro" readonly id="access_token_secret" value="<?php echo htmlspecialchars($accessToken->getAccessTokenSecret()); ?>"/>
    </div>
    <div>
        <label for="end_of_life">End Of Life:</label>
        <input type="text" class="ro" readonly id="end_of_life" value="<?php echo htmlspecialchars($accessToken->getEndOfLife()); ?>"/>
    </div>
</form>
<?php
printf('Redirect user to: <a href="%s">%s</a>', htmlspecialchars($callbackUrl), $callbackUrl);
?>
</body>
</html>
