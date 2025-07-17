<?php
/**
 * Invoice tracking
 * Add Invoice form
 */
//Without  SGST and CGST Default values
$sgst_value = 0;
$cgst_value = 0;

$invoice_amount_before_gst = is_numeric(set_value('invoice_amount')) ? set_value('invoice_amount') : 0;
$basic = is_numeric(set_value('basic')) ? set_value('basic') : 0;
$sgst = $cgst = $tds = $stds = $ctds = $labour = $totalI = $totalD = 0;
$tax_type = (isset($_POST['tax_type']) and !empty($_POST['tax_type'])) ? $_POST['tax_type'] : '1';
$project_val = (isset($_POST['project']) and !empty($_POST['project'])) ? $_POST['project'] : '';
$mobilizationPer_val = (isset($mobil_adv['mobilization_per']) and !empty($mobil_adv['mobilization_per'])) ? $mobil_adv['mobilization_per'] : ((isset($_POST['mobilizationPer']) and !empty($_POST['mobilizationPer'])) ? $_POST['mobilizationPer'] : 0);

// Check if GST is selected
if (isset($tax_type) && $tax_type == '1') {
    $sgst_value = INV_PARAMS['sgst'];
    $cgst_value = INV_PARAMS['cgst'];
} elseif (isset($tax_type) && $tax_type == '2') {
    // Handle the case when GST is not applied
    $sgst_value = $cgst_value = 0;
}

if ($invoice_amount_before_gst > 0) {
    
    $sgst = $invoice_amount_before_gst * ($sgst_value / 100);
    $cgst = $invoice_amount_before_gst * ($cgst_value / 100);
    $tds = $basic * (INV_PARAMS['tds'] / 100);
    $stds = $basic * (INV_PARAMS['tds_sgst'] / 100);
    $ctds = $basic * (INV_PARAMS['tds_cgst'] / 100);
    
    // Labour cess calculation
    // $labour = is_numeric(set_value('labour')) ? set_value('labour') : $invoice_amount_before_gst * (INV_PARAMS['labour_cess'] / 100);
    $labour = is_numeric(set_value('labour')) ? set_value('labour') : 0;
    
    // Total invoice and deductions calculation
    $totalI = $invoice_amount_before_gst + $sgst + $cgst;
    $totalD = $tds + $stds + $ctds + $labour;
}
?>

