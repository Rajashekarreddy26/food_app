<?php
/**
 * Reports landing Page
 */ 
?>
<?= $this->extend('template/template_admin') ?>
<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-6">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item">
                    <a href="<?= WEBROOT ?>/reports/invoiceDeductions">Deductions Report</a>
                </li>
                <li class="list-group-item">
                    <a href="<?= WEBROOT ?>/reports/invoicePayments">Payments Report</a>
                </li>
            </ol>
        </div>
    </div>
<?= $this->endSection() ?>