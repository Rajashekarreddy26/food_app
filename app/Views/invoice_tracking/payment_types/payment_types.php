<?php
/**
 * Payment Type Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>	
<div id="payment_types">
    <?= view('invoice_tracking/payment_types/payment_types_body'); ?>
</div>            
	    
<?= $this->endSection() ?>