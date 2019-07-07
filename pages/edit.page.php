<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

// check role
if(!$hasRightsUpdate) die("Fehlende Berechtigung.");

// check parameter provided
if(empty($_GET['object']) || empty($_GET['id'])) die("Fehlende Parameter.");

// check parameter object makes sense
$validObjects = ['course'=>'Kurs', 'participant'=>'Teilnehmer', 'location'=>'Ort', 'booking'=>'Buchung'];

if(!array_key_exists ($_GET['object'], $validObjects)) die("Ungültiges Objekt.");

$objectName = $validObjects[$_GET['object']];
$objectType = ucfirst($_GET['object']);
$objectId = $_GET['id'];

echo "<h2 class='page-title'>$objectName bearbeiten</h2>";

include ROOT . 'includes/forms/edit' . $objectType . '.form.php';