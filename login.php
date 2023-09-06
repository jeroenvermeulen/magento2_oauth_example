<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$consumerKey = preg_replace("/[^a-z0-9 ]/", '', $_GET['oauth_consumer_key']);
$callbackUrl = filter_input(INPUT_GET, 'success_call_back', FILTER_SANITIZE_URL);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <style>
        body > div {
            padding: 1em;
            margin: 1em auto;
            1em;
            width: fit-content;
        }

        div.warning {
            background-color: #f44336;
            color: white;
        }

        form {
            background-color: #cccccc;
            border: 0;
            margin: 0 auto;
            padding: 0.5em;;
            width: fit-content;
        }

        label {
            display: inline-block;
            width: 10em;
            margin: 0.2em;
        }

        input {
            display: inline-block;
            width: 20em;
            margin: 0.2em;
        }

        input.ro {
            background-color: #cccccc;
            border: 1px inset;
        }

        form > div {
            align: center;
            margin: 0 auto;
            width: fit-content;
        }
    </style>
</head>
<body>
<div class="warning">
    <div>Security warning: you need to update 'checklogin.php' to actually check if the user exists in your
        application.
    </div>
    <div>If you don't, anyone could change the tokens in your secret file.</div>
</div>
<form name="form1" method="post" action="checklogin.php">
    <div>
        <label for="oauth_consumer_key">Consumer Key:</label>
        <input type="text" class="ro" readonly name="oauth_consumer_key" id="oauth_consumer_key"
               value="<?php echo htmlspecialchars($consumerKey); ?>"/>
    </div>
    <div>
        <label for="callback_url">Callback URL:</label>
        <input type="text" class="ro" readonly name="callback_url" id="callback_url"
               value="<?php echo htmlspecialchars($callbackUrl); ?>"/>
    </div>
    <div>
        <label for="username">Username:</label>
        <input name="username" type="text" id="username" value="doesn't matter"/>
    </div>
    <div>
        <label for="password">Password:</label>
        <input name="password" type="password" id="password" value="anything"/>
    </div>
    <div>
        <label></label>
        <input type="submit" name="Submit" value="Login"/>
    </div>
</form>
<div>
    <div>During testing beware of <a href="https://github.com/magento/magento2/issues/2540#issuecomment-1707299694"
                                     target="_blank">this bug</a>.
    </div>
    <div>You may need to clean up old tries from the Magento database using:</div>
    <pre>DELETE FROM `oauth_token` WHERE `type` = 'request';</pre>
</div>
</body>
</html>