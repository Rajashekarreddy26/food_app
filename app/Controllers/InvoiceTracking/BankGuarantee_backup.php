<?php

namespace App\Controllers\InvoiceTracking;

use App\Controllers\BaseController;

/**
 *  Bank Guarantee Controller
 */
class BankGuarantee extends BaseController
{
	private $bankGuaranteeModel;
	private $bgTypeModel;
	private $projectModel;
	private $projectBgHistoryModel;

	public function __construct()
	{
		// Load models
		$this->bankGuaranteeModel = model('App\Models\InvoiceTracking\BankGuaranteeModel');
		$this->bgTypeModel = model('App\Models\InvoiceTracking\BGTypeModel');
		$this->projectModel = model('App\Models\InvoiceTracking\ProjectModel');
		$this->projectBgHistoryModel = model('App\Models\InvoiceTracking\ProjectBgHistoryModel');
	}

	
	/**
	 * Index method
	 */
	public function index() : string
	{
		$data['params'] = array('rows' => 20, 'pageno' => 1, 'sortby' => 'project_bg.created_at', 'sort_order' => 'desc', 'keywords' => '');
		$data['params']['tRecords'] = $this->bankGuaranteeModel->getBankGuaranteesNum($data['params']);
		$data['bank_guarentees'] = $this->bankGuaranteeModel->getBankGuarantees($data['params']);

		$data['page'] = array(
			'title' => 'Bank Guarantees',
			'page_title' => 'Bank Guarantees',
			'js' => ['bank_guarantee', 'freeze-table'],
		);
		return view('invoice_tracking/bank_guarantee/bank_guarantees', $data);
	}
	/**
	 * Bank Guarantee Body function
	 */
	public function bgBody() :string
	{
		$data['params'] = $this->request->getPost();
		$data['params']['tRecords'] = $this->bankGuaranteeModel->getBankGuaranteesNum($data['params']);
		$data['bank_guarentees'] = $this->bankGuaranteeModel->getBankGuarantees($data['params']);

		return view('invoice_tracking/bank_guarantee/bank_guarantees_body', $data);
	}

	/**
	 *	Add new Bank Guarantee 
	 */
	public function add()
	{
		$data['projects'] = $this->projectModel->findAll();
		$data['bg_types'] = $this->bgTypeModel->findAll();
		return view('invoice_tracking/bank_guarantee/add_bank_guarantee', $data);
	}

	/**
	 * Insert new Bank Guarantee
	 */
	public function create()
	{
		$validationRule = [
            'name' => ['label' => 'Name', 'rules' => 'required|trim'],
            'bg_number' => ['label' => 'BG Number', 'rules' => 'required|alpha_numeric|trim|is_unique[project_bg.bg_number]'],
            'bg_bank' => ['label' => 'Bank Name', 'rules' => 'required|trim'],
            'bg_amount' => ['label' => 'BG Amount', 'rules' => 'required|numeric|greater_than[0]|trim'],
            'project' => ['label' => 'Project', 'rules' => 'required'],
            'bg_type' => ['label' => 'BG Type', 'rules' => 'required'],
            'issue_date' => ['label' => 'BG Issue Date', 'rules' => 'required'],
            'valid_date' => ['label' => 'BG Valid Date', 'rules' => 'required'],
            'claim_date' => ['label' => 'BG Claim Date', 'rules' => 'required'],
            'note' => ['label' => 'Note', 'rules' => 'required|trim'],
            'bg_file' => [
            	'label' => 'BG File',
                'rules' => ['uploaded[bg_file]', 'ext_in[bg_file,pdf,docx,doc,png,jpg]', 'max_size[bg_file,2048]', ],
            ],
        ];
        if (! $this->validate($validationRule)) {
        	$data['validation'] = $this->validator;
			$data['projects'] = $this->projectModel->findAll();
			$data['bg_types'] = $this->bgTypeModel->findAll();
           return view('invoice_tracking/bank_guarantee/add_bank_guarantee', $data);
        }
        else {
        	$file_upload = $this->request->getFile('bg_file');
        	$fileName = '';
            if($file_upload->isValid()) {
                $fileName = $file_upload->getRandomName();
                $file_upload->move(DOCUMENTROOT . 'files/bank_guarantee/', $fileName);
            }
            $bg_insert = array(
            	'type' => $this->request->getPost('bg_type'),
            	'name' => $this->request->getPost('name'),
            	'bg_number' => $this->request->getPost('bg_number'),
            	'bg_bank' => $this->request->getPost('bg_bank'),
            	'bg_amount' => $this->request->getPost('bg_amount'),
            	'project_id' => $this->request->getPost('project'),
            	'issue_date' => date('Y-m-d', strtotime($this->request->getPost('issue_date'))),
            	'valid_date' => date('Y-m-d', strtotime($this->request->getPost('valid_date'))),
            	'claim_date' => date('Y-m-d', strtotime($this->request->getPost('claim_date'))),
            	'bg_file' => $fileName,
            	'note' => $this->request->getPost('note'),
            	'created_by' => $this->session->get('user')['id'],
            );
            $bg_insert_id = $this->bankGuaranteeModel->insert($bg_insert);
            if($bg_insert_id) {
            	// Insert BG history record
            	$bg_insert['bg_id'] = $bg_insert_id;
            	$this->projectBgHistoryModel->insert($bg_insert);
            	
                $data = ['msg' => 'New BG added successfully!', 'color' => 'success'];
            }
            else {
            	$data = ['msg' => 'Failed to add BG!', 'color' => 'danger'];
            }

            return view('template/alert_modal', $data);
        }
	}

