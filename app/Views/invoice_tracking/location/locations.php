<?php
/**
 * Locations Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>	
<div id="locations_body">
    <?= view('invoice_tracking/location/locations_body'); ?>
</div>            
	    
<?= $this->endSection() ?>