<?php
/**
 * File Types Main Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div id="file_types_body">
    <?= view('invoice_tracking/file_types/file_types_body'); ?>
</div>
<?= $this->endSection() ?>