<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");
if(!$hasRightsCreate) die();

$db = new Database();

$kursModel = new ModelKurse($db);
$teilnehmerModel = new ModelTeilnehmer($db);
$locationModel = new ModelOrt($db);

$kurse = $kursModel->getAll();
$teilnehmer = $teilnehmerModel->getAll();
$locations = $locationModel->getAll();

echo '<h2 class="page-title">Verwaltung</h2>';

include ROOT . 'includes/forms/addParticipantToCourse.form.php';
include ROOT . 'includes/forms/addCourse.form.php';
include ROOT . 'includes/forms/addParticipant.form.php';
include ROOT . 'includes/forms/addLocation.form.php';
