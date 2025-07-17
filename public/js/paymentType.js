//Payment Type Main Functions
function paymentTypeBody(rows, pageno, sort_by, sort_order)
{
	var params = {
		'rows' : rows,
		'pageno' : pageno,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val()
	};
	$.post(WEBROOT + 'paymentType/indexBody',params,function(data){
		$('#payment_types').html(data);
	});
}

//Payment Type Reset Function
function resetPaymentTypeBody()
{
	$('#keywords').val("");
	paymentTypeBody(10,1,'name','asc');
}
//Add Payment Type
function addPaymentType()
{
	$.post(WEBROOT + "paymentType/add",function(data){
		loadModal(data);
	});
}
//To Insert Payment Type
function insertPaymentType()
{
	var params = $('#add_location').serializeArray();
	$.post(WEBROOT + 'paymentType/create',params,function(data){
		loadModal(data);
		resetPaymentTypeBody();
	});
}
//To Edit Payment Type
function editPaymentType(id)
{
	$.get(WEBROOT + 'paymentType/edit',{'id':id},function(data){
		loadModal(data);
	});
}

//To Update Payment Type
function updatePaymentType()
{
	var params = $('#edit_location').serializeArray();
	$.post(WEBROOT + 'paymentType/update',params,function(data){
		loadModal(data);
		resetPaymentTypeBody();
	});
}
//To Delete Payment Type
function deletePaymentType(id)
{
	if(confirm("Are you sure you want to delete the location!")) {
		$.post(WEBROOT + 'paymentType/delete', {'id' : id}, function(data){
			loadModal(data);
			resetPaymentTypeBody();
		});
	}
}