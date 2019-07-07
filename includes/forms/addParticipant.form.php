<?php if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt."); ?>
<section class="row section section-box">

    <h3 class="heading-section">Neuen Teilnehmer anlegen</h3>

    <form id="add-participant">

        <div class="input-field col s12 m6">
            <input placeholder="Nachname" id="name" name="name" type="text" class="validate" required>
            <label for="name">Nachname</label>
        </div>

        <div class="input-field col s12 m6">
            <input placeholder="Vorname" id="firstname" name="firstname" type="text" class="validate" required>
            <label for="firstname">Vorname</label>
        </div>

        <div class="input-field col s12 m9">
            <input placeholder="Straße" id="street" name="street" type="text" class="validate" required>
            <label for="street">Straße</label>
        </div>

        <div class="input-field col s12 m3">
            <input placeholder="Hausnummer" id="housenumber" name="housenumber" type="text" class="validate" required>
            <label for="housenumber">Hausnummer</label>
        </div>

        <div class="input-field col s12 m3">
            <input placeholder="Postleitzahl" id="zip" name="zip" type="text" class="validate" pattern="[0-9]{5}" required>
            <label for="zip">Postleitzahl</label>
        </div>

        <div class="input-field col s12 m9">
            <input placeholder="Wohnort" id="city" name="city" type="text" class="validate" required>
            <label for="city">Wohnort</label>
        </div>

        <div class="input-field col s12">
            <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Teilnehmer hinzufügen</button>
        </div>

    </form>

</section>