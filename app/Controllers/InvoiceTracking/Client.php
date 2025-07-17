<?php

namespace App\Controllers\InvoiceTracking;

use App\Controllers\BaseController;

/**
 *  Client Controller
 */
class Client extends BaseController
{
	private $clientModel;
	private $projectModel;
	private $invoiceModel;
	private $locationModel;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->clientModel = model('App\Models\InvoiceTracking\ClientModel');
		$this->projectModel = model('App\Models\InvoiceTracking\ProjectModel');
		$this->invoiceModel = model('App\Models\InvoiceTracking\InvoiceModel');
		$this->locationModel = model('App\Models\InvoiceTracking\LocationModel');
	}

	/**
	 * Default function
	 */
	public function index() : string
	{
		$data['params'] = array('rows' => 20, 'pageno' => 1, 'sortby' => 'created_at', 'sort_order' => 'desc', 'keywords' => '');
		$data['clients'] = $this->clientModel->orderBy($data['params']['sortby'], $data['params']['sort_order'])->findAll();
		
		$data['page'] = array(
			'title' => 'Client',
			'page_title' => 'Client',
			'js' => ['client', 'freeze-table'],
		);
		return view('invoice_tracking/client/client', $data);
	}

	/**
	 * Client Body Function
	 */
	public function clientBody() : string
	{
		$data['params'] = $this->request->getPost();
		if (isset($data['params']['keywords']) && !empty($data['params']['keywords'])) {
			$data['clients'] = $this->clientModel->like('name', $data['params']['keywords'])->orderBy($data['params']['sortby'], $data['params']['sort_order'])->findAll();
		}
		else {
			$data['clients'] = $this->clientModel->orderBy($data['params']['sortby'], $data['params']['sort_order'])->findAll();
		}

		return view('invoice_tracking/client/client_body', $data);
	}

	/**
	 *	Add anew client 
	 */
	public function add() : string
	{
		return view('invoice_tracking/client/add_client');
	}

	/**
	 *	Insert a new client  
	 */
	public function create() : string
	{
        if (! $this->validate(['name'  => 'required|trim',])) {
            return view('invoice_tracking/client/add_client', ['validation' => $this->validator,]);
        }
        else {
        	$client_ar = array(
        		'name' => $this->request->getPost('name'),
        		'created_at' => date('Y-m-d H:i:s'),
        	);
        	$insert = $this->clientModel->insert($client_ar);
        	if ($insert) {
        		$data['msg'] = "Record inserted successfully..";
        	}
        	else {
        		$data['msg'] = "Something went wrong, please try again..!";
        	}
        	return view('template/alert_modal', $data);
        }
	}

	/**
	 * Edit a client 
	 */
	public function edit() : string
	{
		$data['client_id'] = $this->request->getPost('id');
		$data['client'] = $this->clientModel->find($data['client_id']);

		return view('invoice_tracking/client/edit_client', $data);
	}

	/**
	 * Update the client  
	 */
	public function update() : string
	{
		if (! $this->validate(['name'  => 'required|trim',])) {
            return view('invoice_tracking/client/edit_client', ['validation' => $this->validator,]);
        }
        else {
        	$id = $this->request->getPost('client_id');
        	$client_ar = array(
        		'name' => $this->request->getPost('name'),
        		'updated_at' => date('Y-m-d H:i:s'),
        	);
        	$update = $this->clientModel->update($id,$client_ar);
        	if ($update) {
        		$data['msg'] = "Record updated successfully..";
        	}
        	else {
        		$data['msg'] = "Something went wrong, please try again..!";
        	}
        	return view('template/alert_modal', $data);
        }
	}

	/**
	 * 	Delete the client 
	 */
	public function delete() : string
	{
		$delete = $this->clientModel->delete($this->request->getPost('id'));
		if ($delete) {
    		$data['msg'] = "Record deleted successfully..";
    	}
    	else {
    		$data['msg'] = "Something went wrong, please try again..!";
    	}
    	return view('template/alert_modal', $data);
	}

	public function dashboard()
	{
		$data['page'] = array(
			'title' => 'Dashboard',
			'page_title' => 'Dashboard',
			'layout' => 1);
		return view('invoice_tracking/dashboard1', $data);
	}

	/**
	 * Client detailed view (projects & invoices)  
	 */
	public function viewDetails($id) : string
	{
		$data['invoices'] = array();
		$data['client'] = $this->clientModel->find($id);
		$projects = $this->projectModel->where('client', $id)->findAll();
		$locations = $this->locationModel->findAll();
		$data['inv_categories'] = $this->invoiceModel->getCategories();
		$client_invoices = $this->invoiceModel->getInvoicesByClient($id);
		$inv_sums = $this->invoiceModel->getSumsByClient($id);

		if (isset($client_invoices) && !empty($client_invoices)) {
			foreach ($client_invoices as $key => $invoice) {
				$data['invoices'][$invoice['inv_category']][] = $invoice;
			}
		}
		if (isset($inv_sums) && !empty($inv_sums)) {
			foreach ($inv_sums as $key => $sums) {
				$data['inv_totals'][$sums['p_id']][$sums['inv_category']] = $sums;
			}
		}
		// print "<pre>"; print_r($data['inv_totals']); print "</pre>";
		/*$invoices = $this->invoiceModel->findAll();
		if (isset($invoices) && !empty($invoices)) {
			foreach ($invoices as $key => $invoice) {
				$data['invoices'][$invoice['inv_category']][] = $invoice;
			}
		}*/

		if (isset($projects) && !empty($projects)) {
			foreach ($projects as $key => $project) {
				$data['projects'][$project['id']] = $project;
			}
		}
		if (isset($locations) && !empty($locations)) {
			foreach ($locations as $key => $location) {
				$data['locations'][$location['id']] = $location;
			}
		}

		$client_name = (isset($data['client']['name']) && !empty($data['client']['name'])) ? $data['client']['name'] : ""; 

		$data['page'] = array(
			'title' => 'Client view',
			'page_title' => 'Client Details',
			'js' => ['client','invoice', 'project', 'freeze-table'],
			'breadcrumb' => [['name' => 'Clients', 'url' => 'client']],
		);
		return view('invoice_tracking/client/client_detailed_view', $data);

	}

	/**
	 *	View invoices of a project
	 */
	public function viewProjectInvoices() : string
	{
		$data['params'] = $this->request->getPost();
		$data['project'] = $this->projectModel->find($data['params']['project_id']);
		$data['invoices'] = $this->invoiceModel->getInvoicesByProject($data['params']);
		$data['inv_categories'] = $this->invoiceModel->getCategories();

		return view('invoice_tracking/client/project_invoices', $data);
	}
}