<?php
    if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");
    $token = (isset($_SESSION['token']) && !empty($_SESSION['token'])) ? $_SESSION['token'] : 'empty';
?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?=$token?>"/>
    <meta name="author" content="Daniel Sixl">
    <title>ITV12-DBK 2019 / Sixl</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"
          media="screen, projection"/>
    <link type="text/css" rel="stylesheet" href="/assets/css/main.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>
<body class="page-<?=$activePage?>">

<nav class="nav-main">
    <div class="container">
        <div class="nav-wrapper">
            <a href="/" class="brand-logo">ITV12-DBK</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <?php include ROOT . 'includes/main-nav.php' ?>
            </ul>
            <a href="#" data-target="mobile-nav" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
        </div>
    </div>
</nav>

<ul class="sidenav" id="mobile-nav">
    <?php include ROOT . 'includes/main-nav.php' ?>
</ul>