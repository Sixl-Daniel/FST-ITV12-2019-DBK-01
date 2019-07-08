<?php
define("ROOT", __DIR__ . "/");
require_once ROOT . 'includes/_init.php';

$url = isset($_SERVER['REDIRECT_URL']) ?  $_SERVER['REDIRECT_URL'] : '/';
$request = explode("/", $url);

$page = empty($request[1]) ? "index" :  $request[1];
$action = empty($request[2]) ? "standard" :  $request[2];
$parameter = empty($request[3]) ? "none" :  $request[3];

// reroute pages that need special permissions
if($page == 'administration' && !$loggedIn) header("Location: /");
if($page == 'edit' && !$hasRightsUpdate) header("Location: /");

$filePage = 'pages/'.$page.'.page.php';

$pageContent = file_exists($filePage) ? $filePage : 'pages/404.page.php';
$activePage = file_exists($filePage) ? $page : '404';

require_once ROOT . 'templates/default.php';