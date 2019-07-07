<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

$db = new Database();

$kursModel = new ModelKurse($db);
$kurse = $kursModel->getAll();
?>

<h2 class="page-title">Kurse</h2>

<section class="section section--output">
    <div id="list-courses" class="list-cards list-cards--courses">
        <?php
            foreach ($kurse as $k) :
            $hasParticipants = $k->teilnehmerzahl > 0 ? true : false;
            $wordingEvenings = $k->dauer > 1 ? "Abende" : "Abend";
        ?>
        <div class="card-wrapper" id="kurs-id-<?=Helper::escape($k->kursnr)?>">
            <div class="card">
                <div class="card-content">
                    <p class="card-title"><i class="medium material-icons">folder_open</i> <?=Helper::escape($k->kurs)?></p>
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th>Nummer</th>
                                <th>Dauer</th>
                                <th>Ort</th>
                                <th>Voraussetzungen</th>
                                <th>Teilnehmer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=Helper::escape($k->katalognummer)?></td>
                                <td><?=Helper::escape($k->dauer)?> <?=$wordingEvenings?></td>
                                <td><?=Helper::escape($k->schule)?>, <?=Helper::escape($k->ort)?></td>
                                <td><?=Helper::escape($k->voraussetzungen)?></td>
                                <?php if($hasParticipants): ?>
                                    <td><?=Helper::escape($k->teilnehmerzahl)?></td>
                                <?php else : ?>
                                    <td><b class="teal-text">keine Anmeldungen</b></td>
                                <?php endif; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php if($hasParticipants || $hasRightsUpdate) : ?>
                    <div class="card-action">
                        <?php if($hasParticipants) : ?>
                        <button data-course="<?=Helper::escape($k->kursnr)?>" class="show-participants waves-effect waves-light btn btn-small"><i class="material-icons right">visibility</i>Teilnehmerliste</button>
                        <?php endif; ?>
                        <?php if($hasRightsDelete) : ?>
                        <button data-course="<?=Helper::escape($k->kursnr)?>" class="delete-course red darken-2 waves-effect waves-light btn btn-small"><i class="material-icons right">delete</i>Löschen</button>
                        <?php endif; ?>
                        <?php if($hasRightsUpdate): ?>
                        <a href="/edit?object=course&id=<?=Helper::escape($k->kursnr)?>" class="edit-course blue darken-2 waves-effect waves-light btn btn-small"><i class="material-icons right">create</i>Bearbeiten</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>