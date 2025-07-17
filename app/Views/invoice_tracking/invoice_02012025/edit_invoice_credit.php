<?php
/**
 * Invoice tracking
 * Edit invoice credit
 */

// Credit types
$credit_types = array(
    1 => 'Credit Note',
    2 => 'Debit Note',
);
?>
<form id="edi-cre">
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Edit Credit / Debit Note</h5>
        </div>
        <div class="card-body">
            <input type="hidden" name="id" value="<?= $credit_data['id'] ?>">
            <input type="hidden" name="invoice_id" value="<?= $credit_data['inv_id'] ?>">
            <div class="row">
                <div class="col-sm-3">
                    <div class="mb-0">
                        <label class="form-label">Amount&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <input type="text" name="amount" class="form-control form-control-sm text-end" value="<?= (set_value('amount')) ? set_value('amount') : $credit_data['amount'] ?>">
                        <span class="text-danger"><?= validation_show_error('amount') ?></span>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="mb-0">
                        <label class="form-label">Type&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <select class="form-select form-select-sm" name="cre_type">
                            <option value="">Select</option>
                            <?
                            if($credit_types) {
                                foreach($credit_types as $type_id => $type_name) {
                                    ?><option value="<?= $type_id ?>" <? if((set_value('cre_type') == $type_id) OR ($credit_data['type'] == $type_id)) { echo 'selected'; } ?>><?= $type_name ?></option><?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= validation_show_error('cre_type') ?></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-0">
                        <label class="form-label">Note&nbsp;:</label>
                        <textarea name="note" class="form-control"><?= (set_value('note')) ? set_value('note') : $credit_data['note'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="button" class="btn btn-sm btn-success" onclick="updateInvoiceCredit(<?= $credit_data['inv_id'] ?>)"><i class="bi bi-check-square"></i>&nbsp;Update Credit Note</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="javascript:$('#inv-cre').html('')"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</form>