//User Main Functions
function usersBody(rows, pageno, sort_by, sort_order)
{
	var params = {
		'rows' : rows,
		'pageno' : pageno,
		'sort_by' : sort_by,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val()
	};
	$.post(WEBROOT + 'user/indexBody',params,function(data){
		$('#users_body').html(data);
	});
}

//User Reset Function
function resetUsersBody()
{
	$('#keywords').val("");
	usersBody(10,1,'id','desc');
}
//Add User
function addUser()
{
	$.post(WEBROOT + "user/add",function(data){
		loadModal(data);
	});
}
//To Insert User
function insertUser()
{
	var params = $('#add_user').serializeArray();
	$.post(WEBROOT + 'user/create',params,function(data){
		loadModal(data);
		resetUsersBody();
	});
}
//To Edit User
function editUser(id)
{
	$.get(WEBROOT + 'user/edit',{'id':id},function(data){
		loadModal(data);
	});
}

//To Update User
function updateUser()
{
	var params = $('#edit_user').serializeArray();
	$.post(WEBROOT + 'user/update',params,function(data){
		loadModal(data);
		resetUsersBody();
	});
}
//To Delete User
function deleteUser(id)
{
	if(confirm("Are you sure you want to delete the location!")) {
		$.post(WEBROOT + 'user/delete',{'id' : id}, function(data){
			loadModal(data);
			resetUsersBody();
		});
	}
}
//To Reset Password
function resetPassword(id)
{
	if(confirm("Are you sure you want to reset password to 12345678")) {
		$.post(WEBROOT + 'user/resetUserPassword', {'id' : id}, function(data){
			loadModal(data);
			resetUsersBody();
		});
	}
}