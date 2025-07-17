<?php
/**
 * Modules Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div id="modules_body">
	<?= view('settings/modules/modules_body') ?>
</div>
<?= $this->endSection() ?>