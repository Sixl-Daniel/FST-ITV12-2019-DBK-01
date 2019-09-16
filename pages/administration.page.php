<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");
echo '<h2 class="page-title">Verwaltung</h2>';
if(!$hasRightsCreate) {
?>
    <section class="row section section-box section-box--administration-guest">
        <p><b>Hinweis:</b><br>Sie sind als Gast im System eingeloggt. Die Verwaltung ist Ihnen daher nicht zugänglich. Bitte nehmen Sie mit dem Administrator Kontakt auf, um sich als Autor, Editor oder Administrator eintragen zu lassen.</p>
    </section>
<?php
} else {
    $db = new Database();

    $kursModel = new ModelKurse($db);
    $teilnehmerModel = new ModelTeilnehmer($db);
    $locationModel = new ModelOrt($db);

    $kurse = $kursModel->getAll();
    $teilnehmer = $teilnehmerModel->getAll();
    $locations = $locationModel->getAll();

    include ROOT . 'includes/forms/addParticipantToCourse.form.php';
    include ROOT . 'includes/forms/addCourse.form.php';
    include ROOT . 'includes/forms/addParticipant.form.php';
    include ROOT . 'includes/forms/addLocation.form.php';
};


