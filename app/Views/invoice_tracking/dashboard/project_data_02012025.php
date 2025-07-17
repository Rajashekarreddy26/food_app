<?php
/**
 * Invoice tracking
 * Dashboard - Project data
 */

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
            <div class="col-md-3 p-1"><div class="bg-secondary bg-gradient text-white p-2 fs-6 fw-bold">Project</div></div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-3 p-1"><div class="bg-info bg-gradient text-white text-end p-2 fs-6 fw-bold">Contract Value (in Cr.)</div></div>
                    <div class="col-md-3 p-1"><div class="bg-primary bg-gradient text-white text-end p-2 fs-6 fw-bold">Receivables (in Cr.)</div></div>
                    <div class="col-md-3 p-1"><div class="bg-success bg-gradient text-white text-end p-2 fs-6 fw-bold">Received Amount (in Cr.)</div></div>
                    <div class="col-md-3 p-1"><div class="bg-danger bg-gradient text-white text-end p-2 fs-6 fw-bold">Balance Amount (in Cr.)</div></div>
                </div>
            </div>
        </div>
        <?
        $sno = 1;
        $total_contract = $total_inv_val = $total_receivables = $total_received = $total_balance = 0;
        foreach($project_data as $project) {
            $total_contract += $project['contract_value'];
            ?>
            <div class="row">
                <div class="col-md-3 p-1"><div class="bg-secondary-subtle fs-6 p-2 text-secondary-emphasis"><?= $sno++ ?>. <a href="javascript:viewProjectInvoices(<?= $project['id'] ?>)"><?= $project['code'] ?> <?= $project['name'] ?></a></div></div>
                <?
                $invoice_value = $receivables = $received = $balance = 0;
                if(isset($project_totals_data[$project['id']])) {
                    $invoice_value = $project_totals_data[$project['id']]['invoice_value'];
                    $receivables = $project_totals_data[$project['id']]['invoice_value'] - ($project_totals_data[$project['id']]['deductions'] + $project_totals_data[$project['id']]['other_deductions']);
                    $received = $project_totals_data[$project['id']]['received'];
                    $balance = $receivables - $received;
                    // Calculate totals
                    $total_inv_val += $invoice_value;
                    $total_receivables += $receivables;
                    $total_received += $received;
                    $total_balance += $balance;
                }
                ?>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3 p-1"><div class="bg-info-subtle text-end fs-6 p-2 text-info-emphasis"><?= displayNumber($project['contract_value'] / 10000000, 2) ?></div></div>
                        <div class="col-md-3 p-1"><div class="bg-primary-subtle text-end fs-6 p-2 text-primary-emphasis"><?= displayNumber($receivables / 10000000, 2) ?></div></div>
                        <div class="col-md-3 p-1"><div class="bg-success-subtle text-end fs-6 p-2 text-success-emphasis"><?= displayNumber($received / 10000000, 2) ?></div></div>
                        <div class="col-md-3 p-1"><div class="bg-danger-subtle text-end fs-6 p-2 text-danger-emphasis"><?= displayNumber(($balance) / 10000000,2) ?></div></div>
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
                    <div class="col-md-3 p-1"><div class="bg-info bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-info-emphasis"><?= displayNumber($total_contract / 10000000, 2) ?></div></div>
                    <div class="col-md-3 p-1"><div class="bg-primary bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-primary-emphasis"><?= displayNumber($total_receivables / 10000000, 2) ?></div></div>
                    <div class="col-md-3 p-1"><div class="bg-success bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-success-emphasis"><?= displayNumber($total_received / 10000000, 2) ?></div></div>
                    <div class="col-md-3 p-1"><div class="bg-danger bg-opacity-25 bg-opacity-theme-5 text-end fs-5 p-2 text-danger-emphasis"><?= displayNumber($total_balance / 10000000, 2) ?></div></div>
                </div>
            </div>
        </div>
    </div>
</div>