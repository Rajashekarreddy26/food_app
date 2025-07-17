<?php
/**
 * Invoice tracking
 * Bank guarantees
 */
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
    <div id='bg-body'>
        <?= view('invoice_tracking/bank_guarantee/bank_guarantees_body') ?>
    </div>
<?= $this->endSection() ?>