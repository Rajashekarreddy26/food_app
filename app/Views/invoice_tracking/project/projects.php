<?php
/**
 * Invoice tracking
 * projects
 */
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div id="projects_body">
    <?= view('invoice_tracking/project/projects_body'); ?>
</div>            
        
<?= $this->endSection() ?>
