//File Type Main Functions
function fileTypeBody(rows, pageno, sort_by, sort_order)
{
	var params = {
		'rows' : rows,
		'pageno' : pageno,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val()
	};
	$.post(WEBROOT + 'fileType/indexBody',params,function(data){
		$('#file_types_body').html(data);
	});
}

//File Type Reset Function
function resetFileTypeBody()
{
	$('#keywords').val("");
	fileTypeBody(10,1,'name','asc');
}
//Add File Type
function addFileType()
{
	$.post(WEBROOT + "fileType/add", function(data){
		loadModal(data);
	});
}
//To Insert File Type
function insertFileType()
{
	var params = $('#add_file_type').serializeArray();
	$.post(WEBROOT + 'fileType/create', params, function(data){
		loadModal(data);
		resetFileTypeBody();
	});
}
//To Edit File Type
function editFileType(id)
{
	$.get(WEBROOT + 'fileType/edit', {'id':id}, function(data){
		loadModal(data);
	});
}

//To Update File Type
function updateFileType()
{
	var params = $('#edit_file_type').serializeArray();
	$.post(WEBROOT + 'fileType/update', params, function(data){
		loadModal(data);
		resetFileTypeBody();
	});
}
//To Delete File Type
function deleteFileType(id)
{
	if(confirm("Are you sure you want to delete the location!")) {
		$.post(WEBROOT + 'fileType/delete', {'id' : id}, function(data){
			loadModal(data);
			resetFileTypeBody();
		});
	}
}