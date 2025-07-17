<?php 
namespace App\Controllers\InvoiceTracking;
use App\Controllers\BaseController;
/**
 * Locations 
 */
class BankGuaranteeType extends BaseController
{
	protected $bgTypeModel;
	public function __construct()
	{
		$this->bgTypeModel = model('App\Models\InvoiceTracking\BGTypeModel');
	}

	/**
	 * To get the Total Locations
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
		$data['bg_types'] = $this->bgTypeModel->orderBy('name','asc')->findAll();
		$data['tRecords'] = $this->bgTypeModel->countAllResults();
		$data['page'] = array(
            'title' => 'Bank Gaurantee Types',
            'page_title' => 'Bank Gaurantee Types',
            'js' => ['bgType'],
        );
		return view('invoice_tracking/bg_types/bg_types', $data);
	}

	/**
	 * Index Body
	 */ 
	public function indexBody()
	{
		$data['params'] = $this->request->getPost();
		$data['tRecords'] = $this->bgTypeModel->like('name', $data['params']['keywords'])->countAllResults();
		$data['bg_types'] = $this->bgTypeModel->like('name', $data['params']['keywords'])->orderBy('name', 'asc')->findAll();
		return view('invoice_tracking/bg_types/bg_types_body', $data);
	}

	/**
	 * To Add BG Type
	 */ 
	public function add()
	{
		return view('invoice_tracking/bg_types/add_bgType');
	}

	/**
	 * To create BG Type
	 */
	public function create()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$create_location = array(
		 			'name' => $this->request->getPost('name'),
		 			'created_at' => date('Y-m-d H:i'),
		 		);
		 		$add_location = $this->bgTypeModel->insert($create_location);
		 		if($add_location) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Inserted");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Inserting");
		 		}
		 	}
		 	else {
				return view('invoice_tracking/bg_types/add_bgType');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	}

	/**
	 * To Edit BG Type
	 */ 
	public function edit()
	{
		$id = $this->request->getGet('id');
		$data['bg_type'] = $this->bgTypeModel->find($id);
		return view('invoice_tracking/bg_types/edit_bgType', $data);
	}

	/**
	 * To Update BG Type
	 */ 
	public function update()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
	 		$id = $this->request->getPost('id');
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$edit_bg_type = array(
		 			'name' => $this->request->getPost('name'),
		 			'updated_at' => date('Y-m-d H:i'),
		 		);
		 		$update_bg_type = $this->bgTypeModel->update($id,$edit_bg_type);
		 		if($update_bg_type) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Updated");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Updating");
		 		}
		 	}
		 	else {
				return view('invoice_tracking/bg_types/edit_bgType');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Updating!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	} 

	/**
	 * To Delete BG Type
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->bgTypeModel->delete(['id' => $id])) {
            $alert = array('color' => 'success', 'msg' => "Successfully Deleted");
		}
		else {
            $alert = array('color' => 'danger', 'msg' => "Error in Deleting");
		}
		return view('template/alert_modal',$alert);
	}
}