/**
 * Reports JS
 */
// Payment Report JS Functions
function paymentReportBody(rows, pageno, sort_by, sort_order) {
	var params = {
		'rows' : rows,
		'page_no' : pageno,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val(),
		'project_ext' : $('#project_ext').val(),
		'client_ext' : $('#client_ext').val(),
		'invoice_number' : $('#invoice_number').val(),
		'pay_type_ext' : $('#pay_type_ext').val(),
		'file_payment' : $('#file_payment').val(),
	}
	$.post(WEBROOT + "reports/invoicePaymentsBody", params, function(data) {
		$('#payment_reports_body').html(data);
	});
}
// Reset Payment Report Body
function resetPaymentReportBody() {
	$('#keywords').val("");
	$('#pay_type_ext').val("");
	$('#project_ext').val("");
	$('#client_ext').val("");
	$('#invoice_number').val("");
	$('#file_payment').val("");
	paymentReportBody(20,1,'invoice_payment.created_at','desc')
}

// Invoice Deduction Body Function
function deductionReportBody(rows,page_no,sort_by,sort_order) {
	var params = {
		'rows' : rows,
		'page_no' : page_no,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val(),
		'project_ext' : $('#project_ext').val(),
		'client_ext' : $('#client_ext').val(),
		'invoice_number' : $('#invoice_number').val(),
		'ded_type_ext' : $('#ded_type_ext').val(),
		'file_payment' : $('#file_payment').val(),
	}
	$.post(WEBROOT + "reports/invoiceDeductionsBody", params, function(data){
		$('#deductions_report_body').html(data);
	});
}
// Invoice Deduction Reset Report Body
function resetDeductionBody() {
	$('#keywords').val("");
	$('#project_ext').val("");
	$('#client_ext').val("");
	$('#invoice_number').val("");
	$('#ded_type_ext').val("");
	$('#file_payment').val("");
	deductionReportBody(20,1,'invoice_deduction.created_at','desc');
}