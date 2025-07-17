//Body Page Functions
function projectsBody(rows,pageno,sortby,sort_order)
{
    var params = {
        'rows':rows,
        'pageno':pageno,
        'sortby':sortby,
        'sort_order':sort_order,
        'keywords' : $('#keywords').val(),
        'loc_ext' : $('#loc_ext').val(),
        'client_ext' : $('#client_ext').val(),
        'complete_date' : $('#complete_date').val(),
        'extens_date' : $('#extens_date').val(),
        'code_ext' : $('#code_ext').val(),
        'name_ext' : $('#name_ext').val(),
    };
    $.post(WEBROOT + 'project/indexBody',params,function(data){
        $('#projects_body').html(data);
    })
}  
//To Reset the body page
function resetProjectsBody() {
    $('#keywords').val("");
    $('#loc_ext').val("");
    $('#client_ext').val("");
    $('#complete_date').val("");
    $('#extens_date').val("");
    $('#code_ext').val("");
    $('#name_ext').val("");
    projectsBody(10,1,'code','asc');
}

//to Add
function addProject()
{
    $.post(WEBROOT + 'project/add',function(data){
      loadModal(data);
    });
}

//To Insert Project
function insertProject()
{
    var params = $('#add_project').serializeArray();
    $.post(WEBROOT + 'project/create',params,function(data){
        resetProjectsBody();
        loadModal(data);
    });
}
//To Edit Project
function editProject(id)
{
    $.get(WEBROOT + "project/edit/"+id,function(data){
        loadModal(data);
    });
}

//To Update Project
function updateProject()
{
    var params = $('#edit_project').serializeArray();
    $.post(WEBROOT + "project/update",params,function(data){
        resetProjectsBody();
        loadModal(data);
    });
}

//To Delete Project
function deleteProject(id)
{
    if(confirm("Are you sure You want to delete")){
        $.post(WEBROOT + 'project/delete',{'id':id},function(data){
            loadModal(data);
            resetProjectsBody();
        });
    }
}
//To View Project Details
function viewProject(id)
{
    $.get(WEBROOT + 'project/view',{'id':id},function(data){
        loadModal(data);
    });
}

//Calculations of Total Project in Crores
function calculateINR()
{
    var con_val_inr = con_val = ex_val = conv_inr = tot_inr = tot_cnr = 0;
    con_val_inr = $('#contract_val_inr').val();
    con_val = $('#contract_val').val();
    ex_val = $('#ex_rate').val();
    if(con_val_inr >= 0 || con_val >= 0) {
        conv_inr = parseFloat(ex_val*con_val);
        tot_inr = parseFloat(conv_inr)+parseFloat(con_val_inr);
        tot_cnr = parseFloat(tot_inr/10000000);
        if(isNaN(conv_inr)) {
            $('#con_inr').html(0);
        }else {
            $('#con_inr').html(conv_inr.toFixed(2));
        }
        if(isNaN(tot_inr)) {
            $('#tot_inr').html(0);
            $('#tot_cr').html(0);
        }else {
            $('#tot_inr').html(tot_inr.toFixed(2));
            $('#tot_cr').html(tot_cnr.toFixed(2));
        }
    }else {
        $('#con_inr').html(0);
        $('#tot_inr').html(0);
        $('#tot_cr').html(0);
    }
}

// Project file Upload
// function uploadFile() {
//     $.ajax({
//         url: WEBROOT + 'project/uploadFile',
//         type: "POST",
//         data:  new FormData(document.forms['add-proj-fil']),
//         contentType: false,
//         cache: false,
//         processData: false,
//         success: function(data){
//             $('#file_upload_body').html(data);
//         },
//     });
// }

// File Upload
function uploadProjectFile()
{
    var form_data = new FormData();
    form_data.append('project_id',$('#project_id').val());
    form_data.append('file_type',$('#file_type').val());
    form_data.append('file',$('#file').prop('files')[0]);
    $.ajax({
        url: WEBROOT + 'project/addProjectFile',
        type: "POST",
        data:  form_data,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            $('#file_upload_body').html(data);
        },
    });
}
// To Delete a File
function deleteProjectFile(id) {
    if(confirm("Are you sure You want to delete the file")) {
        $.post(WEBROOT + "project/deleteProjectFile",{'id' : id}, function(data){
            $('#pf'+id).remove();
        });
    }
}

// To Print the Projects Data
/*function projectTablePrint(elementId) {
  var restoreBody = $('body').html();
  $('body').html($('#'+ elementId).html());
  window.print();
  $('body').html(restoreBody);
}*/
function projectTablePrint(elementId) {
  var printContent = $('#' + elementId).html(); // Get the HTML content of the specified element

  // Open a new window/tab
  var newWindow = window.open('', '_blank');
  
  // Write the HTML content to the new window/tab
  newWindow.document.write('<html><head><title>Invoice Tracking</title></head><body>');
  newWindow.document.write(printContent); // Write the table HTML content
  newWindow.document.write('</body></html>');
  
  // Print the new window/tab
  newWindow.document.close(); // Close the document for writing
  newWindow.print(); // Trigger the print dialog

  // Clean up: restore the original body content after printing
  newWindow.onafterprint = function() {
    newWindow.close(); // Close the new window/tab after printing
  };
}

// To Export the Projects
function exportProject(rows, page, sort_by, sort_order) {
    let location = $('#loc_ext').val();
    let client = $('#client_ext').val();
    let keywords = $('#keywords').val();
    let completion_date = $('#complete_date').val();
    let extension_date = $('#extens_date').val();
    let code = $('#code_ext').val();
    let name = $('#name_ext').val();

    let params = $.param({
        rows: rows,
        page: page,
        sort_by: sort_by,
        sort_order: sort_order,
        loc_ext: location,
        client_ext: client,
        keywords: keywords,
        complete_date: completion_date,
        extens_date: extension_date,
        code_ext: code,
        name_ext: name,
    });

    window.location = WEBROOT + "project/ProjectExportXls?" + params;
}