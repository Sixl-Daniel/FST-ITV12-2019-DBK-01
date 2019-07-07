<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

$db = new Database();

$participantModel = new ModelTeilnehmer($db);
$participant = $participantModel->get($objectId);
?>
<section class="row section section-box">
    <form id="edit-participant" data-participant="<?=$objectId?>">
        <div class="input-field col s12 m6">
            <input placeholder="Nachname" id="name" name="name" type="text" class="validate" required value="<?=Helper::escape($participant->name)?>">
            <label for="name">Nachname</label>
        </div>
        <div class="input-field col s12 m6">
            <input placeholder="Vorname" id="firstname" name="firstname" type="text" class="validate" required value="<?=Helper::escape($participant->vorname)?>">
            <label for="firstname">Vorname</label>
        </div>
        <div class="input-field col s12 m9">
            <input placeholder="Straße" id="street" name="street" type="text" class="validate" required value="<?=Helper::escape($participant->strassenname)?>">
            <label for="street">Straße</label>
        </div>
        <div class="input-field col s12 m3">
            <input placeholder="Hausnummer" id="housenumber" name="housenumber" type="text" class="validate" required value="<?=Helper::escape($participant->hausnummer)?>">
            <label for="housenumber">Hausnummer</label>
        </div>
        <div class="input-field col s12 m3">
            <input placeholder="Postleitzahl" id="zip" name="zip" type="text" class="validate" pattern="[0-9]{5}" required value="<?=Helper::escape($participant->postleitzahl)?>">
            <label for="zip">Postleitzahl</label>
        </div>
        <div class="input-field col s12 m9">
            <input placeholder="Wohnort" id="city" name="city" type="text" class="validate" required value="<?=Helper::escape($participant->ort)?>">
            <label for="city">Wohnort</label>
        </div>
        <div class="input-field col s12">
            <a href="/teilnehmer" class="waves-effect waves-light btn grey"><i class="material-icons left">undo</i>Abbrechen</a>
            <button type="submit" class="waves-effect waves-light btn blue darken-2"><i class="material-icons right">save</i>Teilnehmer aktualisieren</button>
        </div>
    </form>
</section>