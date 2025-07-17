<?php
/**
 * Locations Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div id="users_body">
    <?= view('user/users/users_body'); ?>
</div>
<?= $this->endSection() ?>