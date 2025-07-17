// Add Module 
function addModule(parent=0)
{
	$.post(WEBROOT + "module/add",{'parent_id' : parent }, function(data){
		loadModal(data);
	});
}

// Insert Module
function insertModule()
{
	var params = $('#add_module').serializeArray();
	$.post(WEBROOT + "module/create", params, function(data){
		loadModal(data);
		resetModules();
	});
}

// Edit Module
function editModule(id)
{
	$.get(WEBROOT + "module/edit", {'id' : id}, function(data) {
		loadModal(data);
	});
}

// Update Module
function updateModule()
{
	var params = $('#edit_module').serializeArray();
	$.post(WEBROOT + "module/update", params, function(data) {
		loadModal(data);
		resetModules();
	});
}

// Delete Module
function deleteModule(id)
{
	if(confirm("Are you sure you want to delete the Module")) {
		$.post(WEBROOT+"module/delete", {'id' : id}, function(data){
			loadModal(data);
			resetModules();
		});
	}
}

// Module Refresh
function resetModules()
{
	$.post(WEBROOT + "module/indexBody", function(data){
		$('#modules_body').html(data);
	});
}

// Change Status of the Module
function changeModuleStatus(id, status)
{
	if(confirm("Are you sure you want to change the status of the Module.")) {
		$.post(WEBROOT + "module/changeModuleStatus", {'id' : id, 'status' : status}, function(data){
			loadModal(data);
			resetModules();
		});
	}
}

// Swapping Module Positions
function changeModulePosition(id,parent,position=0)
{
	if(id > 0) {
		$.post(WEBROOT + "module/changeModulePosition", {'id' : id, 'parent_id' : parent, 'position' : position}, function(data){
			loadModal(data);
			resetModules();
		});
	}else {
		alert("The Above Module Doesn't Exist");
	}
}