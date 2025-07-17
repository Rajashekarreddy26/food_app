/**
 * Invoice js
 */
// Search, filter, sort and pagenation
function invoiceBody(page = 1) {
    var params = $('#inv-ser').serializeArray();
    params.push({name: 'page', value: page});
    params.push({name: 'inv_proj', value: $('#inv-proj').val()});
    params.push({name: 'inv_client', value: $('#inv-client').val()});
    params.push({name: 'inv_type', value: $('#inv-type').val()});
    params.push({name: 'payment_status', value: $('#payment_status').val()});
    $.get(WEBROOT + 'invoice/body', params, function(data) {
        $('#inv-body').html(data);
    });
}
// Invoice body reset
function invoiceBodyReset() {
    $('#inv-ser').find('#key').val('');
    $('#inv-proj').val('');
    $('#inv-client').val('');
    $('#inv-type').val('');
    $('#payment_status').val('');
    invoiceBody();
}
// Add invoice
function addInvoice() {
    $.get(WEBROOT + 'invoice/add', function(data) {
        loadModal(data);
    });
}
// Create invoice
function createInvoice() {
    var params = $('#add-inv-frm').serializeArray();
    $.post(WEBROOT + 'invoice/create', params, function(data) {
        loadModal(data);
        // invoiceBody();
        invoiceBodyReset();
    });
}
// Edit invoice details
function editInvoice(id) {
    $.get(WEBROOT + 'invoice/edit', {'id': id}, function(data) {
        loadModal(data);
    });
}
// Update invoice details
function updateInvoice() {
    var params = $('#edit-inv-frm').serializeArray();
    $.post(WEBROOT + 'invoice/update', params, function(data) {
        loadModal(data);
        invoiceBodyReset();
        // invoiceBody();
    });
}
// Delete invoice
function deleteInvoice(id) {
    if(confirm('This will delete all the files and records associated with this invoice. Are you sure you want to delete?')) {
        $.post(WEBROOT + 'invoice/delete', {'id': id}, function(data){
            loadModal(data);
            invoiceBodyReset();
            // invoiceBody();
        });
    }
}
// view invoice details
function viewInvoice(id, tab = 1) {
    $.get(WEBROOT + 'invoice/view', {'id': id, 'tab': tab}, function(data) {
        loadModal(data);
    });
}
/*// Invoice calculation
function invoiceValuation() {
    let basic = $('#basic').val();
    if(parseFloat(basic) > 0) {
        let sgst = (basic * $('#sgst').val()) / 100;
        let cgst = (basic * $('#cgst').val()) / 100;
        let tds = (basic * $('#tds').val()) / 100;
        let stds = (basic * $('#tds_sgst').val()) / 100;
        let ctds = (basic * $('#tds_cgst').val()) / 100;
        let labour = parseFloat($('#inv-dl').val());
        if($('#inv-dl').val() == '') {
            labour = (basic * $('#labour_cess').val()) / 100;
        }
        let totalI = parseFloat(basic) + parseFloat(sgst) + parseFloat(cgst);
        let totalD = tds + stds + ctds + labour;
        let totalR = totalI - totalD;
        $('#inv-b').html(basic);
        $('#inv-s').html(sgst.toFixed(2));
        $('#inv-c').html(cgst.toFixed(2));
        $('#inv-dt').html(tds.toFixed(2));
        $('#inv-ds').html(stds.toFixed(2));
        $('#inv-dc').html(ctds.toFixed(2));
        $('#inv-dl').val(labour.toFixed(2));
        $('#inv-t').html(totalI.toFixed(2));
        $('#inv-d').html(totalD.toFixed(2));
        $('#inv-r').html(totalR.toFixed(2));
    }
    else {
        $('#inv-b').html(0);
        $('#inv-s').html(0);
        $('#inv-c').html(0);
        $('#inv-dt').html(0);
        $('#inv-ds').html(0);
        $('#inv-dc').html(0);
        $('#inv-dl').val(0);
        $('#inv-t').html(0);
        $('#inv-d').html(0);
        $('#inv-r').html(0);
    }
}*/

