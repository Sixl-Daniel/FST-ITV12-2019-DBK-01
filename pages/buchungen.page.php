<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

$db = new Database();

$bookingsModel = new ModelBuchung($db);
$bookings = $bookingsModel->getAll();
?>

<h2 class="page-title">Kursbuchungen</h2>

<section class="section section--output">
    <div id="list-bookings" class="list-cards list-cards--bookings">

        <?php
            foreach ($bookings as $b) :
            $wordingEvenings = $b->dauer > 1 ? "Abende" : "Abend";
        ?>
            <div class="card-wrapper" id="booking-id-<?=Helper::escape($b->id)?>">
                <div class="card">
                    <div class="card-content">
                        <p class="card-title">
                            <i class="medium material-icons">book</i>
                            <?=Helper::escape($b->name)?>, <?=Helper::escape($b->vorname)?> | <?=Helper::escape($b->kurs)?>
                        </p>
                        <table class="responsive-table striped">
                            <thead>
                                <tr>
                                    <th>Buchungs-Id</th>
                                    <th>Kurs-Id</th>
                                    <th>Teilnehmer-Id</th>
                                    <th>Ort</th>
                                    <th>Dauer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="booking-id"><?=Helper::escape($b->id)?></td>
                                    <td><?=Helper::escape($b->kursnr)?></td>
                                    <td><?=Helper::escape($b->teilnnr)?></td>
                                    <td><?=Helper::escape($b->schule)?>, <?=Helper::escape($b->ort)?></td>
                                    <td><?=Helper::escape($b->dauer)?> <?=$wordingEvenings?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if($isAdmin): ?>
                        <div class="card-action">
                            <button data-booking="<?=Helper::escape($b->id)?>" class="delete-booking red darken-2 waves-effect waves-light btn btn-small">Teilnehmer abmelden</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>