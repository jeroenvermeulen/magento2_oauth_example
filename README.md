# Magento 2 OAuth token exchange example

Improved and updated version of:
https://developer.adobe.com/commerce/webapi/get-started/authentication/gs-authentication-oauth/#oauth-example

- Callback URL: `https://___yourdomain___/path/to/endpoint.php`
- Identity link URL: `https://___yourdomain___/path/to/login.php`

Beware of this bug:  https://github.com/magento/magento2/issues/2540#issuecomment-1707299694

## Usage:

On your webserver in the `httpdocs` or `public_html` folder:
```
git  clone  https://github.com/jeroenvermeulen/magento2_oauth_example.git
cd  magento2_oauth_example
composer  install
```
