<?php if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt."); ?>

<?php if($loggedIn) : ?>
<h2 class="page-title">Account <?=Helper::escape($_SESSION['login']['first_name'])?> <?=Helper::escape($_SESSION['login']['last_name'])?></h2>
            <section class="section section-box">
                <p class="flow-text">Guten Tag <?=Helper::escape($_SESSION['login']['salutation'])?> <?=Helper::escape($_SESSION['login']['last_name'])?></p>
                <?php if($isAdmin) : ?>
                <p class="red-text text-darken-2 bold">Sie sind mit Administrations&shy;rechten eingeloggt.</p>
                <?php endif; ?>
                <?php if(!$isAdmin) : ?>
                    <p class="bold">Sie sind ohne Administrations&shy;rechte als „<?=Helper::escape($_SESSION['login']['role'])?>“ eingeloggt.</p>
                <?php endif; ?>
                <p><a href="/?logout=1" class="waves-effect waves-light btn btn--end"><i class="material-icons right">exit_to_app</i>Abmelden</a></p>
            </section>
            <section class="section section-box">
                <div class="row">
                    <div class="col s12 xl4">
                        <ul class="collection with-header">
                            <li class="collection-header"><h5>Account</h5></li>
                            <li class="collection-item">Anrede:<br><b><?=Helper::escape($_SESSION['login']['salutation'])?></b></li>
                            <li class="collection-item">Nachname:<br><b><?=Helper::escape($_SESSION['login']['last_name'])?></b></li>
                            <li class="collection-item">Vorname:<br><b><?=Helper::escape($_SESSION['login']['first_name'])?></b></li>
                            <li class="collection-item">Benutzername:<br><b><?=Helper::escape($_SESSION['login']['user_name'])?></b></li>
                            <li class="collection-item">E-Mail:<br><b><?=Helper::escape($_SESSION['login']['email'])?></b></li>
                            <li class="collection-item">Rolle:<br><b><?=Helper::escape($_SESSION['login']['role'])?></b></li>
                        </ul>
                    </div>
                    <div class="col s12 xl4">
                        <ul class="collection with-header">
                            <li class="collection-header"><h5>Adressdaten</h5></li>
                            <li class="collection-item">Straße:<br><b><?=Helper::escape($_SESSION['login']['street'])?></b></li>
                            <li class="collection-item">Hausnummer:<br><b><?=Helper::escape($_SESSION['login']['housenumber'])?></b></li>
                            <li class="collection-item">Postleitzahl:<br><b><?=Helper::escape($_SESSION['login']['zip'])?></b></li>
                            <li class="collection-item">Ort:<br><b><?=Helper::escape($_SESSION['login']['city'])?></b></li>
                        </ul>
                    </div>
                    <div class="col s12 xl4">
                        <ul class="collection with-header">
                            <li class="collection-header"><h5>Log</h5></li>
                            <li class="collection-item">Registrierung:<br><b><?=Helper::escape($_SESSION['login']['user_created'])?></b></li>
                            <li class="collection-item">Letzte Änderung:<br><b><?=Helper::escape($_SESSION['login']['user_modified'])?></b></li>
                            <li class="collection-item">Anmeldung:<br><b>Sie sind seit <?=Helper::escape($_SESSION['login']['time'])?> im System angemeldet.</b></li>
                        </ul>
                    </div>
                </div>
            </section>
<?php endif; ?>

<?php if(!$loggedIn) : ?>
<h2 class="page-title">Login</h2>
<section class="row section section-box section--login">
    <form id="login-form" name="login" action="" method="post" class="col s12">
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="username" name="username" type="text" class="validate" value="">
                <label for="username">Benutzername</label>
            </div>
            <div class="input-field col s12 m6">
                <input id="password" name="password" type="password" class="validate" value="">
                <label for="password">Passwort</label>
            </div>
            <div class="input-field col s12 right-align">
                <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">person</i>Anmelden</button>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="input-field col s12 center-align">
                <a href="/registration" class="waves-effect waves-teal btn-flat"><i class="material-icons left">person_add</i>Noch kein Konto? Jetzt registrieren.</a>
            </div>
        </div>
    </form>
</section>
<?php endif; ?>

