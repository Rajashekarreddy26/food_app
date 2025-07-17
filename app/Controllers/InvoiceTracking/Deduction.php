<?php 
namespace App\Controllers\InvoiceTracking;
use App\Controllers\BaseController;
/**
 * Deductions Controller 
 */
class Deduction extends BaseController
{
	protected $deductionModel;
	public function __construct()
	{
		$this->deductionModel = model('App\Models\InvoiceTracking\DeductionModel');
	}

	/**
	 * To get the Total Deductions
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
		$data['deductions'] = $this->deductionModel->orderBy('name','asc')->findAll();
		$data['tRecords'] = $this->deductionModel->countAllResults();
		$data['page'] = array(
            'title' => 'Deductions',
            'page_title' => 'Deductions',
            'js' => ['deductions'],
        );
		return view('invoice_tracking/deductions/deductions', $data);
	}

	/**
	 * Index Body
	 */ 
	public function indexBody()
	{
		$data['params'] = $this->request->getPost();
		$data['tRecords'] = $this->deductionModel->like('name', $data['params']['keywords'])->countAllResults();
		$data['deductions'] = $this->deductionModel->like('name', $data['params']['keywords'])->orderBy('name', 'asc')->findAll();
		return view('invoice_tracking/deductions/deductions_body', $data);
	}

	/**
	 * To Add Deduction
	 */ 
	public function add()
	{
		return view('invoice_tracking/deductions/deduction_add');
	}

	/**
	 * To create Deduction
	 */
	public function create()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$create_deduction = array(
		 			'name' => $this->request->getPost('name'),
		 			'created_at' => date('Y-m-d H:i'),
		 		);
		 		$add_deduction = $this->deductionModel->insert($create_deduction);
		 		if($add_deduction) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Inserted");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Inserting");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/deductions/deduction_add');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	}

	/**
	 * To Edit Deduction
	 */ 
	public function edit()
	{
		$id = $this->request->getGet('id');
		$data['deduction'] = $this->deductionModel->find($id);
		return view('invoice_tracking/deductions/deduction_edit', $data);
	}

	/**
	 * To Update Deduction
	 */ 
	public function update()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
	 		$id = $this->request->getPost('id');
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$edit_deduction = array(
		 			'name' => $this->request->getPost('name'),
		 			'updated_at' => date('Y-m-d H:i'),
		 		);
		 		$update_deduction = $this->deductionModel->update($id,$edit_deduction);
		 		if($update_deduction) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Updated");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Updating");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/deductions/deduction_edit');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Updating!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	} 

	/**
	 * To Delete Deduction
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->deductionModel->delete(['id' => $id])) {
			$alert = array('color' => 'success', 'msg' => 'Record deleted Successfully');
		}else {
			$alert = array('color' => 'danger', 'msg' => 'Error in deleting!');
		}
		return view('template/alert_modal', $alert);
	}
}