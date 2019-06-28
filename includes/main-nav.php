<?php if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt."); ?>

<li<?= Helper::menu($activePage,'index')?>>
    <a href="/" ><i class="material-icons">home</i></a>
</li>

<li<?= Helper::menu($activePage,'kurse')?>>
    <a href="/kurse" >Kurse</a>
</li>

<li<?= Helper::menu($activePage,'teilnehmer')?>>
    <a href="/teilnehmer" >Teilnehmer</a>
</li>

<li<?= Helper::menu($activePage,'orte')?>>
    <a href="/orte" >Orte</a>
</li>

<li<?= Helper::menu($activePage,'buchungen')?>>
    <a href="/buchungen" >Buchungen</a>
</li>

<?php if($loggedIn) : ?>
<li<?= Helper::menu($activePage,'administration')?>>
    <a href="/administration" >Verwaltung</a>
</li>
<?php endif; ?>

<?php if(!$loggedIn) : ?>
<li<?= Helper::menu($activePage,'login')?>>
    <a href="/login" >Login</a>
</li>
<?php endif; ?>

<?php if($loggedIn) : ?>
<li<?= Helper::menu($activePage,'login')?>>
    <a href="/login" ><i class="material-icons left">account_circle</i> <?=$_SESSION['login']['last_name']?></a>
</li>
<?php endif; ?>