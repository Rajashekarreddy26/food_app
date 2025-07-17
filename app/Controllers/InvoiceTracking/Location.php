<?php 
namespace App\Controllers\InvoiceTracking;
use App\Controllers\BaseController;
/**
 * Locations 
 */
class Location extends BaseController
{
	protected $locationModel;
	public function __construct()
	{
		$this->locationModel = model('App\Models\InvoiceTracking\LocationModel');
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
		$data['locations'] = $this->locationModel->orderBy('name','asc')->findAll();
		$data['tRecords'] = $this->locationModel->countAllResults();
		$data['page'] = array(
            'title' => 'Locations',
            'page_title' => 'Locations',
            'js' => ['location'],
        );
		return view('invoice_tracking/location/locations', $data);
	}

	/**
	 * Index Body
	 */ 
	public function indexBody()
	{
		$data['params'] = $this->request->getPost();
		$data['tRecords'] = $this->locationModel->like('name', $data['params']['keywords'])->countAllResults();
		$data['locations'] = $this->locationModel->like('name', $data['params']['keywords'])->orderBy('name', 'asc')->findAll();
		return view('invoice_tracking/location/locations_body', $data);
	}

	/**
	 * To Add Location
	 */ 
	public function add()
	{
		return view('invoice_tracking/location/location_add');
	}

	/**
	 * To create Location
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
		 		$add_location = $this->locationModel->insert($create_location);
		 		if($add_location) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Inserted");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Inserting");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/location/location_add');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	}

	/**
	 * To Edit Location
	 */ 
	public function edit()
	{
		$id = $this->request->getGet('id');
		$data['location'] = $this->locationModel->find($id);
		return view('invoice_tracking/location/location_edit', $data);
	}

	/**
	 * To Update Location
	 */ 
	public function update()
	{
	 	if($this->request->getPost(csrf_token()) === csrf_hash()) {
	 		$id = $this->request->getPost('id');
		 	$rules = array('name' => ['label' => 'Name', 'rules' => 'required']);
		 	$check = $this->validate($rules);
		 	if($check == TRUE) {
		 		$edit_location = array(
		 			'name' => $this->request->getPost('name'),
		 			'updated_at' => date('Y-m-d H:i'),
		 		);
		 		$update_location = $this->locationModel->update($id,$edit_location);
		 		if($update_location) {
            		$alert = array('color' => 'success', 'msg' => "Successfully Updated");
		 		}
		 		else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Updating");
		 		}
		 	}
		 	else {
		 		return view('invoice_tracking/location/location_edit');
		 	}
	 	}
	 	else {
            $alert = array('color' => 'danger', 'msg' => "Error in Updating!!Please Try Again");
	 	}
	 	return view('template/alert_modal',$alert);
	} 

	/**
	 * To Delete Location
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->locationModel->delete(['id' => $id])) {
            $alert = array('color' => 'success', 'msg' => "Successfully Deleted");
		}
		else {
            $alert = array('color' => 'danger', 'msg' => "Error in Deleting");
		}
		return view('template/alert_modal',$alert);
	}
}