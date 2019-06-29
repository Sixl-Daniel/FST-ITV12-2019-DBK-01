<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");
?>

<h1 class="page-title">Übung Daten&shy;banken<br><smaller>Anbindung mit PHP</smaller></h1>

<section class="section section--intro">
    <div class="row">
        <div class="col s12 m4 push-m1 l5 push-l1">
            <p class="flow-text lead">
                <b>Übungs&shy;seite zur An&shy;bind&shy;ung einer MySQL-Datenbank in PHP.</b>
            </p>
            <img class="materialboxed" src="/assets/img/webopt/project-sixl-mockup-webopt.jpg">
            <ul class="collection with-header">
                <li class="collection-header"><h4>Features</h4></li>
                <li class="collection-item">„Single entry point“ und primitives Routing über die <code>index.php</code></li>
                <li class="collection-item">Einfache PDO-Wrapper-Klasse</li>
                <li class="collection-item">Modellklassen für die Entitäten der Datenbank</li>
                <li class="collection-item">CRUD via AJAX (ohne Update)</li>
                <li class="collection-item">Einfache Authen&shy;tifizierung und Rollen&shy;verwaltung über Sessions</li>
                <li class="collection-item">Responsives Design</li>
            </ul>
        </div>
        <div class="col s12 m5 push-m2 l4 push-l2">
            <p class="boxed">Eine Liste aller Kurse aus der Daten&shy;bank:<br>
                <a href="/kurse" class="waves-effect waves-light btn-small"><i class="material-icons right">arrow_forward</i>Kurse</a>
            </p>
            <p class="boxed">Eine Liste aller Teilnehmer aus der Daten&shy;bank:<br>
                <a href="/teilnehmer" class="waves-effect waves-light btn-small"><i class="material-icons right">arrow_forward</i>Teilnehmer</a>
            </p>
            <p class="boxed">Eine Liste aller Orte aus der Daten&shy;bank:<br>
                <a href="/orte" class="waves-effect waves-light btn-small"><i class="material-icons right">arrow_forward</i>Orte</a>
            </p>
            <p class="boxed">Eine Liste aller Buchungen aus der Daten&shy;bank:<br>
                <a href="/buchungen" class="waves-effect waves-light btn-small"><i class="material-icons right">arrow_forward</i>Buchungen</a>
            </p>
            <?php if($loggedIn) : ?>
            <p class="boxed">Neue Buchungen, Kurse, Orte und Benutzer anlegen:<br>
                <a href="/administration" class="waves-effect waves-light btn-small"><i class="material-icons right">arrow_forward</i>Verwaltung</a>
            </p>
            <?php endif; ?>
        </div>
    </div>
</section>