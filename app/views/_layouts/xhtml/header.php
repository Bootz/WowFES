<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php @session_start(); ?>
<?php include_once(__DIR__ . '/../meta.php'); ?>

<?php include_once(__css . '/bundles/default.php'); ?>
<title><?php echo $title ?></title>
</head>
<body>
<div id="wrap">
    <div id="top">
        <h2><a href="/index" title="Back to main page">瘋料理 - CrazyCook</a></h2>
        <div id="menu">
        <ul>
            <li><a href="/index" <?php if($_SERVER['REQUEST_URI'] === '/index') echo 'class="current"' ?>>Home</a></li>
            <li><a href="/search" <?php if($_SERVER['REQUEST_URI'] === '/search') echo 'class="current"' ?>>Search</a></li>
            <?php
            if (isset($_SESSION['username'])) {
            ?>
            <li><a href="/upload" <?php if($_SERVER['REQUEST_URI'] === '/upload') echo 'class="current"' ?>>Upload</a></li>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION['username'])) {
            ?>
            <li><a href="/logout" <?php if($_SERVER['REQUEST_URI'] === '/logout') echo 'class="current"' ?>>Logout</a></li>
            <?php
            } else {
            ?>
            <li><a href="/login" <?php if($_SERVER['REQUEST_URI'] === '/login' || $_SERVER['REQUEST_URI'] === '/register') echo 'class="current"' ?>>Login</a></li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>
<?php
if (isset($_SESSION['username'])) {
?>
<div id="showuser">
    <?php echo $welcome ?>, <?php echo $_SESSION['username']; ?>
</div>
<?php
}
?>
