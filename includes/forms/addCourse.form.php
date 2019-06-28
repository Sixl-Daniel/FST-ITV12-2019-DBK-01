<?php $eg = 'Bsp.:'?>
<div class="row section section-box">

    <h3 class="heading-section">Neuen Kurs anlegen</h3>

    <form id="add-course">

        <div class="input-field col s12 m2">
            <input placeholder="<?=$eg?> 20.1" id="course-id" name="id" type="text" class="validate" pattern="[0-9]{1,3}.?[0-9]{0,3}[a-z]?" required title="Bitte geben Sie die Kursnummer an.">
            <label for="course-id">Kursnummer</label>
        </div>

        <div class="input-field col s12 m7 l8">
            <input placeholder="<?=$eg?> Excel für Fortgeschrittene" id="title" name="title" type="text" class="validate" required title="Bitte geben Sie die Bezeichnung des neuen Kurses an.">
            <label for="title">Bezeichnung</label>
        </div>

        <div class="input-field col s12 m3 l2">
            <input placeholder="<?=$eg?> 4" id="duration" name="duration" type="text" class="validate" pattern="[0-9]{1,2}" required title="Bitte geben Sie an, wie viele Abende der Kurs umfassen wird.">
            <label for="duration">Dauer (Abende)</label>
        </div>

        <div class="input-field col s12 m6">
            <input placeholder="<?=$eg?> Grundwissen in JavaScript" id="prerequisites" name="prerequisites" type="text" class="validate" required title="Bitte geben Sie die Voraussetzungen für den neuen Kurs an.">
            <label for="prerequisites">Voraussetzungen</label>
        </div>

        <div class="input-field col s12 m6">
            <select id="location" name="location" class="validate" title="Bitte geben Sie an, wo der Kurs stattfinden wird.">
                    <option value="" disabled selected>Ort auswählen</option>
                <?php foreach ($locations as $l) : ?>
                    <option value="<?= Helper::escape($l->ortnr) ?>"><?=Helper::escape($l->ort)?>, <?=Helper::escape($l->schule)?></option>
                <?php endforeach; ?>
            </select>
            <label for="location">Ort</label>
        </div>

        <div class="input-field col s12">
            <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Kurs hinzufügen</button>
        </div>

    </form>

</div>