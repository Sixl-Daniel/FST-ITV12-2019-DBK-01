<?php if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt."); ?>

<?php if($loggedIn) : ?>
<h2 class="page-title">Account <?=$_SESSION['login']['first_name']?> <?=$_SESSION['login']['last_name']?></h2>
<section class="section section--account">
    <div class="row">
        <div class="col s12 m6 l8">
            <p class="flow-text">Guten Tag <?=$_SESSION['login']['salutation']?> <?=$_SESSION['login']['last_name']?></p>
            <?php if($isAdmin) : ?>
            <p class="red-text text-darken-2 bold">Sie sind mit Administrationsrechten eingeloggt.</p>
            <?php endif; ?>
            <?php if(!$isAdmin) : ?>
                <p class="bold">Sie sind ohne Administrationsrechte eingeloggt.</p>
            <?php endif; ?>
            <p>Sie sind seit <?=$_SESSION['login']['time']?> im System angemeldet.</p>
            <hr class="separator separator--invisible">
            <p><a href="/?logout=1" class="waves-effect waves-light btn"><i class="material-icons right">exit_to_app</i>Abmelden</a></p>
        </div>
        <div class="col s12 m6 l4">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Ihre Daten</h5></li>
                <li class="collection-item">Anrede: <b><?=$_SESSION['login']['salutation']?></b></li>
                <li class="collection-item">Nachname: <b><?=$_SESSION['login']['last_name']?></b></li>
                <li class="collection-item">Vorname: <b><?=$_SESSION['login']['first_name']?></b></li>
                <li class="collection-item">Benutzername: <b><?=$_SESSION['login']['user_name']?></b></li>
                <li class="collection-item">E-Mail: <b><?=$_SESSION['login']['email']?></b></li>
                <li class="collection-item">Rolle: <b><?=$_SESSION['login']['role']?></b></li>
                <li class="collection-item">Registrierung: <b><?=$_SESSION['login']['user_created']?></b></li>
                <li class="collection-item">Letzte Änderung: <b><?=$_SESSION['login']['user_modified']?></b></li>
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
            <div class="input-field col s12">
                <button type="submit" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Anmelden</button>
            </div>
        </div>
    </form>
</section>
<?php endif; ?>

