//Locations Main Functions
function locationBody(rows, pageno, sort_by, sort_order)
{
	var params = {
		'rows' : rows,
		'pageno' : pageno,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val()
	};
	$.post(WEBROOT + 'location/indexBody',params,function(data){
		$('#locations_body').html(data);
	});
}

//Location Reset Function
function resetLocationBody()
{
	$('#keywords').val("");
	locationBody(10,1,'name','asc');
}
//Add Location
function addLocation()
{
	$.post(WEBROOT + "location/add",function(data){
		loadModal(data);
	});
}
//To Insert Location
function insertLocation()
{
	var params = $('#add_location').serializeArray();
	$.post(WEBROOT + 'location/create',params,function(data){
		loadModal(data);
		resetLocationBody();
	});
}
//To Edit Location
function editLocation(id)
{
	$.get(WEBROOT + 'location/edit',{'id':id},function(data){
		loadModal(data);
	});
}

//To Update Location
function updateLocation()
{
	var params = $('#edit_location').serializeArray();
	$.post(WEBROOT + 'location/update',params,function(data){
		loadModal(data);
		resetLocationBody();
	});
}
//To Delete Location
function deleteLocation(id)
{
	if(confirm("Are you sure you want to delete the location!")) {
		$.post(WEBROOT + 'location/delete',{'id' : id}, function(data){
			loadModal(data);
			resetLocationBody();
		});
	}
}