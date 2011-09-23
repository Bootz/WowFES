<?php
/**********************************
 * Custome configurations
 **********************************/
// This is for CSS bugs of IE 6/7/8/9,
// http://robertnyman.com/2010/02/18/css-files-downloaded-twice-in-internet-explorer-with-protocol-relative-urls/
define('__fqdn', 'www.yourdomain.com');

// You can ignore http/https and domain
//define('__site', '/wowfes');
define('__site', '');

// Set default timezone
date_default_timezone_set("Asia/Taipei");

// Set application mode, support 'development' and 'production'
$application_mode = 'development';

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
    'DB_PORT'            => '3306',
    'DB_USER'            => 'root',
    'DB_PASSWORD'        => 'password',
    'DB_DATABASE'        => 'mysql',
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
require_once(__app . "/config/environment/$application_mode.php");

// Initial registry class
require_once(__app . '/config/registry.class.php');

// Initial routes class
require_once(__app . '/config/routes.class.php');

// Initial view class
require_once(__app . '/config/view.class.php');

// Initial base_controller class
require_once(__app . '/app/controllers/base_controller.class.php');

// Auto load vendor classes
function __autoload($class_name) {
    $filename = $class_name . '.class.php';
    $walk_path = array('/app/models/', '/app/helpers/', '/vendor/', '/config/database/orm/');
    foreach($walk_path as $path) {
        $file = __app . $path . $filename;
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
// Method 1: WowPDOManager
//$registry->db = WowPDOManager::getInstance($db_config);
// Method 2: idiorm.php
$pdo = new PDO($db_config['DB_DRIVER'] . ":host=" . $db_config['DB_HOST'] . ";port=" . $db_config['DB_PORT'] . ";dbname=" . $db_config['DB_DATABASE'], $db_config['DB_USER'], $db_config['DB_PASSWORD'],
    array(PDO::ATTR_PERSISTENT => $db_config['DB_CONN_PERSISTENT'],
          PDO::ATTR_TIMEOUT => $db_config['DB_TIMEOUT'],
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
if ($db_config['DB_DRIVER'] === 'mysql') {
    $pdo->setAttribute(1002, "SET NAMES '" . $db_config['DB_CHARSET'] . "'");
}
ORM::set_db($pdo);
//$registry->db = ORM::for_table(NULL);


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
