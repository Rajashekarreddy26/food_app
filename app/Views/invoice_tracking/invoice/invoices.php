<?php
/**
 * Invoice tracking
 * Invoices
 */
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
    <div id='inv-body'>
        <?= view('invoice_tracking/invoice/invoices_body') ?>
    </div>
<?= $this->endSection() ?>