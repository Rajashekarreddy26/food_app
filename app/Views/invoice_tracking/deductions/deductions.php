<?php
/**
 * Deductions Main Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div id="deductions_body">
    <?= view('invoice_tracking/deductions/deductions_body'); ?>
</div>            	    
<?= $this->endSection() ?>