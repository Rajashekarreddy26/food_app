<?php
/**
 * Payment Report Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div id="payment_reports_body">
    <?= view('invoice_tracking/reports/payment_report_body'); ?>
</div>            	    
<?= $this->endSection() ?>