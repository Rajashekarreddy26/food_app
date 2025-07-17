function  clientBody(rows, pageno, sortby, sort_order) {
	var params = {
		'rows' : rows,
		'pageno' : pageno,
		'sortby' : sortby,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val(),
	}
	$.post(WEBROOT+'client/clientBody', params, function(data) {
		$('#client_body').html(data);
	});
}
function resetClientBody() {
	$('#keywords').val('');
	clientBody(20,1,'created_at','desc');
}
function addClient() {
	$.post(WEBROOT+"client/add", function(data){
		loadModal(data);
	});
}

function clientInsert(e) {
	e.preventDefault()
	var params = $('#client_add_form').serializeArray();
	$.post(WEBROOT+"client/create", params, function(data) {
		// $('.modal-dialog').parent().html(data);
		resetClientBody();
		loadModal(data);
	});
}

function editClient(id) {
	$.post(WEBROOT+"client/edit",{'id' : id}, function(data){
		loadModal(data);
	});
}

function clientUpdate(e) {
	e.preventDefault()
	var params = $('#client_edit_form').serializeArray();
	$.post(WEBROOT+"client/update", params, function(data) {
		// $('.modal-dialog').parent().html(data);
		resetClientBody();
		loadModal(data);
	});
}

function deleteClient(id) {
	if (confirm('Are you sure, you want to delete this client ?')) {
		$.post(WEBROOT+"client/delete", {'id' : id}, function (data) {
			loadModal(data);
			resetClientBody();
		})
	}
}

function viewProjectInvoices(project_id) {
	var str = {
		'project_id': project_id,
		'inv_category' : $('#pro_inv_category').val(),
	}
	$.post(WEBROOT+"client/viewProjectInvoices", str, function(data){
		loadModal(data);
	});
}