	/**
	 * Edit a Bank Guarantee 
	 */
	public function edit()
	{
		$data['bg_id'] = $this->request->getPost('id');
		$data['bank_guarantee'] = $this->bankGuaranteeModel->find($data['bg_id']);
		$data['projects'] = $this->projectModel->findAll();
		$data['bg_types'] = $this->bgTypeModel->findAll();

		return view('invoice_tracking/bank_guarantee/edit_bank_guarantee', $data);
	}

	/**
	 * Update a Bank Guarantee 
	 */
	public function update()
	{	
		$validationRule = [
            'name' => ['label' => 'Name', 'rules' => 'required|trim'],
            'bg_number' => ['label' => 'BG Number', 'rules' => 'required|alpha_numeric|trim'],
            'bg_bank' => ['label' => 'Bank Name', 'rules' => 'required|trim'],
            'bg_amount' => ['label' => 'BG Amount', 'rules' => 'required|numeric|greater_than[0]|trim'],
            'project' => ['label' => 'Project', 'rules' => 'required'],
            'bg_type' => ['label' => 'BG Type', 'rules' => 'required'],
            'issue_date' => ['label' => 'BG Issue Date', 'rules' => 'required'],
            'valid_date' => ['label' => 'BG Valid Date', 'rules' => 'required'],
            'claim_date' => ['label' => 'BG Claim Date', 'rules' => 'required'],
            'note' => ['label' => 'Note', 'rules' => 'required|trim'],
        ];
        if ($this->request->getFile('bg_file')) {
        	$validationRule['bg_file'] = [
            	'label' => 'BG File',
                'rules' => ['uploaded[bg_file]','mime_in[bg_file,image/jpeg,image/jpg,image/png,application/pdf,application/docx,application/doc]', 'max_size[bg_file,2048]', ],
            ];
        }
        if (! $this->validate($validationRule)) {
        	$data['validation'] = $this->validator;
        	$data['params'] = $this->request->getPost();
			$data['projects'] = $this->projectModel->findAll();
			$data['bg_types'] = $this->bgTypeModel->findAll();
           return view('invoice_tracking/bank_guarantee/edit_bank_guarantee', $data);
        }
        else {
        	$file_upload = $this->request->getFile('bg_file');
        	$fileName = "";
        	if ($this->request->getFile('bg_file')) {
	            if($file_upload->isValid()) {
	            	// get the bg previous file and delete the file in assets folder.
	            	$bg_old_file = $this->bankGuaranteeModel->find($this->request->getPost('bg_id'));
	            	if (isset($bg_old_file) && $bg_old_file['bg_file'] != "") {
	            		unlink(DOCUMENTROOT . "files/bank_guarantee/".$bg_old_file['bg_file']);
	            	}
	            	// Upload New file to file directory.
	                $fileName = $file_upload->getRandomName();
	                $file_upload->move(DOCUMENTROOT . "files/bank_guarantee/", $fileName);
	            }
            }
            $bg_id = $this->request->getPost('bg_id');
            $bg_insert = array(
            	'type' => $this->request->getPost('bg_type'),
            	'name' => $this->request->getPost('name'),
            	'bg_number' => $this->request->getPost('bg_number'),
            	'bg_bank' => $this->request->getPost('bg_bank'),
            	'bg_amount' => $this->request->getPost('bg_amount'),
            	'project_id' => $this->request->getPost('project'),
            	'issue_date' => date('Y-m-d', strtotime($this->request->getPost('issue_date'))),
            	'valid_date' => date('Y-m-d', strtotime($this->request->getPost('valid_date'))),
            	'claim_date' => date('Y-m-d', strtotime($this->request->getPost('claim_date'))),
            	'note' => $this->request->getPost('note'),
            	'updated_by' => $this->session->get('user')['id'],
            );
            if (isset($fileName) and $fileName != "") {
	            $file_ar = array('bg_file' => $fileName);
	            $bg_insert = array_merge($bg_insert, $file_ar);
            }
            if($this->bankGuaranteeModel->update($bg_id, $bg_insert)) {
            	// Add BG history
            	$bg_insert['bg_id'] = $bg_id;
            	$this->projectBgHistoryModel->insert($bg_insert);
                $data = ['msg' => 'BG updated successfully!', 'color' => 'success'];
            }
            else {
            	$data = ['msg' => 'Failed to update BG!', 'color' => 'danger'];
            }

            return view('template/alert_modal', $data);
        }
	}

	public function view()
	{
		$data['bg_id'] = $this->request->getPost('id');
		$data['bank_guarantee'] = $this->bankGuaranteeModel->getBgById($data['bg_id']);

		return view('invoice_tracking/bank_guarantee/view_bank_guarantee', $data);
	}

	public function delete()
	{
		$bg_id = $this->request->getPost('id');

		$bg_delete = $this->bankGuaranteeModel->delete($bg_id);
		if ($bg_delete) {
			$data['msg'] = "Bank Guarantee deleted successfully!.";
		}
		else {
			$data['msg'] = "Something error occured, try again";
		}
		return view('template/alert_modal', $data);
	}

	/**
	 * View BG history
	 */
	public function viewHistory() : string
	{
		$bg_id = $this->request->getGet('bg_id');
		$data['bg_history_data'] = $this->projectBgHistoryModel->where(['bg_id' => $bg_id])->orderBy('created_at', 'DESC')->findAll();

		return view('invoice_tracking/bank_guarantee/view_bg_history', $data);
	}

	/**
	 * Delete BG history
	 */
	public function deleteHistory() : string
	{
		$id = $this->request->getPost('id');
		if($this->projectBgHistoryModel->delete($id)) {
			$data = ['msg' => 'Record deleted successfully!', 'color' => 'success'];
		}
		else {
			$data = ['msg' => 'Failed to delete the record', 'color' => 'danger'];
		}
		return view('template/alert_modal', $data);
	}
}