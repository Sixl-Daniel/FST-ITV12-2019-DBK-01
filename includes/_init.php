<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

error_reporting(E_ALL);

setlocale(LC_ALL, "de_DE");
date_default_timezone_set('Europe/Berlin');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: /", true, 301);
    exit(0);
}

$loggedIn = isset($_SESSION['login']) ? true : false;

$isAdmin = ($loggedIn && $_SESSION['login']['role'] == 'Administrator') ? true : false;
$isEditor = ($loggedIn && $_SESSION['login']['role'] == 'Editor') ? true : false;
$isAuthor = ($loggedIn && $_SESSION['login']['role'] == 'Author') ? true : false;

$hasRightsUpdate = $isAdmin || $isEditor ? true : false;
$hasRightsDelete = $isAdmin ? true : false;

if(!isset($_SESSION['token']) || empty($_SESSION['token'])) $_SESSION['token'] = bin2hex(random_bytes(64));

setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'deu_deu', 'de', 'ge');

include ROOT . 'vendor/autoload.php';

spl_autoload_register(function ($class) {
    include ROOT . 'classes/' . $class . '.class.php';
});