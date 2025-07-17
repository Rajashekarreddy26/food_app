<?php
/**
 * Invoice tracking
 * Add invoice Credit
 */

// Credit types
$credit_types = array(
    1 => 'Credit Note',
    2 => 'Debit Note',
);
?>
<form id="add-cre">
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Add Credit / Debit Note</h5>
        </div>
        <div class="card-body">
            <input type="hidden" name="invoice_id" value="<?= $invoice_id ?>">
            <div class="row">
                <div class="col-sm-3">
                    <div class="mb-0">
                        <label class="form-label mb-0">Amount&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <input type="text" name="amount" class="form-control form-control-sm text-end" value="<?= set_value('amount') ?>">
                        <span class="text-danger"><?= validation_show_error('amount') ?></span>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-0">
                       <label class="form-label mb-0">Type&nbsp;<span class="text-danger">*</span>&nbsp;:</label> 
                        <select class="form-select form-select-sm" name="cre_type">
                            <option value="">Select</option>
                            <?
                            if($credit_types) {
                                foreach($credit_types as $type_id => $type_name) {
                                    ?><option value="<?= $type_id ?>" <? if(set_value('cre_type') == $type_id) { echo 'selected'; } ?>><?= $type_name ?></option><?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= validation_show_error('cre_type') ?></span>
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
            <button type="button" class="btn btn-sm btn-success" onclick="saveInvoiceCredit(<?= $invoice_id ?>)"><i class="bi bi-check-square"></i>&nbsp;Save Credit Note</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="javascript:$('#inv-cre').html('')"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</form>