<div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Invoice</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="add-inv-frm">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label text-end">Project&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <select name="project" class="form-select" onchange="fetchMobilizationDetails(this.value)">
                            <option value="">Select project</option>
                            <?php if (isset($projects)) {
                                foreach ($projects as $project) { ?>
                                    <option value="<?= $project['id'] ?>" <?= (isset($project_val) && $project_val == $project['id']) ? 'selected' : '' ?>>
                                        <?= $project['name'] ?> (<?= $project['code'] ?>)
                                    </option>
                                <?php }
                            } ?>
                        </select>
                        <span class="text-danger"><small><?= validation_show_error('project') ?></small></span>
                    </div>
                </div>
                <!-- Mobilization   Details -->
                <div id="mobilizationAdvanceSection">
                    <?
                    if (isset($project_val) and !empty($project_val)) {
                        echo view('invoice_tracking/invoice/mobilizationDetails');
                    }
                    ?>                
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label text-end">Invoice Category&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <select name="category" class="form-select">
                            <option>Select category</option>
                            <?
                            if(isset($categories)) {
                                foreach($categories as $id => $category) {
                                    ?><option value="<?= $id ?>" <? if(set_value('category') == $id) { echo 'selected'; } ?>><?= $category ?></option><?
                                }
                            }
                            ?>
                        </select>
                        <span class="text-danger"><small><?= validation_show_error('category') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inv_number" class="col-sm-3 col-form-label text-end">Invoice Number&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" name="inv_number" id="inv_number" class="form-control" value="<?= set_value('inv_number') ?>">
                        <span class="text-danger"><small><?= validation_show_error('inv_number') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inv_date" class="col-sm-3 col-form-label text-end">Invoice Date&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <div class="input-group date">
                            <input type="text" name="inv_date" id="inv_date" class="form-control" placeholder="DD-MM-YYYY" value="<?= set_value('inv_date') ?>">
                            <span class="input-group-text"><i class="bi bi-calendar4-week"></i></span>
                        </div>
                        <!-- <input type="date" name="inv_date" id="inv_date" class="form-control" value="<?= set_value('inv_date') ?>"> -->
                        <span class="text-danger"><small><?= validation_show_error('inv_date') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="site_ref_no" class="col-sm-3 col-form-label text-end">Site Ref. Number&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" name="site_ref_no" id="site_ref_no" class="form-control" value="<?= set_value('site_ref_no') ?>">
                        <span class="text-danger"><small><?= validation_show_error('site_ref_no') ?></small></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="ra_bill_no" class="col-sm-3 col-form-label text-end">RA Bill Number&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" name="ra_bill_no" id="ra_bill_no" class="form-control" value="<?= set_value('ra_bill_no') ?>">
                        <span class="text-danger"><small><?= validation_show_error('ra_bill_no') ?></small></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fx_invoice_amount" class="col-sm-3 col-form-label text-end">Invoice Amount ( &#8377;, &#36;, &#163;, &#8364; )&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" id="fx_invoice_amount" name="fx_invoice_amount" class="form-control" value="<?= set_value('fx_invoice_amount'); ?>" onchange="calculateINR()" placeholder="Enter Foreign Exchange Invoice Amount ( &#8377;, &#36;, &#163;, &#8364; )">
                        <span class="text-danger"><?= validation_show_error('fx_invoice_amount'); ?></span>
                    </div>
                    <label class="col-sm-1 col-form-label text-end" for="currency">Currency Type&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-3">
                        <select class="form-select" name="currency" id="currency" onchange="handleCurrencyChange()">
                            <option value="">Select</option>
                            <?php foreach ($currencies as $key => $value) { ?>
                                <option value="<?= $value['id']; ?>" <?php if (set_value('currency') == $value['id']) { echo "selected"; } ?>>
                                    <?= $value['name']; ?> (<?= html_entity_decode($value['symbol']); ?>)
                                </option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?= validation_show_error('currency'); ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="ex_rate" class="col-sm-3 col-form-label text-end">Exchange Rate&nbsp;:</label>
                    <div class="col-sm-3">
                        <input type="text" id="ex_rate" name="ex_rate" class="form-control" value="<?= set_value('ex_rate'); ?>" onchange="calculateINR()" placeholder="Please Enter Exchange Rate">
                        <span class="text-danger"><?= validation_show_error('ex_rate'); ?></span>
                    </div>
                    <label for="invoice_amount" class="col-sm-1 col-form-label text-end">Invoice Amount&nbsp;:</label>
                    <span class="col-sm-3">
                        <div class="input-group">
                            <input type="text" name="invoice_amount" id="invoice_amount" class="form-control bg-light secondary" value="<?= set_value('invoice_amount'); ?>" readonly placeholder="Invoice Amount" >
                            <span class="input-group-text">&#8377;</span>
                        </div>
                    </span>
                </div>
                <div class="row mb-3">
                    <label for="mobilization_amount" class="col-sm-3 col-form-label text-end">Mobilization Deduction&nbsp;:</label>&nbsp;
                     <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-text">&#8377;</span>
                            <input type="text" name="mobilization_amount" id="mobilization_amount" class="form-control bg-light secondary" readonly placeholder="Mobilization Amount" value="<?= set_value('mobilization_amount'); ?>">
                            <span class="input-group-text bg-transparent" id="mobil_per"><? print $mobilizationPer_val; ?></span>                            
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="basic" class="col-sm-3 col-form-label text-end">Basic After Mobilization Deduction( &#8377; )&nbsp;: <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" name="basic" id="basic" class="form-control" value="<?= set_value('basic') ?>" placeholder="Basic After Mobilization Deduction( &#8377; )"  disabled>
                        <span class="text-danger"><small><?= validation_show_error('basic') ?></small></span>
                        <input type="hidden" name="invoice_amount_before_gst" id="invoice_amount_before_gst" class="form-control" value="<?= set_value('invoice_amount_before_gst') ?>" placeholder="00.00" onchange="invoiceValuation()">
                        <input type="hidden" name="sgst" id="sgst" value="<?= $sgst_value; ?>">
                        <input type="hidden" name="cgst" id="cgst" value="<?= $cgst_value; ?>">
                        <input type="hidden" name="tds" id="tds" value="<?= INV_PARAMS['tds'] ?>">
                        <input type="hidden" name="tds_sgst" id="tds_sgst" value="<?= INV_PARAMS['tds_sgst'] ?>">
                        <input type="hidden" name="tds_cgst" id="tds_cgst" value="<?= INV_PARAMS['tds_cgst'] ?>">
                        <input type="hidden" name="labour_cess" id="labour_cess" value="<?= INV_PARAMS['labour_cess'] ?>">
                        <input type="hidden" name="mobilization_per" id="mobilization_per" value="<?= $mobilizationPer_val ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tax_type" class="col-sm-3 col-form-label text-end">Select Type of GST&nbsp;:</label>
                    <div class="col-sm-7">
                        <label class="me-3"><input type="radio" name="tax_type" value="1" <? if ($tax_type == 1) { print "checked"; } ?> onclick="gst_validation(this.value)">&nbsp;With GST (18%)</label>
                        <label><input type="radio" name="tax_type" value="2" <? if ($tax_type == 2) { print "checked"; } ?> onclick="gst_validation(this.value)">&nbsp;Without GST (0%)</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">&nbsp;</div>
                    <div class="col-sm-7">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Invoice Value</th>
                                    <th colspan="2" class="text-center">Deductions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th width="25%">Invoice Amount</th>
                                    <td width="25%" class="text-end"><span id="inv-b"><?= displayNumber($invoice_amount_before_gst, 2) ?></span></td>
                                    <th width="25%">TDS (<?= INV_PARAMS['tds'] ?>%)</th>
                                    <td width="25%" class="text-end"><span id="inv-dt"><?= displayNumber($tds, 2) ?></span></td>
                                </tr>
                                <tr>
                                    <th>SGST (<span id="table_sgst"><?= $sgst_value; ?></span>%)</th>
                                    <td class="text-end"><span id="inv-s"><?= displayNumber($sgst, 2) ?></span></td>
                                    <th>TDS SGST (<?= INV_PARAMS['tds_sgst'] ?>%)</th>
                                    <td class="text-end"><span id="inv-ds"><?= displayNumber($stds, 2) ?></span></td>
                                </tr>
                                <tr>
                                    <th>CGST (<span id="table_cgst"><?= $cgst_value; ?></span>%)</th>
                                    <td class="text-end"><span id="inv-c"><?= displayNumber($cgst, 2) ?></span></td>
                                    <th>TDS CGST (<?= INV_PARAMS['tds_sgst'] ?>%)</th>
                                    <td class="text-end"><span id="inv-dc"><?= displayNumber($ctds, 2) ?></span></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <th>Labour Cess (<?= INV_PARAMS['labour_cess'] ?>%)</th>
                                    <td class="text-end">
                                        <? /*<span id="inv-dl"><?= displayNumber($labour, 2) ?></span> */?>
                                        <input type="text" id="inv-dl" name="labour" class="form-control text-end" value="<?= set_value('labour') ?>" onchange="invoiceValuation()">
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
                        <textarea name="notes" id="notes" class="form-control"><?= set_value('notes') ?></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-sm" id="submit_btn" onclick="createInvoice()"><i class="bi bi-plus-square"></i>&nbsp;Create</button>
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-square"></i>&nbsp;Close</button>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document.get)
function calculateINR() {
    // Get the FX invoice amount and exchange rate values
    var fxInvoiceAmount = parseFloat(document.getElementById('fx_invoice_amount').value) || 0;
    var exchangeRate = parseFloat(document.getElementById('ex_rate').value) || 0;
    // Calculate the INR value
    var inrValue = fxInvoiceAmount * exchangeRate;
    // Update the  invoice amount field
    document.getElementById('invoice_amount').value = inrValue.toFixed(2);


    // Get the values from the input fields
    var InvoiceAmount = parseFloat(document.getElementById('invoice_amount').value) || 0;
    var mobilizationPercentage = parseFloat(document.getElementById('mobilizationPer').value) || 0;
    $('#mobilization_per').val(mobilizationPercentage);
    // Calculate the mobilization amount
    var mobilizationAmount = (mobilizationPercentage / 100) * InvoiceAmount;
    // Calculate the basic amount after the mobility deduction
    var basicAmountAfterDeduction = InvoiceAmount - mobilizationAmount;
    // Update the field with the calculated basic amount
    document.getElementById('basic').value = basicAmountAfterDeduction.toFixed(2);
    document.getElementById('mobilization_amount').value = mobilizationAmount.toFixed(2);

    var avail_mobil = $('#mobilizationAdvAvailable').val();
    var calc_mobil = avail_mobil - mobilizationAmount;
    invoiceValuation();
    if (calc_mobil < 0) {
        alert('Mobilization amount should be less than remaining mobilization balance.');
        $('#submit_btn').prop('disabled', true);
        return false;
    }
    else {
        $('#submit_btn').prop('disabled', false);
        return true;
    }
}

function gst_validation(gst) {
    if (gst == '2') {
        $('#table_sgst').html(0);
        $('#table_cgst').html(0);
        $('#sgst').val(0);
        $('#cgst').val(0);
    }
    else {
        $('#table_sgst').html(9);
        $('#table_cgst').html(9);
        $('#sgst').val(9);
        $('#cgst').val(9);
    }
    invoiceValuation();

}

function handleCurrencyChange() {

    const currency = document.getElementById('currency').value;
    const exRateField = document.getElementById('ex_rate');
    var mobil_per = $('#mobilizationPer').val();

    $('#mobil_per').text(mobil_per+" (%)");

    //  If INR currency ID is 1
    if (currency == "1") { // Replace "1" with the actual ID of INR in your database
        exRateField.value = "1";
        exRateField.setAttribute("readonly", true); //  This field read-only for INR
    } else {
        exRateField.value = "";
        exRateField.removeAttribute("readonly"); //  Editing for other currencies
    }
     calculateINR()
}

</script>

<script type="text/javascript">
    $('#inv_date').datepicker({format:"dd-mm-YYYY", autoHide:true});


    function fetchMobilizationDetails(projectId) {
    if (projectId) {
        $.ajax({
            url: WEBROOT + 'invoice/fetch_mobilization_details',
            type: 'GET',
            data: { project: projectId },
            success: function(response) {
                $('#mobilizationAdvanceSection').html(response);
                handleCurrencyChange();
            }
        });
    } else {
        $('#mobilizationAdvanceSection').html('');
    }
}
</script>