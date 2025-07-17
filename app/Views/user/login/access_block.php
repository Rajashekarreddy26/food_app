<?php
/**
 * Page Access Denied
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
<div class="alert alert-danger m-0">
	<div>
		<strong><i class="bi bi-exclamation-square"></i>&nbsp;Access denied!</strong>
		This page access is denied, please contact administrator.
	</div>
</div>
<?= $this->endSection() ?>