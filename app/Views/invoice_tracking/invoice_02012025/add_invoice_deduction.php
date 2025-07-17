<?php
/**
 * Invoice tracking
 * Add invoice deductions
 */
?>
<form id="add-ded">
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Add Deduction</h5>
        </div>
        <div class="card-body">
            <input type="hidden" name="invoice_id" value="<?= $invoice_id ?>">
            <div class="row">
                <div class="col-sm-3">
                    <div class="mb-0">
                        <label class="form-label mb-0">Deduction Amount&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <input type="text" name="amount" class="form-control form-control-sm text-end" value="<?= set_value('amount') ?>">
                        <span class="text-danger"><?= validation_show_error('amount') ?></span>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-0">
                       <label class="form-label mb-0">Deduction Type&nbsp;<span class="text-danger">*</span>&nbsp;:</label> 
                        <select class="form-select form-select-sm" name="deduction_id">
                            <option value="">Select</option>
                            <?
                            if($deductions) {
                                foreach($deductions as $deduction) {
                                    ?><option value="<?= $deduction['id'] ?>" <? if(set_value('deduction_id') == $deduction['id']) { echo 'selected'; } ?>><?= $deduction['name'] ?></option><?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= validation_show_error('deduction_id') ?></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-0">
                        <label class="form-label mb-0">Note&nbsp;:</label>
                        <textarea name="note" class="form-control"><?= set_value('note') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="button" class="btn btn-sm btn-success" onclick="saveInvoiceDeduction(<?= $invoice_id ?>)"><i class="bi bi-check-square"></i>&nbsp;Save Deduction</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="javascript:$('#inv-ded').html('')"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</form>