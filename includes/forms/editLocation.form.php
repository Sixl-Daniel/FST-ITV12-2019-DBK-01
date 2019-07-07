<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

$db = new Database();

$locationsModel = new ModelOrt($db);
$location = $locationsModel->get($objectId);
?>
<section class="row section section-box">
    <form id="edit-location" data-location="<?=$objectId?>">
        <div class="input-field col s12 m6">
            <input placeholder="Stadt" id="city" name="city" type="text" class="validate" required value="<?=Helper::escape($location->ort)?>">
            <label for="city">Stadt</label>
        </div>
        <div class="input-field col s12 m6">
            <input placeholder="Schule" id="school" name="school" type="text" class="validate" required value="<?=Helper::escape($location->schule)?>">
            <label for="school">Schule</label>
        </div>
        <div class="input-field col s12">
            <a href="/orte" class="waves-effect waves-light btn grey"><i class="material-icons left">undo</i>Abbrechen</a>
            <button type="submit" class="waves-effect waves-light btn blue darken-2"><i class="material-icons right">save</i>Ort aktualisieren</button>
        </div>
    </form>
</section>