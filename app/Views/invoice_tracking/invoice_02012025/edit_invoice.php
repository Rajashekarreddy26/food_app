<?php
/**
 * Invoice tracking
 * Edit Invoice form
 */
$basic = is_numeric(set_value('basic')) ? set_value('basic') : $invoice_data['basic'];
$sgst = $cgst = $tds = $stds = $ctds = $labour = $totalI = $totalD = 0;
if($basic > 0) {
    $sgst = $basic * (INV_PARAMS['sgst'] / 100);
    $cgst = $basic * (INV_PARAMS['cgst'] / 100);
    $tds = $basic * (INV_PARAMS['tds'] / 100);
    $stds = $basic * (INV_PARAMS['tds_sgst'] / 100);
    $ctds = $basic * (INV_PARAMS['tds_cgst'] / 100);
    // $labour = $basic * (INV_PARAMS['labour_cess'] / 100);
    $labour = is_numeric(set_value('labour')) ? set_value('labour') : 0;
    $totalI = $basic + $sgst + $cgst;
    $totalD = $tds + $stds + $ctds + $labour;
}
?>
<div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Invoice - <?= $invoice_data['inv_number'] ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="edit-inv-frm">
                <input type="hidden" name="id" value="<?= $invoice_data['id'] ?>">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label text-end">Project&nbsp;:</label>
                    <div class="col-sm-7">
                        <select name="project" class="form-select">
                            <option>Select project</option>
                            <?
                            if(isset($projects)) {
                                foreach($projects as $project) {
                                    ?><option value="<?= $project['id'] ?>" <? if((set_value('project') == $project['id']) OR ($invoice_data['project_id'] == $project['id'])) { echo 'selected'; } ?>><?= $project['name'] ?> (<?= $project['code'] ?>)</option><?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><small><?= validation_show_error('project') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label text-end">Invoice Category&nbsp;:</label>
                    <div class="col-sm-7">
                        <select name="category" class="form-select">
                            <option>Select category</option>
                            <?
                            if(isset($categories)) {
                                foreach($categories as $id => $category) {
                                    ?><option value="<?= $id ?>" <? if((set_value('category') == $id) OR ($invoice_data['inv_category'] == $id)) { echo 'selected'; } ?>><?= $category ?></option><?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><small><?= validation_show_error('category') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inv_number" class="col-sm-3 col-form-label text-end">Invoice Number&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" name="inv_number" id="inv_number" class="form-control" value="<?= (set_value('inv_number')) ? set_value('inv_number') : $invoice_data['inv_number'] ?>">
                        <span class="text-danger"><small><?= validation_show_error('inv_number') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inv_date" class="col-sm-3 col-form-label text-end">Invoice Date&nbsp;:</label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-sm date">
                            <input type="text" name="inv_date" id="inv_date" class="form-control" placeholder="MM-DD-YYYY" value="<?= (set_value('inv_date')) ? set_value('inv_date') : date('d-m-Y', strtotime($invoice_data['inv_date'])) ?>">
                            <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                        </div>
                        <span class="text-danger"><small><?= validation_show_error('inv_date') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="site_ref_no" class="col-sm-3 col-form-label text-end">Site Ref. Number&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" name="site_ref_no" id="site_ref_no" class="form-control" value="<?= (set_value('site_ref_no')) ? set_value('site_ref_no') : $invoice_data['site_ref_no'] ?>">
                        <span class="text-danger"><small><?= validation_show_error('site_ref_no') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="ra_bill_no" class="col-sm-3 col-form-label text-end">RA Bill Number&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" name="ra_bill_no" id="ra_bill_no" class="form-control" value="<?= (set_value('ra_bill_no')) ? set_value('ra_bill_no') : $invoice_data['ra_bill_no'] ?>">
                        <span class="text-danger"><small><?= validation_show_error('ra_bill_no') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="basic" class="col-sm-3 col-form-label text-end">Basic Amount&nbsp;:</label>
                    <div class="col-sm-7">
                        <input type="text" name="basic" id="basic" class="form-control" value="<?= (set_value('basic')) ? set_value('basic') : $invoice_data['basic'] ?>" onchange="invoiceValuation()">
                        <span class="text-danger"><small><?= validation_show_error('basic') ?></small></span>
                        <input type="hidden" name="sgst" id="sgst" value="<?= INV_PARAMS['sgst'] ?>">
                        <input type="hidden" name="cgst" id="cgst" value="<?= INV_PARAMS['cgst'] ?>">
                        <input type="hidden" name="tds" id="tds" value="<?= INV_PARAMS['tds'] ?>">
                        <input type="hidden" name="tds_sgst" id="tds_sgst" value="<?= INV_PARAMS['tds_sgst'] ?>">
                        <input type="hidden" name="tds_cgst" id="tds_cgst" value="<?= INV_PARAMS['tds_cgst'] ?>">
                        <input type="hidden" name="labour_cess" id="labour_cess" value="<?= INV_PARAMS['labour_cess'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">&nbsp;</div>
                    <div class="col-sm-7">
                        <table class="table table-bordered">
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
                                    <td class="text-end">
                                        <?/*<span id="inv-dl"><?= displayNumber($labour, 2) ?></span>*/?>
                                        <input type="text" id="inv-dl" name="labour" class="form-control text-end" value="<?= (set_value('labour')) ? set_value('labour') : $invoice_data['labour_cess'] ?>" onchange="invoiceValuation()">
                                        <span class="text-danger"><small><?= validation_show_error('labour') ?></small></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Invoice Total</th>
                                    <td class="text-end"><span id="inv-t"><?= displayNumber($totalI, 2) ?></span></td>
                                    <th>Total Deductions</th>
                                    <td class="text-end"><span id="inv-d"><?= displayNumber($totalD, 2) ?></span></td>
                                </tr>
                                <tr><td colspan="4"></td></tr>
                                <tr>
                                    <th colspan="3" class="text-end">Total Receivable</th>
                                    <td class="text-end"><span id="inv-r"><?= displayNumber(($totalI - $totalD), 2) ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="notes" class="col-sm-3 col-form-label text-end">Notes&nbsp;:</label>
                    <div class="col-sm-7">
                        <textarea name="notes" id="notes" class="form-control"><?= (set_value('notes')) ? set_value('notes') : $invoice_data['note'] ?></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-sm" onclick="updateInvoice()"><i class="bi bi-plus-square"></i>&nbsp;Update</button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#inv_date').datepicker({format:"dd-mm-YYYY", autoHide:true});
</script>