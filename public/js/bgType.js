//BG Type Main Functions
function bgTypeBody(rows, pageno, sort_by, sort_order)
{
	var params = {
		'rows' : rows,
		'pageno' : pageno,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val()
	};
	$.post(WEBROOT + 'bankGuaranteeType/indexBody',params,function(data){
		$('#bg_types_body').html(data);
	});
}

//BG Type Reset Function
function resetBGTypeBody()
{
	$('#keywords').val("");
	bgTypeBody(10,1,'name','asc');
}
//Add BG Type
function addBGType()
{
	$.post(WEBROOT + "bankGuaranteeType/add",function(data){
		loadModal(data);
	});
}
//To Insert BG Type
function insertBGType()
{
	var params = $('#add_bgType').serializeArray();
	$.post(WEBROOT + 'bankGuaranteeType/create',params,function(data){
		loadModal(data);
		resetBGTypeBody();
	});
}
//To Edit BG Type
function editBGType(id)
{
	$.get(WEBROOT + 'bankGuaranteeType/edit',{'id':id},function(data){
		loadModal(data);
	});
}

//To Update BG Type
function updateBGType()
{
	var params = $('#edit_bgType').serializeArray();
	$.post(WEBROOT + 'bankGuaranteeType/update',params,function(data){
		loadModal(data);
		resetBGTypeBody();
	});
}
//To Delete BG Type
function deleteBGType(id)
{
	if(confirm("Are you sure you want to delete the location!")) {
		$.post(WEBROOT + 'bankGuaranteeType/delete',{'id' : id}, function(data){
			loadModal(data);
			resetBGTypeBody();
		});
	}
}