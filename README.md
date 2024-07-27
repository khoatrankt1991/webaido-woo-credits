# Woocommerce Credit Feature
## _The Last Markdown Editor, Ever_
## 1. Explore
Current flow dashboard account of woocommerce
1. Short code was triggered by `[woocommerce_my_account]`
2. After find down by search we found menu added in `wc-account-functions.php`
    We can add more menu item inside using add_filter
3. It execute runing in `class-wc-shortcodes.php` => `class-wc-shortcode-my-account.php ` => `myaccount/my-account.php`
    2.1: It call action `do_action( 'woocommerce_account_content' );`
     In handling function `woocommerce_account_content`: it using `$wp->query_vars` to check path route and then do_action by name with format:
     `'woocommerce_account_' . $key . '_endpoint'`
    In each action for specific route: it loading template
## 2. Solution:
   - So we need to define endpoint uri (by using `add_rewrite_endpoint`)
   - Create a function for credit tab as format `'woocommerce_account_' . $key . '_endpoint'` and load template
## How to debug during development
In `wp-config.php` add 
```
define('WP_DEBUG_LOG', true);
define( 'WP_ENVIRONMENT_TYPE', 'local' );
```
to trigger log by using error_log( print_r $var )
The log will be show in debug.log

## Let create plugin with this idea
