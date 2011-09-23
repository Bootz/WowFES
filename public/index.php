<?php
/**********************************
 * WowFES internal configurations
 **********************************/
// WowFES web path
define('__web', __DIR__);
define('__app', __DIR__ . '/..');

/**********************************
 * WowFES initial
 **********************************/
// Initial boot script
require_once(__app . '/config/boot.php');

// Registry routes script
$registry->routes = new routes($registry);

// Initial controller path
$registry->routes->init(__app . '/app/controllers');

// Registry view
$registry->view = new view($registry);

// Initial routes script
$registry->routes->run();
?>
