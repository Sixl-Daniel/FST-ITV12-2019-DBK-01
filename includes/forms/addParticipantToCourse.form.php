<div class="row section section-box section-box--primary">

    <h3 class="heading-section">Neue Kursbuchung</h3>

    <form id="add-participant-to-course">

        <div class="input-field col s12 m6">
            <select name="course" class="validate" >
                <option value="" disabled selected>Kurs auswählen</option>
                <?php foreach ($kurse as $k) : ?>
                    <option value="<?= Helper::escape($k->kursnr) ?>"><?= Helper::escape($k->kurs) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Kurs</label>
        </div>

        <div class="input-field col s12 m6">
            <select name="participant" class="validate" >
                <option value="" disabled selected>Teilnehmer auswählen</option>
                <?php foreach ($teilnehmer as $t) : ?>
                    <option value="<?= Helper::escape($t->teilnnr) ?>"><?= Helper::escape($t->name) ?> <?= Helper::escape($t->vorname) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Teilnehmer</label>
        </div>

        <div class="input-field col s12">
            <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Teilnehmer zu Kurs hinzufügen</button>
        </div>

    </form>

</div>