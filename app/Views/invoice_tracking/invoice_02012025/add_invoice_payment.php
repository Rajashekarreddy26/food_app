<?php
/**
 * Invoice tracking
 * Add invoice payment
 */
?>
<form id="add-pay">
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Add Payment</h5>
        </div>
        <div class="card-body">
            <input type="hidden" name="invoice_id" value="<?= $invoice_id ?>">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label mb-0">Payment Date&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="payment_date" id="payment_date" class="form-control form-control-sm" value="<?= set_value('payment_date') ?>">
                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                        </div>
                        <span class="text-danger"><?= validation_show_error('payment_date') ?></span>
                    </div>                   
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label mb-0">Payment Amount&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <input type="text" name="amount" class="form-control form-control-sm text-end" value="<?= set_value('amount') ?>">
                        <span class="text-danger"><?= validation_show_error('amount') ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label mb-0">Payment Type&nbsp;<span class="text-danger">*</span>&nbsp;:</label>
                        <select class="form-select form-select-sm" name="payment_type">
                            <option value="">Select</option>
                            <?
                            if($payment_types) {
                                foreach($payment_types as $payment_type) {
                                    ?><option value="<?= $payment_type['id'] ?>" <? if(set_value('payment_type') == $payment_type['id']) { echo 'selected'; } ?>><?= $payment_type['name'] ?></option><?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?= validation_show_error('payment_type') ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="mb-3">
                        <label class="form-label mb-0">Reference Number&nbsp;:</label>
                        <input type="text" name="ref_number" class="form-control form-control-sm" value="<?= set_value('ref_number') ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="mb-0">
                        <label class="form-label mb-0">Note&nbsp;:</label>
                        <textarea name="note" class="form-control form-control-sm"><?= set_value('note') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="button" class="btn btn-sm btn-success" onclick="saveInvoicePayment(<?= $invoice_id ?>)"><i class="bi bi-check-square"></i>&nbsp;Save Payment</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="javascript:$('#inv-pay').html('')"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $('#payment_date').datepicker({format:"dd-mm-YYYY", autoHide:true});
</script>