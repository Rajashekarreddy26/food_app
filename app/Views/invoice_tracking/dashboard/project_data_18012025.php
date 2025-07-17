<?php
/**
 * Invoice tracking
 * Dashboard - Project data
 */
// Crore 
$cr = 10000000;
// Project totals data preparation
$project_totals_data = array();
foreach($project_totals as $totals_row) {
    $project_totals_data[$totals_row['project_id']] = $totals_row;
}
?>
<div class="card">
    <div class="card-header">
        <div class="float-start"><h2 class="fs-5"><i class="bi bi-archive"></i>&nbsp;Projects Data</h2></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 p-1"><div class="bg-secondary bg-gradient text-white p-2 fs-8 fw-bold">Project</div></div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col p-1"><div class="bg-info bg-gradient text-white text-end p-2 fs-8 fw-bold">Contract Value (Cr.)</div></div>
                     <div class="col p-1"><div class="bg-success bg-gradient text-white text-end p-2 fs-8 fw-bold">Basic Amount (Cr.)</div></div>
                    <div class="col p-1"><div class="bg-danger bg-gradient text-white text-end p-2 fs-8 fw-bold">Balance (Cr.)</div></div>
                    <!-- <div class="col p-1"><div class="bg-danger bg-gradient text-white text-end p-2 fs-8 fw-bold">Invoice Amount (Cr.)</div></div> -->
                    <div class="col p-1"><div class="bg-primary bg-gradient text-white text-end p-2 fs-8 fw-bold">Invoice Amount (Cr.)</div></div>
                    <div class="col p-1"><div class="bg-warning bg-gradient text-white text-end p-2 fs-8 fw-bold">Receivables (Cr.)</div></div>
                    <div class="col p-1"><div class="bg-success bg-gradient text-white text-end p-2 fs-8 fw-bold">Received (Cr.)</div></div>

                </div>
            </div>
        </div>
        <?
        $sno = 1;
        $total_contract = $total_inv_val = $total_receivables = $total_received = $total_balance = $total_of_basic = $total_of_invoice = 0;
        // print "<pre>"; print_r($invoice_totals); print "</pre>";
        foreach($project_data as $project) {
            $total_contract += $project['contract_value'];
            ?>
            <div class="row">
                <div class="col-md-3 p-1"><div class="bg-secondary-subtle fs-6 p-2 text-secondary-emphasis"><?= $sno++ ?>. <a href="javascript:viewProjectInvoices(<?= $project['id'] ?>)"><?= $project['code'] ?> <?= $project['name'] ?></a></div></div>
                <?
                $invoice_value = $receivables = $received = $balance = $basic_amount = $invoice_amount = 0;
                if(isset($project_totals_data[$project['id']])) {
                    $invoice_value = $project_totals_data[$project['id']]['invoice_value'];
                    $receivables = $project_totals_data[$project['id']]['invoice_value'] - ($project_totals_data[$project['id']]['deductions']);
                    $received = $project_totals_data[$project['id']]['received'];
                    $balance = $receivables - $received - $project_totals_data[$project['id']]['other_deductions'];
                    $basic_amount = (isset($invoice_totals[$project['id']]['basic_amount']) and !empty($invoice_totals[$project['id']]['basic_amount'])) ? $invoice_totals[$project['id']]['basic_amount'] : 0;
                    // $invoice_amount = (isset($invoice_totals[$project['id']]['invoice_amount']) and !empty($invoice_totals[$project['id']]['invoice_amount'])) ? $invoice_totals[$project['id']]['invoice_amount'] : 0;
                    // $invoice_amount = (isset($invoice_totals[$project['id']]['invoice_amount']) and !empty($invoice_totals[$project['id']]['invoice_amount'])) ? $invoice_totals[$project['id']]['invoice_amount'] : 0;
                    $balance = $project['contract_value'] - $basic_amount;

                    // print "<pre>"; print_r($invoice_totals); print "</pre>";
                    // Calculate totals
                    $total_inv_val += $invoice_value;
                    $total_receivables += $receivables;
                    $total_received += $received;
                    $total_balance += $balance;
                    $total_of_basic += $basic_amount;
                    // $total_of_invoice += $invoice_amount;
                }
                ?>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col p-1"><div class="bg-info-subtle text-end fs-8 p-2 text-info-emphasis"><?= displayNumber($project['contract_value'] / $cr, 2) ?></div></div>
                        <div class="col p-1"><div class="bg-success-subtle text-end fs-8 p-2 text-success-emphasis"><?= displayNumber(($basic_amount) / $cr,2) ?></div></div>
                        <div class="col p-1"><div class="bg-danger-subtle text-end fs-8 p-2 text-danger-emphasis"><?= displayNumber(($balance) / $cr,2) ?></div></div>
                        <?/*<div class="col p-1"><div class="bg-success-subtle text-end fs-8 p-2 text-success-emphasis"><?= displayNumber($invoice_amount / $cr, 2) ?></div></div>*/?>
                        <div class="col p-1"><div class="bg-primary-subtle text-end fs-8 p-2 text-primary-emphasis"><?= displayNumber($invoice_value / $cr, 2) ?></div></div>
                        <div class="col p-1"><div class="bg-warning-subtle text-end fs-8 p-2 text-warning-emphasis"><?= displayNumber($receivables / $cr, 2) ?></div></div>
                        <div class="col p-1"><div class="bg-success-subtle text-end fs-8 p-2 text-success-emphasis"><?= displayNumber($received / $cr, 2) ?></div></div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
        <div class="row">
            <div class="col-md-3 p-1"><div class="bg-secondary bg-opacity-25 bg-opacity-theme-5 fs-5 p-2 text-secondary-emphasis">Totals</div></div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col p-1"><div class="bg-info bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-info-emphasis"><?= displayNumber($total_balance / $cr, 2) ?></div></div>                    
                    <div class="col p-1"><div class="bg-success bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-success-emphasis"><?= displayNumber($total_of_basic / $cr, 2) ?></div></div>
                    <div class="col p-1"><div class="bg-danger bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-danger-emphasis"><?= displayNumber($total_balance / $cr, 2) ?></div></div>
                   <?/*<div class="col p-1"><div class="bg-success bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-success-emphasis"><?= displayNumber($total_of_invoice / $cr, 2) ?></div></div>*/?>
                    <div class="col p-1"><div class="bg-primary bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-primary-emphasis"><?= displayNumber($total_inv_val / $cr, 2) ?></div></div>
                    <div class="col p-1"><div class="bg-warning bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-warning-emphasis"><?= displayNumber($total_receivables / $cr, 2) ?></div></div>
                    <div class="col p-1"><div class="bg-success bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-success-emphasis"><?= displayNumber($total_received / $cr, 2) ?></div></div>
                </div>
            </div>
        </div>
        <div class="form-text">
            <strong>Billed:</strong> Basic + Tax, <strong>Receivables:</strong> Basic + Tax - Statutory Deductions, <strong>Balance:</strong> Basic + Tax - Statutory Deductions - Received Amount - Other Deductions
        </div>
    </div>
</div>