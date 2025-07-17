<?php
/**
 * Project invoices
 */

// Contract value
$contract_value = $project['contract_value_inr'] + ($project['contract_value'] * $project['ex_rate']);

$inv_category_val = (isset($params['inv_category']) && !empty($params['inv_category'])) ? $params['inv_category'] : "";
$project_id_val = (isset($params['project_id']) && !empty($params['project_id'])) ? $params['project_id'] : "";

// Prepare Data for invoices category wise
$invoice_data = array();
foreach($invoices as $invoice) {
    $invoice_data[$invoice['inv_category']][] = $invoice;
}
?>
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?= $project['code'] ?> <?= $project['name'] ?> - Invoices</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Totals -->
            <div class="card" id="cc"></div>
            <div class="table-modal mt-2">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="align-middle">
                            <th nowrap rowspan="2" width="1%" class="text-center">S.No.</th>
                            <th nowrap rowspan="2">Invoice No.</th>
                            <th nowrap rowspan="2">Date</th>
                            <th nowrap rowspan="2">Type</th>
                            <th nowrap colspan="4" class="text-center">Invoice Value</th>
                            <th nowrap colspan="6" class="text-center">Deductions</th>
                            <th nowrap rowspan="2" class="text-end">Total</th>
                            <th nowrap rowspan="2" class="text-end">Received</th>
                            <th nowrap rowspan="2" class="text-end">Balance</th>
                        </tr>
                        <tr class="align-middle">
                            <th nowrap class="text-end">Basic</th>
                            <th nowrap class="text-end">SGST</th>
                            <th nowrap class="text-end">CGST</th>
                            <th nowrap class="text-end">Total</th>
                            <th nowrap class="text-end">TDS</th>
                            <th nowrap class="text-end">TDS-SGST</th>
                            <th nowrap class="text-end">TDS-CGST</th>
                            <th nowrap class="text-end">Labour Cess</th>
                            <th nowrap class="text-end">Others</th>
                            <th nowrap class="text-end">Total D</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap>
                                <select name="pro_inv_category" id="pro_inv_category" class="form-select form-select-sm" onchange="viewProjectInvoices(<?= $project_id_val ?>)">
                                    <option value="">All</option>
                                    <?
                                    if (isset($inv_categories) && !empty($inv_categories)) {
                                            foreach ($inv_categories as $key => $category) {
                                                ?>
                                                <option value= "<?= $key ?>" <? if ($inv_category_val == $key) { print "selected = 'selected'";} ?>><?= $category ?></option>
                                                <?
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                            <td nowrap></td>
                        </tr>
                        <?
                        $i = 1;
                        // Final totals
                        $basic_final = $sgst_final = $cgst_final = $total_final = $tds_final = $tds_sgst_final = $tds_cgdst_final = $labour_final = $other_ded_final = $total_ded_final = $receivable_final = $received_final = $balance_final = 0;
                        foreach($inv_categories as $category_id => $category_name) {
                            ?>
                            <tr>
                                <td colspan="2"><span class="text-primary fs-6"><?= $category_name ?></span></td>
                                <td colspan="15"></td>
                            </tr>
                            <?
                            $total_basic = $base_amt_gt = $ded_amt_total = $inv_amt_total = $paid_amt_total = $bal_amt_total = $sgst_amt_total = $cgst_amt_total = $tds_amt_total = $tds_sgst_amt_total = $tds_cgst_amt_total = $lbr_cess_amt_total = $othr_ded_amt_total = 0;
                            if (isset($invoice_data[$category_id]) && !empty($invoice_data[$category_id])) {
                                foreach ($invoice_data[$category_id] as $key => $invoice) {
                                    $basic = (isset($invoice['basic']) && !empty($invoice['basic'])) ? $invoice['basic'] : 0;
                                    $basic_sgst = (isset($invoice['sgst']) && !empty($invoice['sgst'])) ? $invoice['sgst'] : 0;
                                    $basic_cgst = (isset($invoice['cgst']) && !empty($invoice['cgst'])) ? $invoice['cgst'] : 0;
                                    $basic_total = (isset($invoice['total']) && !empty($invoice['total'])) ? $invoice['total'] : 0;
                                    $tds = (isset($invoice['tds']) && !empty($invoice['tds'])) ? $invoice['tds'] : 0;
                                    $tds_sgst = (isset($invoice['tds_sgst']) && !empty($invoice['tds_sgst'])) ? $invoice['tds_sgst'] : 0;
                                    $tds_cgst = (isset($invoice['tds_cgst']) && !empty($invoice['tds_cgst'])) ? $invoice['tds_cgst'] : 0;
                                    $lbr_cess = (isset($invoice['labour_cess']) && !empty($invoice['labour_cess'])) ? $invoice['labour_cess'] : 0;
                                    $other_ded = (isset($invoice['other_deductions']) && !empty($invoice['other_deductions'])) ? $invoice['other_deductions'] : 0;
                                    $total_ded = $tds+$tds_sgst+$tds_cgst+$lbr_cess+$other_ded;
                                    $g_total = $basic_total - $total_ded;
                                    $total_received = (isset($invoice['total_received']) && !empty($invoice['total_received'])) ? $invoice['total_received'] : 0;
                                    $balance_amt = $g_total - $total_received;

                                    $total_basic += $basic;
                                    $sgst_amt_total += $basic_sgst;
                                    $cgst_amt_total += $basic_cgst;
                                    $base_amt_gt += $basic_total;
                                    $tds_amt_total += $tds;
                                    $tds_sgst_amt_total += $tds_sgst;
                                    $tds_cgst_amt_total += $tds_cgst;
                                    $lbr_cess_amt_total += $lbr_cess;
                                    $othr_ded_amt_total += $other_ded;
                                    $ded_amt_total += $total_ded;
                                    $inv_amt_total += $g_total;
                                    $paid_amt_total += $total_received;
                                    $bal_amt_total += $balance_amt;
                                    ?>
                                    <tr>
                                        <td nowrap class="text-center"><?= $i++ ?></td>
                                        <td nowrap><?= $invoice['inv_number'] ?></td>
                                        <td nowrap><?= displayDate($invoice['inv_date']) ?></td>
                                        <td nowrap><?= (isset($inv_categories[$invoice['inv_category']]) && !empty($inv_categories[$invoice['inv_category']])) ? $inv_categories[$invoice['inv_category']] : "-"?></td>
                                        <td nowrap class="text-end"><?= displayNumber($basic) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($basic_sgst) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($basic_cgst) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($basic_total) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($tds) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($tds_sgst) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($tds_cgst) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($lbr_cess) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($other_ded) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($total_ded) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($g_total) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($total_received) ?></td>
                                        <td nowrap class="text-end"><?= displayNumber($balance_amt) ?></td>
                                    </tr>
                                    <?
                                }
                                ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td nowrap colspan="2" class="text-end fw-bolder"><?= $category_name ?> Totals</td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($total_basic) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($sgst_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($cgst_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($base_amt_gt) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($tds_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($tds_sgst_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($tds_cgst_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($lbr_cess_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($othr_ded_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($ded_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($inv_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($paid_amt_total) ?></td>
                                    <td nowrap class="text-end fw-bolder"><?= displayNumber($bal_amt_total) ?></td>
                                </tr>
                                <?
                            }
                            else { 
                                ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td nowrap colspan="15"><div class="alert alert-warning m-0">No Records Found</div></td>
                                </tr>
                            <?
                            }
                            $basic_final += $total_basic;
                            $sgst_final += $sgst_amt_total;
                            $cgst_final += $cgst_amt_total;
                            $total_final += $base_amt_gt;
                            $tds_final += $tds_amt_total;
                            $tds_sgst_final += $tds_sgst_amt_total;
                            $tds_cgdst_final += $tds_cgst_amt_total;
                            $labour_final += $lbr_cess_amt_total;
                            $other_ded_final += $othr_ded_amt_total;
                            $total_ded_final += $ded_amt_total;
                            $receivable_final += $inv_amt_total;
                            $received_final += $paid_amt_total;
                            $balance_final += $bal_amt_total;
                        }
                        // Paid percentage
                        $paid_percentage = ($received_final > 0 ) ? round(($received_final / $receivable_final) * 100, 2) : 0;
                        ?>
                        <tr><td colspan="2"> </td><td nowrap colspan="15"></td></tr>
                        <tr>
                            <th colspan="2"></th>
                            <th nowrap colspan="2" class="text-end">Final Totals</th>
                            <th nowrap class="text-end"><?= displayNumber($basic_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($sgst_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($cgst_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($total_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($tds_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($tds_sgst_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($tds_cgdst_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($labour_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($other_ded_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($total_ded_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($receivable_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($received_final) ?></th>
                            <th nowrap class="text-end"><?= displayNumber($balance_final) ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card d-none" id="oc">
                <div class="card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-2">
                            Contract Value (Cr.)
                            <div class="text-info fs-5"><?= displayNumber(($contract_value / 10000000), 4) ?></div>
                        </div>
                        <div class="col-md-2">
                            Other Deductions (Cr.)
                            <div class="text-warning fs-5"><?= displayNumber(($other_ded_final / 10000000), 4) ?></div>
                        </div>
                        <div class="col-md-2">
                            Receivables (Cr.)
                            <div class="text-primary fs-5"><?= displayNumber(($receivable_final / 10000000), 4) ?></div>
                        </div>
                        <div class="col-md-2">
                            Received (Cr.)
                            <div class="text-success fs-5"><?= displayNumber(($received_final / 10000000), 4) ?></div>
                        </div>
                        <div class="col-md-2">
                            Balance (Cr.)
                            <div class="text-danger fs-5"><?= displayNumber(($balance_final / 10000000), 4) ?></div>
                        </div>
                        <div class="col-md-2">
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="<?= $paid_percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: <?= $paid_percentage ?>%"><?= $paid_percentage ?>%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i>&nbsp;Close</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        // Move bottom totals card to top
        $('#cc').html($('#oc').html());
        // Table column freeze
        $('#myModal').one('shown.bs.modal', function (e) {
            $(this).find(".table-modal").freezeTable({
                'container': '#myModal.modal',
                'columnNum' : 2,
                'scrollable': true,
            });
        });
    });
</script>