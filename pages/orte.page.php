<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

$db = new Database();

$locationsModel = new ModelOrt($db);
$locations = $locationsModel->getAll();
?>

<h2 class="page-title">Orte</h2>

<section class="section section--output">
    <div id="list-locations" class="list-cards list-cards--locations">

        <?php foreach ($locations as $l) : ?>
            <div class="card-wrapper" id="teilnehmer-id-<?=Helper::escape($l->ortnr)?>">
                <div class="card">
                    <div class="card-content">
                        <p class="card-title"><i class="medium material-icons">location_on</i> <?=Helper::escape($l->schule)?></p>
                        <table class="responsive-table striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Ort</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=Helper::escape($l->ortnr)?></td>
                                    <td><?=Helper::escape($l->ort)?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if($isAdmin): ?>
                        <div class="card-action">
                            <button data-location="<?=Helper::escape($l->ortnr)?>" class="delete-location red darken-2 waves-effect waves-light btn btn-small">Löschen</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>