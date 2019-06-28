<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

// error_reporting(E_ALL);

setlocale(LC_TIME, "de_DE");

$home_url = "https://project-sixl.de/";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: $home_url", true, 301);
    exit(0);
}

$loggedIn = isset($_SESSION['login']) ? true : false;
$isAdmin = ($loggedIn && $_SESSION['login']['role'] == 'Administrator') ? true : false;

if(!isset($_SESSION['token']) || empty($_SESSION['token'])) $_SESSION['token'] = bin2hex(random_bytes(64));

setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'deu_deu', 'de', 'ge');

include ROOT . 'vendor/autoload.php';

spl_autoload_register(function ($class) {
    include ROOT . 'classes/' . $class . '.class.php';
});