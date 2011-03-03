<?php

/**********************************
 * Custome configurations
 **********************************/
// This is for CSS bugs of IE 6/7/8/9,
// http://robertnyman.com/2010/02/18/css-files-downloaded-twice-in-internet-explorer-with-protocol-relative-urls/
define('__fqdn', 'antbsd.twbbs.org');

// You can ignore http/https and domain
define('__site', '/~ant');


/*** You can ignore below setting ***/

/**********************************
 * WowFES internal configurations
 **********************************/
// WowFES web path
define('__web', __DIR__);

// WowFES javascripts path
define('__js' , __web . '/js');

// WowFES css styles path
define('__css', __web . '/css');

// WowFES images path
define('__img', __web . '/img');


/**********************************
 * WowFES initial
 **********************************/
// Initial boot script
require_once(__web . '/config/boot.php');

// Registry routes script
$registry->routes = new routes($registry);

// Initial controller path
$registry->routes->init(__web . '/app/controllers');

// Registry view
$registry->view = new view($registry);

// Initial routes script
$registry->routes->run();
?>
