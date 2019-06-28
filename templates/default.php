<?php
if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");
require_once ROOT . 'includes/doc-top.php'
?>

<main class="container">
    <?php if (!empty($pageContent)) include $pageContent; ?>
</main>

<?php include ROOT . 'includes/doc-bottom.php' ?>
