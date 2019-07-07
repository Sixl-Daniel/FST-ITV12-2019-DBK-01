<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

$db = new Database();

$teilnehmerModel = new ModelTeilnehmer($db);
$teilnehmer = $teilnehmerModel->getAll();
?>

<h2 class="page-title">Teil&shy;nehmer</h2>

<section class="section section--output">
    <div id="list-participants" class="list-cards list-cards--participants">

        <?php
            foreach ($teilnehmer as $t) :
                $hasCourses = $t->anzahl_kurse > 0 ? true : false;
                $wordingCourses = $t->anzahl_kurse > 1 ? "Kurse" : "Kurs";
        ?>
            <div class="card-wrapper" id="teilnehmer-id-<?=Helper::escape($t->teilnnr)?>">
                <div class="card">
                    <div class="card-content">
                        <p class="card-title"><i class="medium material-icons">account_box</i> <?=Helper::escape($t->name)?>, <?=Helper::escape($t->vorname)?></p>
                        <table class="responsive-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Straße</th>
                                    <th>Wohnort</th>
                                    <th>Anzahl Kurse</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=Helper::escape($t->teilnnr)?></td>
                                    <td><?=Helper::escape($t->strassenname)?> <?=Helper::escape($t->hausnummer)?></td>
                                    <td><?=Helper::escape($t->postleitzahl)?> <?=Helper::escape($t->ort)?></td>
                                    <?php if($hasCourses): ?>
                                        <td><?=Helper::escape($t->anzahl_kurse)?></td>
                                    <?php else : ?>
                                        <td><b class="teal-text">keine Buchungen</b></td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if($hasCourses || $hasRightsUpdate) : ?>
                        <div class="card-action">
                            <?php if($hasCourses) : ?>
                            <button data-participant="<?=Helper::escape($t->teilnnr)?>" class="show-courses waves-effect waves-light btn btn-small"><i class="material-icons right">visibility</i>Gebuchte Kurse</button>
                            <?php endif; ?>
                            <?php if($hasRightsDelete) : ?>
                            <button data-participant="<?=Helper::escape($t->teilnnr)?>" class="delete-participant red darken-2 waves-effect waves-light btn btn-small"><i class="material-icons right">delete</i>Löschen</button>
                            <?php endif; ?>
                            <?php if($hasRightsUpdate): ?>
                                <a href="/edit?object=participant&id=<?=Helper::escape($t->teilnnr)?>" class="edit-course blue darken-2 waves-effect waves-light btn btn-small"><i class="material-icons right">create</i>Bearbeiten</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>