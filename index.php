<?php
define("ROOT", __DIR__ . "/");
require_once ROOT . 'includes/_init.php';

$request = isset($_SERVER['REDIRECT_URL']) ?  $_SERVER['REDIRECT_URL'] : '/';

switch ($request) {

    case '/' :
        $activePage = 'index';
        $pageContent = 'pages/index.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '' :
        $activePage = 'index';
        $pageContent = 'pages/index.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/kurse' :
        $activePage = 'kurse';
        $pageContent = 'pages/kurse.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/teilnehmer' :
        $activePage = 'teilnehmer';
        $pageContent = 'pages/teilnehmer.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/orte' :
        $activePage = 'orte';
        $pageContent = 'pages/orte.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/buchungen' :
        $activePage = 'buchungen';
        $pageContent = 'pages/buchungen.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/administration' :
        if(!isset($_SESSION['login'])){
            header("Location: /");
        }
        $activePage = 'administration';
        $pageContent = 'pages/administration.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/login' :
        $activePage = 'login';
        $pageContent = 'pages/login.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/edit' :
        if(!$hasRightsUpdate){
            header("Location: /");
        }
        $activePage = 'edit';
        $pageContent = 'pages/edit.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    case '/legal' :
        $activePage = 'legal';
        $pageContent = 'pages/legal.page.php';
        require_once ROOT . 'templates/default.php';
        break;

    default :
        $activePage = '404';
        $pageContent = 'pages/404.page.php';
        require_once ROOT . 'templates/default.php';
        break;

}