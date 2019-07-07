<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

$db = new Database();

$courseModel = new ModelKurse($db);
$course = $courseModel->get($objectId);

$locationModel = new ModelOrt($db);
$locations = $locationModel->getAll();
?>
<section class="row section section-box">
    <form id="edit-course" data-course="<?=$objectId?>">
        <div class="input-field col s12 m2">
            <input id="catalog-id" name="catalog-id" type="text" class="validate" pattern="[0-9]{1,3}.?[0-9]{0,3}[a-z]?" required title="Bitte geben Sie die Kursnummer an." value="<?=Helper::escape($course->katalognummer)?>">
            <label for="catalog-id">Nummer</label>
        </div>
        <div class="input-field col s12 m7 l8">
            <input id="title" name="title" type="text" class="validate" required title="Bitte geben Sie die Bezeichnung des neuen Kurses an." value="<?=Helper::escape($course->kurs)?>">
            <label for="title">Bezeichnung</label>
        </div>
        <div class="input-field col s12 m3 l2">
            <input id="duration" name="duration" type="text" class="validate" pattern="[0-9]{1,2}" required title="Bitte geben Sie an, wie viele Abende der Kurs umfassen wird." value="<?=Helper::escape($course->dauer)?>">
            <label for="duration">Dauer (Abende)</label>
        </div>
        <div class="input-field col s12">
            <input id="prerequisites" name="prerequisites" type="text" class="validate" required title="Bitte geben Sie die Voraussetzungen für den neuen Kurs an." value="<?=Helper::escape($course->voraussetzungen)?>">
            <label for="prerequisites">Voraussetzungen</label>
        </div>
        <div class="input-field col s12">
            <select id="location" name="location" class="validate" title="Bitte geben Sie an, wo der Kurs stattfinden wird.">
                <?php
                    foreach ($locations as $l) :
                    $selected = $course->ortnr == $l->ortnr ? ' selected' : '';
                ?>
                    <option value="<?= Helper::escape($l->ortnr) ?>"<?=$selected?>><?=Helper::escape($l->ort)?>, <?=Helper::escape($l->schule)?></option>
                <?php endforeach; ?>
            </select>
            <label for="location">Ort</label>
        </div>
        <div class="input-field col s12">
            <a href="/kurse" class="waves-effect waves-light btn grey"><i class="material-icons left">undo</i>Abbrechen</a>
            <button type="submit" class="waves-effect waves-light btn blue darken-2"><i class="material-icons right">save</i>Kurs aktualisieren</button>
        </div>
    </form>
</section>