// New  Invoice calculation [02-01-2025]
function invoiceValuation() {
    let inv_amount = parseFloat($('#invoice_amount').val());
    let basic = parseFloat($('#basic').val());
    
    if (inv_amount > 0 && basic > 0) {
        // Calculate SGST and CGST from invoice_amount_before_gst
        let sgst = (inv_amount * $('#sgst').val()) / 100;
        let cgst = (inv_amount * $('#cgst').val()) / 100;
        
        // Invoice Total after adding GST (SGST + CGST)
        let invoice_total = inv_amount + sgst + cgst;
        
        // Calculate TDS for Basic Amount, SGST, and CGST
        let tds = (basic * $('#tds').val()) / 100;
        let tds_sgst = (basic * $('#tds_sgst').val()) / 100;
        let tds_cgst = (basic * $('#tds_cgst').val()) / 100;

        // Calculate Labour Cess from inv_amount
        let labour = parseFloat($('#inv-dl').val());
        if ($('#inv-dl').val() == '') {
            labour = (inv_amount * $('#labour_cess').val()) / 100;
        }

        // Total Deductions
        let total_deductions = tds + tds_sgst + tds_cgst + labour;

        // Total Receivable (Invoice Total - Total Deductions)
        let total_receivable = invoice_total - total_deductions;

        // Updating the HTML elements with the calculated values
        $('#inv-b').html(inv_amount.toFixed(2));
        $('#inv-s').html(sgst.toFixed(2));
        $('#inv-c').html(cgst.toFixed(2));
        $('#inv-dt').html(tds.toFixed(2));
        $('#inv-ds').html(tds_sgst.toFixed(2));
        $('#inv-dc').html(tds_cgst.toFixed(2));
        $('#inv-dl').val(labour.toFixed(2));
        $('#inv-t').html(invoice_total.toFixed(2));
        $('#inv-d').html(total_deductions.toFixed(2));
        $('#inv-r').html(total_receivable.toFixed(2));
    } else {
        // Reset the values if inputs are invalid
        $('#inv-b').html(0);
        $('#inv-s').html(0);
        $('#inv-c').html(0);
        $('#inv-dt').html(0);
        $('#inv-ds').html(0);
        $('#inv-dc').html(0);
        $('#inv-dl').val(0);
        $('#inv-t').html(0);
        $('#inv-d').html(0);
        $('#inv-r').html(0);
    }
}
// Load invoice deductions
function loadDeductions(invoiceId) {
    $.get(WEBROOT + 'invoice/viewDeductions', {'invoice_id': invoiceId}, function(data) {
        $('#invoice-deductions').html(data);
    })
}
// Add invoice deduction
function addInvoiceDeduction(invoiceId) {
    $.get(WEBROOT + 'invoice/addDeduction', {'invoice_id' : invoiceId}, function(data) {
        $('#inv-ded').html(data);
    });
}
// Save invoice deduction
function saveInvoiceDeduction(invoiceId) {
    var params = $('#add-ded').serializeArray();
    $.post(WEBROOT + 'invoice/saveDeduction', params, function(data) {
        $('#inv-ded').html(data);
        loadDeductions(invoiceId);
    })
}
// Edit deduction
function editInvoiceDeduction(id) {
    $.get(WEBROOT + 'invoice/editDeduction', {'id': id}, function(data) {
        $('#inv-ded').html(data);
    });
}
// Update deduction
function updateInvoiceDeduction(invoiceId) {
    var params = $('#edi-ded').serializeArray();
    $.post(WEBROOT + 'invoice/updateDeduction', params, function(data) {
        $('#inv-ded').html(data);
        loadDeductions(invoiceId);
    })
}
// Delete deduction
function deleteInvoiceDeduction(id, invoiceId) {
    if(confirm('Are you sure you want to delete this record?')) {
        $.post(WEBROOT + 'invoice/deleteDeduction', {'id': id, 'invoice_id': invoiceId}, function(data) {
            $('#inv-ded').html(data);
            loadDeductions(invoiceId);
        })
    }
}
// Invoice credits
function loadCredits(invoiceId) {
    $.get(WEBROOT + 'invoice/viewCredits', {'invoice_id': invoiceId}, function(data) {
        $('#invoice-credits').html(data);
    });
}
// Add invoice credit
function addInvoiceCredit(invoiceId) {
    $.get(WEBROOT + 'invoice/addCredit', {'invoice_id': invoiceId}, function(data) {
        $('#inv-cre').html(data);
    });
}
// Save invoice credit
function saveInvoiceCredit(invoiceId) {
    var params = $('#add-cre').serializeArray();
    $.post(WEBROOT + 'invoice/saveCredit', params, function(data) {
        $('#inv-cre').html(data);
        loadCredits(invoiceId);
    });
}
// Edit invoice credit
function editInvoiceCredit(id) {
    $.get(WEBROOT + 'invoice/editCredit', {'id': id}, function(data) {
        $('#inv-cre').html(data);
    });
}
// Update invoice credit
function updateInvoiceCredit(invoiceId) {
    var params = $('#edi-cre').serializeArray();
    $.post(WEBROOT + 'invoice/updateCredit', params, function(data) {
        $('#inv-cre').html(data);
        loadCredits(invoiceId);
    })
}
// Delete invoice deduction
function deleteInvoiceCredit(id, invoiceId) {
    if(confirm('Are you sure you want to delete this record?')) {
        $.post(WEBROOT + 'invoice/deleteCredit', {'id': id, 'invoice_id': invoiceId}, function(data) {
            $('#inv-cre').html(data);
            loadCredits(invoiceId);
        })
    }
}
// Load invoice payments
function loadPayments(invoiceId) {
    $.get(WEBROOT + 'invoice/viewPayments', {'invoice_id': invoiceId}, function(data) {
        $('#invoice-payments').html(data);
    })
}
// Add invoice payment
function addInvoicePayment(invoiceId) {
    $.get(WEBROOT + 'invoice/addPayment', {'invoice_id' : invoiceId}, function(data) {
        $('#inv-pay').html(data);
    });
}
// Save invoice payment
function saveInvoicePayment(invoiceId) {
    var params = $('#add-pay').serializeArray();
    $.post(WEBROOT + 'invoice/savePayment', params, function(data) {
        $('#inv-pay').html(data);
        loadPayments(invoiceId);
    })
}
// Edit payment
function editInvoicePayment(id) {
    $.get(WEBROOT + 'invoice/editPayment', {'id': id}, function(data) {
        $('#inv-pay').html(data);
    });
}
// Update payment
function updateInvoicePayment(invoiceId) {
    var params = $('#edi-pay').serializeArray();
    $.post(WEBROOT + 'invoice/updatePayment', params, function(data) {
        $('#inv-pay').html(data);
        loadPayments(invoiceId);
    })
}
// Delete payment
function deleteInvoicePayment(id, invoiceId) {
    if(confirm('Are you sure you want to delete this record?')) {
        $.post(WEBROOT + 'invoice/deletePayment', {'id': id, 'invoice_id': invoiceId}, function(data) {
            $('#inv-pay').html(data);
            loadPayments(invoiceId);
        })
    }
}
// Invoice module add file
function invModAddFile(t, id, invMod) {
    // Toggle back if multiple add buttons were clicked
    if($('#add-inv-mod-file').length > 0) {
        $('.fl-btn').click();
    }
    var adBtn = $(t).parent().html();
    var clBtn = $('<button></button>').click(function() { $('#add-inv-mod-file').parent().html(adBtn); }).addClass('btn btn-sm btn-danger fl-btn').html('<i class="bi bi-x-lg"></i>');
    $.get(WEBROOT + 'invoice/addModFile', {'id': id, 'inv_mod': invMod}, function(data) {
        $(t).parent().html(data);
        $('#add-inv-mod-file').append(clBtn);
    })
}
// Invoice module save file
function invModSaveFile(t) {
    $.ajax({
        url: WEBROOT + 'invoice/saveModFile',
        type: "POST",
        data: new FormData(document.forms['add_inv_file']),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            $(t).parent().parent().html(data);
        },
    });
}
// Invoice module delete file
function invModDeleteFile(t, id, invMod) {
    if(confirm('Are you sure, you want to delete file?')) {
        $.post(WEBROOT + 'invoice/deleteModFile', {'id': id, 'inv_mod': invMod}, function(data) {
            $(t).parent().html(data);
        });
    }
}
// Upload Documnets for invoice
function uploadInvoiceFile(id) {
    $.ajax({
        url: WEBROOT + 'invoice/createFile',
        type: "POST",
        data: new FormData(document.forms['add_file']),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            $('#invoice-docs').html(data);
        },
    });
}

// Delete one document of invoice
function  deleteInvFile(fileId, invoiceId) {
    if(confirm('Are you sure, you want to delete file?')) {
        $.post(WEBROOT + 'invoice/deleteFile', {'id': fileId, 'invoice_id' : invoiceId}, function(data) {
            $('#invoice-docs').html(data);
        });
    }
}

function exportInvoices(sort_by, sort_order) {
        var project = $('#inv-proj').val();
        var client = $('#inv-client').val();
        var type = $('#inv-type').val();
        var payment_status = $('#payment_status').val();

    window.location = WEBROOT + "invoice/InvoicesExportsXls?sort_column=" + sort_by + 
                      "&sort_order=" + sort_order + 
                      "&key=" + $('#key').val() +
                      "&inv_proj=" + project +
                      "&inv_client=" + client +
                      "&inv_type=" + type +
                      "&payment_status=" + payment_status;

    }