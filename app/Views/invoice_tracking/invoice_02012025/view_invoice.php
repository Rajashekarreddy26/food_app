<?php
/**
 * Invoice tracking
 * View invoice details
 */
$basic = $invoice_data['basic'];
$other_ded = ($invoice_data['other_deductions'] > 0) ? $invoice_data['other_deductions'] : 0;
$received = ($invoice_data['total_received'] > 0) ? $invoice_data['total_received'] : 0;
$credits = isset($invoice_data['credit']) ? $invoice_data['credit'] : 0;
$sgst = $cgst = $tds = $stds = $ctds = $labour = $totalI = $totalD = $balance = 0;
if($basic > 0) {
    $sgst = $invoice_data['sgst'];
    $cgst = $invoice_data['cgst'];
    $tds = $invoice_data['tds'];
    $stds = $invoice_data['tds_sgst'];
    $ctds = $invoice_data['tds_cgst'];
    $labour = $invoice_data['labour_cess'];
    $totalI = $basic + $sgst + $cgst + $credits;
    $totalD = $tds + $stds + $ctds + $labour + $other_ded;
    $received_per = round((($received / ($totalI - $totalD)) * 100), 2);
    $balance = $totalI - $totalD - $received;
}
?>

<div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Invoice details - <?= $invoice_data['inv_number'] ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-3">
                            <div class="form-view-name">Receivable</div>
                            <div class="form-view-value text-primary"><?= displayNumber(($totalI - $totalD), 2) ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-view-name">Received</div> 
                            <div class="form-view-value text-success"><?= displayNumber($received, 2) ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-view-name">Balance</div>
                            <div class="form-view-value text-danger"><?= displayNumber($balance, 2) ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: <?= $received_per ?>%"><?= $received_per ?>%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <? if($tab_id == 1) { echo 'active'; } ?>" id="inv-tab" data-bs-toggle="tab" data-bs-target="#inv-tab-pane" type="button" role="tab" aria-controls="inv-tab-pane" aria-selected="true"><i class="bi bi-file-text"></i>&nbsp;Invoice Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <? if($tab_id == 2) { echo 'active'; } ?>" id="inv-ded-tab" data-bs-toggle="tab" data-bs-target="#inv-ded-tab-pane" type="button" role="tab" aria-controls="inv-ded-tab-pane" aria-selected="false"><i class="bi bi-file-minus"></i>&nbsp;Deductions</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <? if($tab_id == 4) { echo 'active'; } ?>" id="inv-cre-tab" data-bs-toggle="tab" data-bs-target="#inv-cre-tab-pane" type="button" role="tab" aria-controls="inv-cre-tab-pane" aria-selected="false"><i class="bi bi-file-diff"></i>&nbsp;Credit Note</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <? if($tab_id == 3) { echo 'active'; } ?>" id="inv-pmt-tab" data-bs-toggle="tab" data-bs-target="#inv-pmt-tab-pane" type="button" role="tab" aria-controls="inv-pmt-tab-pane" aria-selected="false"><i class="bi bi-file-check"></i>&nbsp;Payments</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <? if($tab_id == 5) { echo 'active'; } ?>" id="inv-doc-tab" data-bs-toggle="tab" data-bs-target="#inv-doc-tab-pane" type="button" role="tab" aria-controls="inv-doc-tab-pane" aria-selected="false"><i class="bi bi-file-text"></i>&nbsp;Documents</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" onclick="viewInvoice(<?= $invoice_data['id'] ?>, <?= $tab_id ?>)"><i class="bi bi-arrow-clockwise"></i>&nbsp;Refresh</button>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Invoice Details -->
                <div class="tab-pane fade <? if($tab_id == 1) { echo 'show active'; } ?>" id="inv-tab-pane" role="tabpanel" aria-labelledby="inv-tab" tabindex="0">
                    <div class="pt-3">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <label class="col-sm-6 col-form-label text-end">Client&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_data['client_name'] ?></label>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-6 col-form-label text-end">Project Code&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_data['project_code'] ?></label>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-6 col-form-label text-end">Project Name&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_data['project_name'] ?></label>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-6 col-form-label text-end">Invoice Category&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_categories[$invoice_data['inv_category']] ?></label>
                                        </div>
                                        <div class="row">
                                            <label for="inv_number" class="col-sm-6 col-form-label text-end">Invoice Number&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_data['inv_number'] ?></label>
                                        </div>
                                        <div class="row">
                                            <label for="inv_date" class="col-sm-6 col-form-label text-end">Invoice Date&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= displayDate($invoice_data['inv_date']) ?></label>
                                        </div>
                                        <div class="row">
                                            <label for="site_ref_no" class="col-sm-6 col-form-label text-end">Site Ref. Number&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_data['site_ref_no'] ?></label>
                                        </div>
                                        <div class="row">
                                            <label for="ra_bill_no" class="col-sm-6 col-form-label text-end">RA Bill Number&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_data['ra_bill_no'] ?></label>
                                        </div>
                                        <div class="row">
                                            <label for="notes" class="col-sm-6 col-form-label text-end">Notes&nbsp;:</label>
                                            <label class="col-form-label col-sm-6"><?= $invoice_data['note'] ?></label>
                                        </div>
                                        <div class="row">
                                            <label for="notes" class="col-sm-6 col-form-label text-end">File&nbsp;:</label>
                                            <label class="col-form-label col-sm-6">
                                                <?
                                                if($invoice_data['inv_file']) {
                                                    ?>
                                                    <a href="<?= WEBROOT ?>files/invoice/<?= $invoice_data['inv_file'] ?>" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                                    <button class="btn btn-sm btn-danger" onclick="invModDeleteFile(this, <?= $invoice_data['id'] ?>, 'inv')"><i class="bi bi-trash"></i></button>
                                                    <?
                                                }
                                                else {
                                                    ?><span><button class="btn btn-sm btn-secondary" onclick="invModAddFile(this, <?= $invoice_data['id'] ?>, 'inv')"><i class="bi bi-file-earmark-plus"></i>&nbsp;Add file</button></span><?
                                                }
                                                ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <div class="table-responsive">                                    
                                    <table class="table table-bordered table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">Invoice Value</th>
                                                <th colspan="2" class="text-center">Deductions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th width="25%">Basic</th>
                                                <td width="25%" class="text-end"><span id="inv-b"><?= displayNumber($basic, 2) ?></span></td>
                                                <th width="25%">TDS (<?= INV_PARAMS['tds'] ?>%)</th>
                                                <td width="25%" class="text-end"><span id="inv-dt"><?= displayNumber($tds, 2) ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>SGST (<?= INV_PARAMS['sgst'] ?>%)</th>
                                                <td class="text-end"><span id="inv-s"><?= displayNumber($sgst, 2) ?></span></td>
                                                <th>TDS SGST (<?= INV_PARAMS['tds_sgst'] ?>%)</th>
                                                <td class="text-end"><span id="inv-ds"><?= displayNumber($stds, 2) ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>CGST (<?= INV_PARAMS['cgst'] ?>%)</th>
                                                <td class="text-end"><span id="inv-c"><?= displayNumber($cgst, 2) ?></span></td>
                                                <th>TDS CGST (<?= INV_PARAMS['tds_sgst'] ?>%)</th>
                                                <td class="text-end"><span id="inv-dc"><?= displayNumber($ctds, 2) ?></span></td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <td></td>
                                                <th>Labour Cess (<?= INV_PARAMS['labour_cess'] ?>%)</th>
                                                <td class="text-end"><span id="inv-dl"><?= displayNumber($labour, 2) ?></span></td>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <td></td>
                                                <th>Other Deductions</th>
                                                <td class="text-end"><span id="inv-dl"><?= displayNumber($other_ded, 2) ?></span></td>
                                            </tr>
                                            <tr>
                                                <th>Invoice Total</th>
                                                <td class="text-end"><span id="inv-t"><?= displayNumber($totalI, 2) ?></span></td>
                                                <th>Total Deductions</th>
                                                <td class="text-end"><span id="inv-d"><?= displayNumber($totalD, 2) ?></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-end">Total Receivable</th>
                                                <th class="text-end"><span id="inv-r"><?= displayNumber(($totalI - $totalD), 2) ?></span></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Deductions -->
                <div class="tab-pane fade <? if($tab_id == 2) { echo 'show active'; } ?>" id="inv-ded-tab-pane" role="tabpanel" aria-labelledby="inv-ded-tab" tabindex="0">
                    <div class="pt-3">
                        <div class="clearfix">
                            <div class="float-end">
                                <div class="d-flex align-items-center">
                                    <div class="me-1">
                                        <button type="button" onclick="addInvoiceDeduction(<?= $id ?>)" class="btn btn-sm btn-success"><i class="bi bi-plus-square"></i>&nbsp;Add Deduction</button>
                                    </div>
                                    <div class="me-1">
                                        <button type="button" onclick="viewInvoice(<?= $invoice_data['id'] ?>, 2)" class="btn btn-sm btn-warning"><i class="bi bi-arrow-clockwise"></i>&nbsp;Refresh</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div id="inv-ded"></div>
                            <div id="invoice-deductions"><? echo view('invoice_tracking/invoice/view_invoice_deductions') ?></div>
                        </div>
                    </div>
                </div>
                <!-- Credit notes -->
                <div class="tab-pane fade <? if($tab_id == 4) { echo 'show active'; } ?>" id="inv-cre-tab-pane" role="tabpanel" aria-labelledby="inv-cre-tab" tabindex="0">
                    <div class="pt-3">
                        <div class="clearfix">
                            <div class="float-end">
                                <div class="d-flex align-items-center">
                                    <div class="me-1">
                                        <button type="button" onclick="addInvoiceCredit(<?= $id ?>)" class="btn btn-sm btn-success"><i class="bi bi-plus-square"></i>&nbsp;Add Credit Note</button>
                                    </div>
                                    <div class="me-1">
                                        <button type="button" onclick="viewInvoice(<?= $invoice_data['id'] ?>, 4)" class="btn btn-sm btn-warning"><i class="bi bi-arrow-clockwise"></i>&nbsp;Refresh</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div id="inv-cre"></div>
                            <div id="invoice-credits"><? echo view('invoice_tracking/invoice/view_invoice_credits') ?></div>
                        </div>
                    </div>
                </div>
                <!-- Payments -->
                <div class="tab-pane fade <? if($tab_id == 3) { echo 'show active'; } ?>" id="inv-pmt-tab-pane" role="tabpanel" aria-labelledby="inv-pmt-tab" tabindex="0">
                    <div class="pt-3">
                        <div class="clearfix">
                            <div class="float-end">
                                <div class="d-flex align-items-center">
                                    <? if($balance > 0): ?>
                                        <div class="me-1">
                                            <button type="button" onclick="addInvoicePayment(<?= $id ?>)" class="btn btn-sm btn-success"><i class="bi bi-plus"></i>&nbsp;Add Payment</button>
                                        </div>
                                    <? endif ?>
                                    <div class="me-1">
                                        <button type="button" onclick="viewInvoice(<?= $invoice_data['id'] ?>, 3)" class="btn btn-sm btn-warning"><i class="bi bi-arrow-clockwise"></i>&nbsp;Refresh</button>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div id="inv-pay"></div>
                            <div id="invoice-payments"><? echo view('invoice_tracking/invoice/view_invoice_payments') ?></div>
                        </div>
                    </div>
                </div>
                <!-- Documents -->
                <div class="tab-pane fade <? if($tab_id == 5) { echo 'show active'; } ?>" id="inv-doc-tab-pane" role="tabpanel" aria-labelledby="inv-doc-tab" tabindex="0">
                    <div class="pt-3">
                        <div class="clearfix">
                            <div class="float-end">
                                <div class="d-flex align-items-center">
                                    <div class="me-1">
                                        <button type="button" onclick="viewInvoice(<?= $invoice_data['id'] ?>, 5)" class="btn btn-sm btn-warning"><i class="bi bi-arrow-clockwise"></i>&nbsp;Refresh</button>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="hr1"></div>
                        <div class="mt-2">
                            <?/*<div id="inv-doc"><? echo view('invoice_tracking/invoice/add_invoice_document') ?></div>*/?>
                            <div id="invoice-docs"><? echo view('invoice_tracking/invoice/view_invoice_documents') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</div>