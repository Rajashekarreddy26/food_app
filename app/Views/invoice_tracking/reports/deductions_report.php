<?php
/**
 * Deductions Report Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div id="deductions_report_body">
    <?= view('invoice_tracking/reports/deductions_report_body'); ?>
</div>            	    
<?= $this->endSection() ?>