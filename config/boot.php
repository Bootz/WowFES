<?php
/**********************************
 * Custome configurations
 **********************************/
// This is for CSS bugs of IE 6/7/8/9,
// http://robertnyman.com/2010/02/18/css-files-downloaded-twice-in-internet-explorer-with-protocol-relative-urls/
define('__fqdn', 'antbsd.twbbs.org');

// You can ignore http/https and domain
#define('__site', '/~ant');
define('__site', '');

// Set default timezone
date_default_timezone_set("Asia/Taipei");

// Set application mode, support 'test', 'development' and 'production'
$application_mode = 'test';

// Set cache mode, support 'apc', 'wincache', 'memcache' and 'memcaced'
$cache_mode = 'apc';

// Set default language
$default_lang = 'en_us';

// Set site key, for encryption/decryption
$site_key = 'Cei4Wai4ohcoo3daeHooFiek5Nah3Eet';

// Set database configurations
$db_config = array(
    'DB_DRIVER'          => 'mysql',
    'DB_HOST'            => 'localhost',
    'DB_USER'            => 'root',
    'DB_PASSWORD'        => '123456',
    'DB_DATABASE'        => 'demo',
    'DB_CHARSET'         => 'utf8',
    'DB_CONN_PERSISTENT' => FALSE,
    'DB_TIMEOUT'         => 15
);

// Set cookie configurations
$cookie_config = array(
    'algorithm'            => 'AES-128-CBC',
    'iv'                   => '1234567890123456',
    'salt'                 => 'badbadguy',
    'default_expire'       => 86000,
    'hash'                 => 'sha1',
    'high_confidentiality' => TRUE,
    'enable_ssl'           => FALSE,
);


/*** You can ignore below setting ***/

/**********************************
 * WowFES internal configurations
 **********************************/
// WowFES javascripts path
define('__js' , __web . '/js');

// WowFES css styles path
define('__css', __web . '/css');

// WowFES images path
define('__img', __web . '/img');

// Initial environment mode
require_once(__web . "/config/environments/$application_mode.php");

// Initial registry class
require_once(__web . '/config/' . 'registry.class.php');

// Initial routes class
require_once(__web . '/config/' . 'routes.class.php');

// Initial view class
require_once(__web . '/config/' . 'view.class.php');

// Initial base_controller class
require_once(__web . '/app/controllers/' . 'base_controller.class.php');

// Auto load models / helpers / vendor classes
function __autoload($class_name) {
    $filename = $class_name . '.class.php';
    $walk_path = array('/app/models/', '/app/helpers/', '/vendor/');
    foreach($walk_path as $path) {
        $file = __web . $path . $filename;
        if (file_exists($file)) {
            include_once($file);
            return TRUE;
        }
    }
    return FALSE;
}

// New registry object
$registry = new registry;

// Set default language
$registry->lang = $default_lang;

// Set database instance
$registry->db = WowPDOManager::getInstance($db_config);

/**
 * Example: Query key from database
 */
//$table = "key";
//$site_key = WowPDOManager::select($table));

// Registry cookie class
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID >= 50300) {
    // if php version >= 5.3.0
    $registry->cookie = new WowSecCookie2($site_key, $cookie_config);
}
else {
    $registry->cookie = new WowSecCookie($site_key, $cookie_config);
}

// Registry filter class
$registry->filter = new WowSecFilter();

// Registry cache class
if ($cache_mode === 'apc') {
    $registry->cache = new WowApcCache();
}
else if ($cache_mode === 'wincache') {
    $registry->cache = new WowWinCache();
}
else if ($cache_mode === 'memcache') {
    $registry->cache = new WowMemCache();
}
else if ($cache_mode === 'memcached') {
    $registry->cache = new WowMemCached();
}

// Registry random class
$registry->random = new WowRandom();

// Generator random number for url anticache
$registry->anticache = WowRandom::generator('numeric', 10);

// Registry form helpers
$registry->form = new form_helpers($registry);
// Registry url helpers
$registry->url = new url_helpers($registry);
// Registry js helpers
$registry->js = new js_helpers($registry);
// Registry css helpers
$registry->css = new css_helpers($registry);
// Registry img helpers
$registry->img = new img_helpers($registry);
// Registry table helpers
$registry->table = new table_helpers($registry);
?>
