// Edit Role Details
function editRoleRights(id)
{
	$.get(WEBROOT + "role/editRole", {'id': id}, function(data){
		loadModal(data);
	});
}

//Update Role Details
function updateRoleRights()
{
	var params = $('#edit_role').serializeArray();
	$.post(WEBROOT + "role/updateRoleRights", params, function(data){
		loadModal(data);
	});
}

// Add Role 
function addRole()
{
	$.post(WEBROOT + "role/addRole", function(data){
		loadModal(data);
	});
}

// Insert Role
function insertRole()
{
	var params = $('#add_role').serializeArray();
	$.post(WEBROOT+"role/insertRole", params, function(data){
		loadModal(data);
	});
}

// Delete Role
function deleteRole(id)
{
	if(confirm("Are You Sure you want to delete the role")){
		$.post(WEBROOT + "role/delete", {'id' : id}, function(data){
			loadModal(data);
		});
	}
}