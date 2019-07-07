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
                        <p class="card-title"><i class="medium material-icons">location_on</i> <span class="data-school"><?=Helper::escape($l->schule)?></span></p>
                        <table class="responsive-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Ort</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="data-id"><?=Helper::escape($l->ortnr)?></span></td>
                                    <td><span class="data-city"><?=Helper::escape($l->ort)?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if($hasRightsUpdate) : ?>
                        <div class="card-action">
                            <?php if($hasRightsDelete) : ?>
                            <button data-location="<?=Helper::escape($l->ortnr)?>" class="delete-location red darken-2 waves-effect waves-light btn btn-small"><i class="material-icons right">delete</i>Löschen</button>
                            <?php endif; ?>
                            <a href="/edit?object=location&id=<?=Helper::escape($l->ortnr)?>" class="edit-location blue darken-2 waves-effect waves-light btn btn-small"><i class="material-icons right">create</i>Bearbeiten</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</section>