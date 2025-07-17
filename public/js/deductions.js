//Deduction Main Functions
function deductionBody(rows, pageno, sort_by, sort_order)
{
	var params = {
		'rows' : rows,
		'pageno' : pageno,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val()
	};
	$.post(WEBROOT + 'deduction/indexBody',params,function(data){
		$('#deductions_body').html(data);
	});
}

//Deduction Reset Function
function resetDeductionBody()
{
	$('#keywords').val("");
	deductionBody(10,1,'name','asc');
}
//Add Deduction
function addDeduction()
{
	$.post(WEBROOT + "deduction/add",function(data){
		loadModal(data);
	});
}
//To Insert Deduction
function insertDeduction()
{
	var params = $('#add_deduction').serializeArray();
	$.post(WEBROOT + 'deduction/create',params,function(data){
		loadModal(data);
		resetDeductionBody();
	});
}
//To Edit Deduction
function editDeduction(id)
{
	$.get(WEBROOT + 'deduction/edit',{'id':id},function(data){
		loadModal(data);
	});
}

//To Update Deduction
function updateDeduction()
{
	var params = $('#edit_deduction').serializeArray();
	$.post(WEBROOT + 'deduction/update',params,function(data){
		loadModal(data);
		resetDeductionBody();
	});
}
//To Delete Deduction
function deleteDeduction(id)
{
	if(confirm("Are you sure you want to delete the location!")) {
		$.post(WEBROOT + 'deduction/delete',{'id' : id}, function(data){
			loadModal(data);
			resetDeductionBody();
		});
	}
}