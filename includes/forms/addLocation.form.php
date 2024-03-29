<?php if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt."); ?>
<section class="row section section-box">

    <h3 class="heading-section">Neue Location anlegen</h3>

    <form id="add-location">

        <div class="input-field col s12 m6">
            <input placeholder="Stadt" id="city" name="city" type="text" class="validate" required>
            <label for="city">Stadt</label>
        </div>

        <div class="input-field col s12 m6">
            <input placeholder="Schule" id="school" name="school" type="text" class="validate" required>
            <label for="school">Schule</label>
        </div>

        <div class="input-field col s12">
            <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Ort hinzufügen</button>
        </div>

    </form>

</section>