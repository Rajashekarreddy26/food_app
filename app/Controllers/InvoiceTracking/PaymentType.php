<?php 
namespace App\Controllers\InvoiceTracking;
use App\Controllers\BaseController;
/**
 * Payment Types Controller 
 */
class PaymentType extends BaseController
{
	protected $paymentTypeModel;
	public function __construct()
	{
		$this->paymentTypeModel = model('App\Models\InvoiceTracking\PaymentTypeModel');
	}

	/**
	 * To get the Total Payment Types
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
		$data['payment_types'] = $this->paymentTypeModel->orderBy('name','asc')->findAll();
		$data['tRecords'] = $this->paymentTypeModel->countAllResults();
		$data['page'] = array(
            'title' => 'Payment Types',
            'page_title' => 'Payment Types',
            'js' => ['paymentType'],
        );
		return view('invoice_tracking/payment_types/payment_types', $data);
	}

	/**
	 * Index Body
	 */ 
	public function indexBody()
	{
		$data['params'] = $this->request->getPost();
		$data['tRecords'] = $this->paymentTypeModel->like('name', $data['params']['keywords'])->countAllResults();
		$data['payment_types'] = $this->paymentTypeModel->like('name', $data['params']['keywords'])->orderBy('name', 'asc')->findAll();
		return view('invoice_tracking/payment_types/payment_types_body', $data);
	}

	/**
	 * To Add Payment Type
	 */ 
	public function add()
	{
		return view('invoice_tracking/payment_types/payment_type_add');
	}

	/**
	 * To create Payment Type
	 */
	public function create()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$create_payment_type = array(
		 			'name' => $this->request->getPost('name'),
		 			'created_at' => date('Y-m-d H:i'),
		 		);
		 		$add_payment_type = $this->paymentTypeModel->insert($create_payment_type);
		 		if($add_payment_type) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Inserted");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Inserting");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/payment_types/payment_type_add');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	}

	/**
	 * To Edit Payment Type
	 */ 
	public function edit()
	{
		$id = $this->request->getGet('id');
		$data['payment_type'] = $this->paymentTypeModel->find($id);
		return view('invoice_tracking/payment_types/payment_type_edit', $data);
	}

	/**
	 * To Update Payment Type
	 */ 
	public function update()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
	 		$id = $this->request->getPost('id');
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$edit_payment_type = array(
		 			'name' => $this->request->getPost('name'),
		 			'updated_at' => date('Y-m-d H:i'),
		 		);
		 		$update_payment_type = $this->paymentTypeModel->update($id,$edit_payment_type);
		 		if($update_payment_type) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Updated");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Updating");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/payment_types/payment_type_edit');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Updating!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	} 

	/**
	 * To Delete Payment Type
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->paymentTypeModel->delete(['id' => $id])) {
			$alert = array('color' => 'success', 'msg' => 'Record deleted Successfully');
		}else {
			$alert = array('color' => 'danger', 'msg' => 'Error in Deleting!');
		}
		return view('template/alert_modal', $alert);
	}
}