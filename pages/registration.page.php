<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");
if($action=='register_new_user' && !empty($parameter) &&!empty($_GET['doi_token'])):
    $db = new Database();
    $user = new ModelUser($db);
    $userAccountActivated = $user->isActivated($parameter);
    $activationSuccess = false;
    if(!$userAccountActivated) {
        if($user->activate($parameter,$_GET['doi_token'])) $activationSuccess = true;
    }
    $message =
        $userAccountActivated ? "Ihr Benutzeraccount wurde bereits aktiviert. Sie können sich mit Ihren Nutzerdaten einloggen." :
            ($activationSuccess  ? "Ihr Account wurde erfolgreich aktiviert. Sie können sich ab jetzt mit Ihren Nutzerdaten einloggen." : "Ihr Aktivierungslink ist nicht gültig. Bitte registrieren Sie sich erneut.");

?>
    <h2 class="page-title">Bestätigung Ihrer Registrierung</h2>

    <section class="row section section-box section--registration">
        <p><?=$message?></p>
    </section>

<?php else: ?>
    <h2 class="page-title">Registrierung</h2>
    <section class="row section section-box section--registration">
        <form id="registration-form" name="registration" action="" method="post" class="col s12">

            <div class="row">

                <div class="input-field col s12 m2">
                    <select id="salutation" name="salutation" class="validate" required>
                        <option value="Frau" selected>Frau</option>
                        <option value="Herr">Herr</option>
                    </select>
                    <!--<label for="salutation">Anrede</label>-->
                </div>

                <div class="input-field col s12 m5">
                    <input id="firstname" name="firstname" type="text" class="validate" required>
                    <label for="firstname">Vorname</label>
                </div>

                <div class="input-field col s12 m5">
                    <input id="lastname" name="lastname" type="text" class="validate" required>
                    <label for="lastname">Nachname</label>
                </div>

            </div>

            <div class="row">

                <div class="input-field col s12 m9">
                    <input id="street" name="street" type="text" class="validate" required>
                    <label for="street">Straße</label>
                </div>

                <div class="input-field col s12 m3">
                    <input id="housenumber" name="housenumber" type="text" class="validate" required>
                    <label for="housenumber">Hausnummer</label>
                </div>

            </div>

            <div class="row">

                <div class="input-field col s12 m3">
                    <input id="zip" name="zip" type="text" class="validate" pattern="[0-9]{5}" required>
                    <label for="zip">Postleitzahl</label>
                    <span class="helper-text" data-error="Keine gültige Postleitzahl."></span>
                </div>

                <div class="input-field col s12 m9">
                    <input id="city" name="city" type="text" class="validate" required>
                    <label for="city">Wohnort</label>
                </div>

            </div>

            <div class="row">

                <div class="input-field col s12 m6">
                    <input id="username" name="username" type="text" class="validate" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{5,20}$" required>
                    <label for="username">Benutzername</label>
                    <span class="helper-text" data-error="6-20 Zeichen, nur Buchstaben, Zahlen, Binde- und Unterstriche."></span>
                </div>

                <div class="input-field col s12 m6">
                    <input id="email" name="email" type="email" class="validate" required>
                    <label for="email">E-Mail</label>
                    <span class="helper-text" data-error="Kein gültiges E-Mail-Format."></span>
                </div>

            </div>

            <div class="row">

                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required autocomplete="on">
                    <label for="password">Passwort</label>
                    <span class="helper-text" data-error="Mind. 8 Zeichen, eine Zahl, ein Klein- und ein Großbuchstabe."></span>
                </div>

            </div>

            <div class="row">

                <div class="input-field col s12 right-align">
                    <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">person_add</i>Registrieren</button>
                </div>

            </div>

        </form>
    </section>
<?php endif; ?>
