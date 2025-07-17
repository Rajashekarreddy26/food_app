/**
 * Bank guarantee module
 */
function bankGauranteeBody(rows, pageno, sortby, sort_order) {
	var str = {
		'rows' : rows,
		'pageno' : pageno,
		'sortby' : sortby,
		'sort_order' : sort_order,
		'keywords' : $('#keywords').val(),
		'exp_status' : $('#exp_status').val(),
		'project' : $('#project_val').val(),
	};
	$.post(WEBROOT+"bankGuarantee/bgBody", str, function(data) {
		$('#bg-body').html(data);
	});
}
// Reset
function refreshBG() {
	$('#keywords').val('');
	$('#exp_status').val('');
	$('#project_val').val('');
	bankGauranteeBody(20, 1, 'project_bg.created_at', 'desc');
}
// Add new BG
function addBG() {
	$.post(WEBROOT+"bankGuarantee/add",function(data) {
		loadModal(data);
	});
}
// Create BG
function submitBg(e) {
    e.preventDefault();
 	var formData = new FormData();
	formData.append("name", $('#name').val());
	formData.append("bg_number", $('#bg_number').val());
	formData.append("bg_bank", $('#bg_bank').val());
	formData.append("bg_amount", $('#bg_amount').val());
	formData.append("project", $('#project').val());
	formData.append("bg_type", $('#bg_type').val());
	formData.append("issue_date", $('#issue_date').val());
	formData.append("valid_date", $('#valid_date').val());
	formData.append("claim_date", $('#claim_date').val());
	formData.append("note", $('#note').val());
	formData.append("bg_file", $('#bg_file').prop('files')[0]);
    $.ajax({
        url: WEBROOT+"bankGuarantee/create",
        type: "POST",
        data:  formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            // console.log(data);
            loadModal(data);
            refreshBG();
        },
    });
}
// Edit BG
function editBG(id) {
	$.post(WEBROOT+"bankGuarantee/edit", {'id' : id}, function(data) {
		loadModal(data);
	});
}
// Update BG
function updateBg(e) {
	e.preventDefault();
	var formData = new FormData();

	formData.append("bg_id", $('#bg_id').val());
	formData.append("name", $('#name').val());
	formData.append("bg_number", $('#bg_number').val());
	formData.append("bg_bank", $('#bg_bank').val());
	formData.append("bg_amount", $('#bg_amount').val());
	formData.append("project", $('#project').val());
	formData.append("bg_type", $('#bg_type').val());
	formData.append("issue_date", $('#issue_date').val());
	formData.append("valid_date", $('#valid_date').val());
	formData.append("claim_date", $('#claim_date').val());
	formData.append("note", $('#note').val());
	formData.append("old_bg_file", $('#old_bg_file').val());
	formData.append("bg_file", $('#bg_file').prop('files')[0]);
    $.ajax({
        url: WEBROOT+"bankGuarantee/update",
        type: "POST",
        data:  formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            // console.log(data);
            loadModal(data);
            refreshBG();
        },
    });
}
// View BG details
function viewBG(id) {
	$.post(WEBROOT+"bankGuarantee/view", {'id' : id}, function(data) {
		loadModal(data);
	});
}
// Delete BG
function deleteBG(id) {
	if (confirm('Are you sure, you want to delete this Bank Guarantee ?')) {
		$.post(WEBROOT+"bankGuarantee/delete", {'id' : id}, function(data) {
			loadModal(data);
			refreshBG();
		});
	}
}
// View history
function viewBgHistory(bgId) {
	$.get(WEBROOT + 'bankGuarantee/viewHistory', {'bg_id': bgId}, function(data) {
		loadModal(data);
	});
}
// Delete history records
function deleteBgHistory(id) {
	if(confirm('Are you sure you want to delete this record?')) {
		$.post(WEBROOT + 'bankGuarantee/deleteHistory', {'id': id}, function(data) {
			loadModal(data);
		});
	}
}