<?php 
namespace App\Controllers\InvoiceTracking;
use App\Controllers\BaseController;
/**
 * File Types Controller 
 */
class FileType extends BaseController
{
	protected $fileTypeModel;
	public function __construct()
	{
		$this->fileTypeModel = model('App\Models\InvoiceTracking\FileTypeModel');
	}

	/**
	 * To get the Total FileTypes
	 */ 
	public function index()
	{
		$data['params'] = array(
			'rows' => 10,
			'pageno' => 1,
			'sort_by' => 'name',
			'sort_order' => 'asc',
			'keywords' => ''
		);
		$data['file_types'] = $this->fileTypeModel->orderBy('name','asc')->findAll();
		$data['tRecords'] = $this->fileTypeModel->countAllResults();
		$data['page'] = array(
            'title' => 'File Types',
            'page_title' => 'File Types',
            'js' => ['fileType'],
        );
		return view('invoice_tracking/file_types/file_types', $data);
	}

	/**
	 * Index Body
	 */ 
	public function indexBody()
	{
		$data['params'] = $this->request->getPost();
		$data['tRecords'] = $this->fileTypeModel->like('name', $data['params']['keywords'])->countAllResults();
		$data['file_types'] = $this->fileTypeModel->like('name', $data['params']['keywords'])->orderBy('name', 'asc')->findAll();
		return view('invoice_tracking/file_types/file_types_body', $data);
	}

	/**
	 * To Add File Type
	 */ 
	public function add()
	{
		return view('invoice_tracking/file_types/file_type_add');
	}

	/**
	 * To create File Type
	 */
	public function create()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$create_file_type = array(
		 			'name' => $this->request->getPost('name'),
		 			'created_at' => date('Y-m-d H:i'),
		 		);
		 		$add_file_type = $this->fileTypeModel->insert($create_file_type);
		 		if($add_file_type) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Inserted");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Inserting");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/file_types/file_type_add');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	}

	/**
	 * To Edit File Type
	 */ 
	public function edit()
	{
		$id = $this->request->getGet('id');
		$data['file_type'] = $this->fileTypeModel->find($id);
		return view('invoice_tracking/file_types/file_type_edit', $data);
	}

	/**
	 * To Update File Type
	 */ 
	public function update()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
	 		$id = $this->request->getPost('id');
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$edit_file_type = array(
		 			'name' => $this->request->getPost('name'),
		 			'updated_at' => date('Y-m-d H:i'),
		 		);
		 		$update_file_type = $this->fileTypeModel->update($id,$edit_file_type);
		 		if($update_file_type) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Updated");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Updating");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/file_types/file_type_edit');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Updating!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	} 

	/**
	 * To Delete File Type
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->fileTypeModel->delete(['id' => $id])) {
            $alert = array('color' => 'success', 'msg' => "Record Deleted Successfully");
		}else {
            $alert = array('color' => 'danger', 'msg' => "Error in Deleting!");
		}
		return view('template/alert_modal', $alert);
	}
}