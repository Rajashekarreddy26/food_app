<?php

namespace App\Controllers\InvoiceTracking;

use App\Controllers\BaseController;

/**
 * Invoice controller
 */
class Invoice extends BaseController
{
    private $invoiceModel;
    private $projectModel;
    private $clientModel;
    private $invoiceDeductionModel;
    private $invoiceCreditModel;
    private $invoicePaymentModel;
    private $deductionModel;
    private $paymentTypeModel;
    private $fileTypeModel;
    private $invoiceFileModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Load helper
        helper('utils');
        // Load & Assign models
        $this->invoiceModel = model('App\Models\InvoiceTracking\InvoiceModel');
        $this->projectModel = model('App\Models\InvoiceTracking\ProjectModel');
        $this->clientModel = model('App\Models\InvoiceTracking\ClientModel');
        $this->invoiceDeductionModel = model('App\Models\InvoiceTracking\InvoiceDeductionModel');
        $this->invoiceCreditModel = model('App\Models\InvoiceTracking\InvoiceCreditModel');
        $this->invoicePaymentModel = model('App\Models\InvoiceTracking\InvoicePaymentModel');
        $this->deductionModel = model('App\Models\InvoiceTracking\DeductionModel');
        $this->paymentTypeModel = model('App\Models\InvoiceTracking\PaymentTypeModel');
        $this->fileTypeModel = model('App\Models\InvoiceTracking\FileTypeModel');
        $this->invoiceFileModel = model('App\Models\InvoiceTracking\InvoiceFileModel');
    }

    /**
     * Invoice list
     */
    public function index() : string
    {
        // Search, filter, sort and pagenation parameters
        $data['params'] = array(
            'key' => '',
            'page' => 1,
            'rows' => 20,
            'offset' => 0,
            'sort_column' => 'invoice.inv_date',
            'sort_order' => 'ASC',
            'inv_proj' => '',
            'inv_client' => '',
            'inv_type' => '',
            'payment_status' => '',
        );
        
        $data['total_records'] = $this->invoiceModel->getInvoicesCount($data['params']);
        $data['invoices'] = $this->invoiceModel->getInvoices($data['params']);
        $data['invoice_categories'] = $this->invoiceModel->getCategories();
        $data['invoice_clients'] = $this->clientModel->select('id, name')->findAll();
        $data['invoice_projects'] = $this->projectModel->select('id, code, name')->orderBy('code', 'ASC')->findAll();

        // Invoice Item Totals
        $data['totals'] = $this->invoiceModel->getInvoiceTotals($data['params']);

        $data['page'] = array(
            'title' => 'Invoices',
            'page_title' => 'Invoices',
            'js' => ['invoice', 'client', 'freeze-table'],
        );
        return view('invoice_tracking/invoice/invoices', $data);
    }

    /**
     * Invoices body
     */
    public function body()
    {
        // Search, filter, sort and pagenation parameters
        $data['params'] = array(
            'key' => $this->request->getGet('key'),
            'page' => $this->request->getGet('page'),
            'rows' => $this->request->getGet('rows'),
            'offset' => (($this->request->getGet('page') - 1) * $this->request->getGet('rows')),
            'sort_column' => $this->request->getGet('sort_column'),
            'sort_order' => $this->request->getGet('sort_order'),
            'inv_proj' => $this->request->getGet('inv_proj'),
            'inv_client' => $this->request->getGet('inv_client'),
            'inv_type' => $this->request->getGet('inv_type'),
            'payment_status' => $this->request->getGet('payment_status'),
        );
        $data['total_records'] = $this->invoiceModel->getInvoicesCount($data['params']);
        $data['invoices'] = $this->invoiceModel->getInvoices($data['params']);
        // dd($data);
        $data['invoice_categories'] = $this->invoiceModel->getCategories();
        $data['invoice_clients'] = $this->clientModel->select('id, name')->findAll();
        $data['invoice_projects'] = $this->projectModel->select('id, code, name')->orderBy('code', 'ASC')->findAll();

        // Invoice Item Totals
        $data['totals'] = $this->invoiceModel->getInvoiceTotals($data['params']);

        return view('invoice_tracking/invoice/invoices_body', $data);
    }

    /**
     * View invoice details
     */
    public function view() : string
    {
        $data['id'] = $id = $this->request->getGet('id');
        $data['tab_id'] = $this->request->getGet('tab') ? $this->request->getGet('tab') : 1; // Active tab on view
        $data['invoice_data'] = $this->invoiceModel->getInvoiceDetails($id);
        $data['invoice_categories'] = $this->invoiceModel->getCategories();
        $data['invoice_deductions'] = $this->invoiceDeductionModel->getInvoiceDeductions($id);
        $data['invoice_credits'] = $this->invoiceCreditModel->where(['inv_id' => $id])->findAll();
        $data['invoice_payments'] = $this->invoicePaymentModel->getInvoicePayments($id);
        $data['file_types'] = $this->fileTypeModel->findAll();
        $data['invoice_documents'] = $this->invoiceFileModel->getInvoiceFiles($id);
        $data['currencies'] = $this->projectModel->getCurrencies();
        $data['mobil_adv'] = $this->invoiceModel->getMobilizationDetailsView($data['invoice_data']['project_id']);
        return view('invoice_tracking/invoice/view_invoice', $data);
    }

    /**
     * Add invoice
     */
    public function add() : string
    {
        $data['projects'] = $this->projectModel->select('id, code, name')->findAll();
        $data['categories'] = $this->invoiceModel->getCategories();
        $data['currencies'] = $this->projectModel->getCurrencies();

        return view('invoice_tracking/invoice/add_invoice', $data);
    }

    /**
     * To get Mobilization Details to invoice(add)
     */
    public function fetch_mobilization_details()
    {
        $projectId = $this->request->getGet('project');
        
        if ($projectId) {
            // Fetch mobilization details from the model
            $data['mobil_adv'] = $this->invoiceModel->getMobilizationDetails($projectId);
            
            // Check if mobilization details are available
            if ($data['mobil_adv']) {
                // Load the view and pass the data
                return view('invoice_tracking/invoice/mobilizationDetails', $data);
            } else {
                return view('mobilizationDetails');
            }
        } else {
            return view('mobilizationDetails');
        }
    }


    /**
     * Create invoice
     */
    /*public function create()
    {
        // Set form validation rules
        $rules = [
            'project'       => ['label' => 'Project', 'rules' => 'required|is_natural'],
            'category'      => ['label' => 'Category', 'rules' => 'required|is_natural'],
            'inv_number'    => ['label' => 'Invoice Number', 'rules' => 'required|is_unique[invoice.inv_number]'],
            'inv_date'      => ['label' => 'Invoice Date', 'rules' => 'required'],
            'site_ref_no'   => ['label' => 'Site Ref No', 'rules' => 'required'],
            'ra_bill_no'    => ['label' => 'RA BIll No', 'rules' => 'required'],
            'basic'         => ['label' => 'Basic amount', 'rules' => 'required|numeric'],
            'labour'        => ['label' => 'Labour Cess', 'rules' => 'required|numeric'],
        ];
        if($this->validate($rules) == TRUE) {
            $basic = $this->request->getPost('basic');
            $sgst = $basic * (INV_PARAMS['sgst'] / 100);
            $cgst = $basic * (INV_PARAMS['cgst'] / 100);
            $tds = $basic * (INV_PARAMS['tds'] / 100);
            $stds = $basic * (INV_PARAMS['tds_sgst'] / 100);
            $ctds = $basic * (INV_PARAMS['tds_cgst'] / 100);
            // $labour = $basic * (INV_PARAMS['labour_cess'] / 100);
            $labour = $this->request->getPost('labour');
            $totalI = $basic + $sgst + $cgst;
            $totalD = $tds + $stds + $ctds + $labour;

            $insert_data = array(
                'project_id' => $this->request->getPost('project'),
                'inv_category' => $this->request->getPost('category'),
                'inv_number' => $this->request->getPost('inv_number'),
                'inv_date' => date('Y-m-d', strtotime($this->request->getPost('inv_date'))),
                'site_ref_no' => $this->request->getPost('site_ref_no'),
                'ra_bill_no' => $this->request->getPost('ra_bill_no'),
                'basic' => $this->request->getPost('basic'),
                'sgst' => $sgst,
                'cgst' => $cgst,
                'total' => $totalI,
                'tds' => $tds,
                'tds_sgst' => $stds,
                'tds_cgst' => $ctds,
                'labour_cess' => $this->request->getPost('labour'),
                'status' => 1,
                'note' => $this->request->getPost('notes'),
                'created_by' => $this->session->get('user')['id'],
            );
            if($this->invoiceModel->insert($insert_data)) {
                $data['msg'] = 'Invoice added sucessfully!';
            }
            else {
                $data['msg'] = 'Failed to add invoice';
            }
            return view('template/alert_modal', $data);
        }
        else {
            $data['projects'] = $this->projectModel->select('id, code, name')->findAll();
            $data['categories'] = $this->invoiceModel->getCategories();
            return view('invoice_tracking/invoice/add_invoice', $data);
        }
    }*/
    /**
     * Create invoice
     */
    public function create()
    {
        // Set form validation rules
        $rules = [
            'project'               => ['label' => 'Project', 'rules' => 'required|is_natural'],
            'category'              => ['label' => 'Category', 'rules' => 'required|is_natural'],
            'inv_number'            => ['label' => 'Invoice Number', 'rules' => 'required|is_unique[invoice.inv_number]'],
            'inv_date'              => ['label' => 'Invoice Date', 'rules' => 'required'],
            'site_ref_no'           => ['label' => 'Site Ref No', 'rules' => 'required'],
            'ra_bill_no'            => ['label' => 'RA BIll No', 'rules' => 'required'],
            'fx_invoice_amount'     => ['label' => 'Foreign Exchange Invoice Amount', 'rules' => 'required|numeric'],
            'currency'              => ['label' => 'Currency Type', 'rules' => 'required'],
            'ex_rate'               => ['label' => 'Exchange Rate ', 'rules' => 'required|numeric'],
            'invoice_amount'        => ['label' => 'Invoice amount', 'rules' => 'required|numeric'],
            'mobilization_amount'   => ['label' => 'Mobilization Amount', 'rules' => 'required|numeric'],
            // 'basic'                 => ['label' => 'Basic Amount', 'rules' => 'required|numeric'],
            'tax_type'              => ['label' => 'Tax Type', 'rules' => 'required|numeric'],
            // 'labour'                => ['label' => 'Labour Cess', 'rules' => 'required|numeric'],
        ];

        if ($this->validate($rules) === TRUE) {
            $basic = $this->request->getPost('basic');
            $inv_amt = $this->request->getPost('invoice_amount');
            if ($this->request->getPost('tax_type') == 1) {
                $sgst = $inv_amt * (INV_PARAMS['sgst'] / 100);
                $cgst = $inv_amt * (INV_PARAMS['cgst'] / 100);
            } else {
                $sgst = $cgst = 0;
            }
            $tds = $basic * (INV_PARAMS['tds'] / 100);
            $stds = $basic * (INV_PARAMS['tds_sgst'] / 100);
            $ctds = $basic * (INV_PARAMS['tds_cgst'] / 100);
            $labour = $this->request->getPost('labour');
            $totalI = $basic + $sgst + $cgst;
            $totalD = $tds + $stds + $ctds + $labour;

            $insert_data = [
                'project_id'         => $this->request->getPost('project'),
                'inv_category'       => $this->request->getPost('category'),
                'inv_number'         => $this->request->getPost('inv_number'),
                'inv_date'           => date('Y-m-d', strtotime($this->request->getPost('inv_date'))),
                'site_ref_no'        => $this->request->getPost('site_ref_no'),
                'ra_bill_no'         => $this->request->getPost('ra_bill_no'),
                'fx_invoice_amount'  => $this->request->getPost('fx_invoice_amount'),
                'currency'           => $this->request->getPost('currency'),
                'ex_rate'            => $this->request->getPost('ex_rate'),
                'invoice_amount'     => $this->request->getPost('invoice_amount'),
                'mobilization_per'   => $this->request->getPost('mobilization_per'),
                'mobilization_amount'=> $this->request->getPost('mobilization_amount'),
                'basic'              => $this->request->getPost('basic'),
                'tax_type'           => $this->request->getPost('tax_type'),
                'sgst'               => $sgst,
                'cgst'               => $cgst,
                'total'              => $totalI,
                'tds'                => $tds,
                'tds_sgst'           => $stds,
                'tds_cgst'           => $ctds,
                'labour_cess'        => $labour,
                'status'             => 1,
                'note'               => $this->request->getPost('notes'),
                'created_by'         => $this->session->get('user')['id'],
            ];

            if ($this->invoiceModel->insert($insert_data)) {
            // if (true) {
                $projectId = $this->request->getPost('project');
                $mobilizationAmount = $this->request->getPost('mobilization_amount');

                // Fetch the current mobilization advance available
                $currentAvailable = $this->invoiceModel->getMobilizationAdvance($projectId);

                if ($currentAvailable != '') {
                    // Calculate new mobilization advance available
                    $newAvailable = $currentAvailable['mobilization_adv_available'] - $mobilizationAmount;

                    $mobil_ar = array('mobilization_adv_available' => $newAvailable);
                    // Update the new value in the database via the model
                    $this->invoiceModel->updateMobilizationAdvAvailable($projectId, $mobil_ar);
                }

                $data['msg'] = 'Invoice added successfully!';
            } 
            else {
                $data['msg'] = 'Failed to add invoice.';
            }
            return view('template/alert_modal', $data);
        } else {
            $data['projects'] = $this->projectModel->select('id, code, name')->findAll();
            $data['categories'] = $this->invoiceModel->getCategories();
            $data['currencies'] = $this->projectModel->getCurrencies();
            $data['mobil_adv'] = $this->invoiceModel->getMobilizationDetails($this->request->getPost('project'));
            return view('invoice_tracking/invoice/add_invoice', $data);
        }
    }

    /**
     * Edit invoice
     */
    public function edit() : string
    {
        $id = $this->request->getGet('id');

        $data['invoice_data'] = $this->invoiceModel->find($id);
        $data['projects'] = $this->projectModel->select('id, code, name')->findAll();
        $data['categories'] = $this->invoiceModel->getCategories();
        $data['currencies'] = $this->projectModel->getCurrencies();

        // Fetch mobilization details from the model
        $data['mobil_adv'] = $this->invoiceModel->getMobilizationDetails($data['invoice_data']['project_id']);

        return view('invoice_tracking/invoice/edit_invoice', $data);
    }

    /**
     * Update invoice
     */
    /*public function update() : string
    {
        // Set form validation rules
        $rules = [
            'id'            => ['label' => 'Invoice ID', 'rules' => 'required'],
            'project'       => ['label' => 'Project', 'rules' => 'required|is_natural'],
            'category'      => ['label' => 'Category', 'rules' => 'required|is_natural'],
            'inv_number'    => ['label' => 'Invoice Number', 'rules' => 'required|is_unique[invoice.inv_number,id,'.$this->request->getPost('id').']'],
            'inv_date'      => ['label' => 'Invoice Date', 'rules' => 'required'],
            'site_ref_no'   => ['label' => 'Site Ref No', 'rules' => 'required'],
            'ra_bill_no'    => ['label' => 'RA BIll No', 'rules' => 'required'],
            'basic'         => ['label' => 'Basic amount', 'rules' => 'required|numeric'],
            'labour'        => ['label' => 'Labour Cess', 'rules' => 'required|numeric'],
        ];
        $id = $this->request->getPost('id');
        if($this->validate($rules) == TRUE) {
            $basic = $this->request->getPost('basic');
            $sgst = $basic * (INV_PARAMS['sgst'] / 100);
            $cgst = $basic * (INV_PARAMS['cgst'] / 100);
            $tds = $basic * (INV_PARAMS['tds'] / 100);
            $stds = $basic * (INV_PARAMS['tds_sgst'] / 100);
            $ctds = $basic * (INV_PARAMS['tds_cgst'] / 100);
            // $labour = $basic * (INV_PARAMS['labour_cess'] / 100);
            $labour = $this->request->getPost('labour');
            $totalI = $basic + $sgst + $cgst;
            $totalD = $tds + $stds + $ctds + $labour;

            $update_data = array(
                'project_id' => $this->request->getPost('project'),
                'inv_category' => $this->request->getPost('category'),
                'inv_number' => $this->request->getPost('inv_number'),
                'inv_date' => date('Y-m-d', strtotime($this->request->getPost('inv_date'))),
                'site_ref_no' => $this->request->getPost('site_ref_no'),
                'ra_bill_no' => $this->request->getPost('ra_bill_no'),
                'basic' => $this->request->getPost('basic'),
                'sgst' => $sgst,
                'cgst' => $cgst,
                'total' => $totalI,
                'tds' => $tds,
                'tds_sgst' => $stds,
                'tds_cgst' => $ctds,
                'labour_cess' => $this->request->getPost('labour'),
                'status' => 1,
                'note' => $this->request->getPost('notes'),
                'updated_by' => $this->session->get('user')['id'],
            );
            if($this->invoiceModel->update($id, $update_data)) {
                $data['msg'] = 'Invoice updated sucessfully!';
            }
            else {
                $data['msg'] = 'Failed to update invoice!';
            }
            return view('template/alert_modal', $data);
        }
        else {
            $data['invoice_data'] = $this->invoiceModel->find($id);
            $data['projects'] = $this->projectModel->select('id, code, name')->findAll();
            $data['categories'] = $this->invoiceModel->getCategories();
            return view('invoice_tracking/invoice/edit_invoice', $data);
        }
    }*/
    public function update() : string
    {
        // Set form validation rules
        $rules = [
            'id'                    => ['label' => 'Invoice ID', 'rules' => 'required'],
            'project'               => ['label' => 'Project', 'rules' => 'required|is_natural'],
            'category'              => ['label' => 'Category', 'rules' => 'required|is_natural'],
            'inv_number'            => ['label' => 'Invoice Number', 'rules' => 'required|is_unique[invoice.inv_number,id,'.$this->request->getPost('id').']'],
            'inv_date'              => ['label' => 'Invoice Date', 'rules' => 'required'],
            'site_ref_no'           => ['label' => 'Site Ref No', 'rules' => 'required'],
            'ra_bill_no'            => ['label' => 'RA BIll No', 'rules' => 'required'],
            'fx_invoice_amount'     => ['label' => 'Foreign Exchange Invoice Amount', 'rules' => 'required|numeric'],
            'currency'              => ['label' => 'Currency Type', 'rules' => 'required'],
            // 'basic'                 => ['label' => 'Basic amount', 'rules' => 'required|numeric'],
            'ex_rate'               => ['label' => 'Exchange Rate ', 'rules' => 'required|numeric'],
            'invoice_amount'        => ['label' => 'Invoice amount', 'rules' => 'required|numeric'],
            'mobilization_amount'   => ['label' => 'Mobilization Amount', 'rules' => 'required|numeric'],
            'tax_type'              => ['label' => 'Tax Type', 'rules' => 'required'],
            // 'labour'                => ['label' => 'Labour Cess', 'rules' => 'required|numeric'],
        ];
        $id = $this->request->getPost('id');
        if ($this->validate($rules) === TRUE) {
            $basic = $this->request->getPost('basic');
            $inv_amt = $this->request->getPost('invoice_amount');
            if ($this->request->getPost('tax_type') == 1) {
                $sgst = $inv_amt * (INV_PARAMS['sgst'] / 100);
                $cgst = $inv_amt * (INV_PARAMS['cgst'] / 100);
            } else {
                $sgst = $cgst = 0;
            }
            $tds = $basic * (INV_PARAMS['tds'] / 100);
            $stds = $basic * (INV_PARAMS['tds_sgst'] / 100);
            $ctds = $basic * (INV_PARAMS['tds_cgst'] / 100);
            $labour = $this->request->getPost('labour');
            $totalI = $basic + $sgst + $cgst;
            $totalD = $tds + $stds + $ctds + $labour;
            $update_data = array(
                'project_id' => $this->request->getPost('project'),
                'inv_category' => $this->request->getPost('category'),
                'inv_number' => $this->request->getPost('inv_number'),
                'inv_date' => date('Y-m-d', strtotime($this->request->getPost('inv_date'))),
                'site_ref_no' => $this->request->getPost('site_ref_no'),
                'ra_bill_no' => $this->request->getPost('ra_bill_no'),
                'fx_invoice_amount' => $this->request->getPost('fx_invoice_amount'),
                'currency' => $this->request->getPost('currency'),
                'ex_rate' => $this->request->getPost('ex_rate'),                
                'invoice_amount' => $this->request->getPost('invoice_amount'),
                'mobilization_per' => $this->request->getPost('mobilization_per'),
                'mobilization_amount' => $this->request->getPost('mobilization_amount'),                
                'basic' => $this->request->getPost('basic'),
                'tax_type' => $this->request->getPost('tax_type'),
                'sgst' => $sgst,
                'cgst' => $cgst,
                'total' => $totalI,
                'tds' => $tds,
                'tds_sgst' => $stds,
                'tds_cgst' => $ctds,
                'labour_cess' => $this->request->getPost('labour'),
                'status' => 1,
                'note' => $this->request->getPost('notes'),
                'updated_by' => $this->session->get('user')['id'],
            );

            // Update Invoice
            if ($this->invoiceModel->update($id, $update_data)) {
                $projectId = $this->request->getPost('project');
                $mobilizationAmount = $this->request->getPost('mobilization_amount');
                $old_mobil_ded = $this->request->getPost('old_mobil_ded');
                // Fetch Mobilization Advance Available
                $currentAvailable = $this->invoiceModel->getMobilizationAdvance($projectId);
                $mobilization_available = (isset($currentAvailable['mobilization_adv_available']) and $currentAvailable['mobilization_adv_available'] != '') ? $currentAvailable['mobilization_adv_available'] : 0;
                $actual_mobilize_amt = $mobilization_available + $old_mobil_ded;

                // Calculate new mobilization advance available
                $newAvailable = $actual_mobilize_amt - $mobilizationAmount;

                $mobil_ar = array('mobilization_adv_available' => $newAvailable);
                // Update Mobilization Advance in the Project Table
                $this->invoiceModel->updateMobilizationAdvance($projectId, $mobil_ar);

                $data['msg'] = 'Invoice updated successfully!';
            } else {
                $data['msg'] = 'Failed to update invoice!';
            }

            return view('template/alert_modal', $data);
        } else {
            $data['invoice_data'] = $this->invoiceModel->find($id);
            $data['projects'] = $this->projectModel->select('id, code, name')->findAll();
            $data['categories'] = $this->invoiceModel->getCategories();
            $data['currencies'] = $this->projectModel->getCurrencies();
            $data['mobil_adv'] = $this->invoiceModel->getMobilizationDetails($data['invoice_data']['project_id']);

            return view('invoice_tracking/invoice/edit_invoice', $data);
        }
    }

    /**
     * Delete invoice
     */
    public function delete()
    {
        $id = $this->request->getPost('id');
        // Get invoice file
        $inv_data = $this->invoiceModel->select('inv_file')->find($id);
        if($this->invoiceModel->delete($id)) {
            // Delete invoice file if exists
            if(!empty($inv_data['inv_file']) AND is_file(DOCUMENTROOT . 'files/invoice/' . $inv_data['inv_file'])) {
                @unlink(DOCUMENTROOT . 'files/invoice/' . $inv_data['inv_file']);
            }
            // Get deduction data and delete files
            $deduction_data = $this->invoiceDeductionModel->select('id, deduction_file')->where('inv_id', $id)->where('deduction_file IS NOT NULL')->findAll();
            if($deduction_data) {
                foreach($deduction_data as $deduction_record) {
                    if(file_exists(DOCUMENTROOT . 'files/deduction/' . $deduction_record['deduction_file'])) {
                        unlink(DOCUMENTROOT . 'files/deduction/' . $deduction_record['deduction_file']);
                    }
                }
            }
            // Delete deductions
            $this->invoiceDeductionModel->where('inv_id', $id)->delete();

            // Get poayment data and delete files
            $payment_data = $this->invoicePaymentModel->select('id, payment_file')->where('inv_id', $id)->where('payment_file IS NOT NULL')->findAll();
            if($payment_data) {
                foreach($payment_data as $payment_record) {
                    if(file_exists(DOCUMENTROOT . 'files/payment/' . $payment_record['payment_file'])) {
                        unlink(DOCUMENTROOT . 'files/payment/' . $payment_record['payment_file']);
                    }
                }
            }
            // Delete payments
            $this->invoicePaymentModel->where('inv_id', $id)->delete();

            // Get credit data and delete files
            $credit_data = $this->invoiceCreditModel->select('id, credit_file')->where('inv_id', $id)->where('credit_file IS NOT NULL')->findAll();
            if($credit_data) {
                foreach($credit_data as $credit_record) {
                    if(file_exists(DOCUMENTROOT . 'files/credit/' . $credit_record['credit_file'])) {
                        unlink(DOCUMENTROOT . 'files/credit/' . $credit_record['credit_file']);
                    }
                }
            }
            // Delete credit
            $this->invoiceCreditModel->where('inv_id', $id)->delete();

            //Get all files in Invoice_files table for this invoice and unlink
            $inv_files = $this->invoiceFileModel->where('invoice_id', $id)->findAll();
            if (isset($inv_files) and !empty($inv_files)) {
                foreach ($inv_files as $key => $file) {
                    if(file_exists(DOCUMENTROOT . 'files/invoice/' . $file['file'])) {
                        unlink(DOCUMENTROOT . 'files/invoice/' . $file['file']);
                    }
                }
            }
            // Delete all files associated with this invoice.
            $this->invoiceFileModel->where('invoice_id', $id)->delete();
            $data['msg'] = 'Invoice deleted successfully!';
        }
        else {
            $data['msg'] = 'Failed to delete invoice!';
        }

        return view('template/alert_modal', $data);
    }

    /**
     * View deductions
     */
    public function viewDeductions() : string
    {
        $invoice_id = $this->request->getGet('invoice_id');
        $data['invoice_deductions'] = $this->invoiceDeductionModel->getInvoiceDeductions($invoice_id);

        return view('invoice_tracking/invoice/view_invoice_deductions', $data);
    }

    /**
     * Add invoice deduction
     */
    public function addDeduction() : string
    {
        $data['invoice_id'] = $this->request->getGet('invoice_id');
        $data['deductions'] = $this->deductionModel->findAll();

        return view('invoice_tracking/invoice/add_invoice_deduction', $data);
    }

    /**
     * Save invoice deuction
     */
    public function saveDeduction() : string
    {
        // Data validation rules
        $rules = [
            'invoice_id' => 'required',
            'deduction_id' => 'required',
            'amount' => 'required|numeric',
        ];
        if($this->validate($rules) == TRUE) {
            $insert_data = array(
                'inv_id' => $this->request->getPost('invoice_id'),
                'deduction_id' => $this->request->getPost('deduction_id'),
                'amount' => $this->request->getPost('amount'),
                'note' => $this->request->getPost('note'),
                'created_by' => $this->session->get('user')['id'],
            );
            if($this->invoiceDeductionModel->insert($insert_data)) {
                // Update deductions in invoice table
                $this->calculateInvoiceDeductions($this->request->getPost('invoice_id'));
                return alert_success('Deduction records saved successfully!');
            }
            else {
                return alert_danger('Error in saving data!');
            }
        }
        else {
            $data['invoice_id'] = $this->request->getPost('invoice_id');
            $data['deductions'] = $this->deductionModel->findAll();

            return view('invoice_tracking/invoice/add_invoice_deduction', $data);
        }
    }

    /**
     * Edit invoice deduction
     */
    public function editDeduction() : string
    {
        $id = $this->request->getGet('id');
        $data['deduction_data'] = $this->invoiceDeductionModel->find($id);
        $data['deductions'] = $this->deductionModel->findAll();

        return view('invoice_tracking/invoice/edit_invoice_deduction', $data);
    }

    /**
     * Update invoice deduction
     */
    public function updateDeduction() : string
    {
        // Data validation rules
        $rules = [
            'deduction_id' => 'required',
            'amount' => 'required|numeric',
        ];
        if($this->validate($rules) == TRUE) {
            $id = $this->request->getPost('id');
            $update_data = array(
                'deduction_id' => $this->request->getPost('deduction_id'),
                'amount' => $this->request->getPost('amount'),
                'note' => $this->request->getPost('note'),
            );
            if($this->invoiceDeductionModel->update($id, $update_data)) {
                // Update deductions in invoice table
                $this->calculateInvoiceDeductions($this->request->getPost('invoice_id'));
                return alert_success('Deduction record updated successfully!');
            }
            else {
                return alert_danger('Error in updating data!');
            }
        }
        else {
            $id = $this->request->getPost('id');
            $data['deduction_data'] = $this->invoiceDeductionModel->find($id);
            $data['deductions'] = $this->deductionModel->findAll();

            return view('invoice_tracking/invoice/edit_invoice_deduction', $data);
        }
    }

    /**
     * Delete invoice deduction
     */
    public function deleteDeduction() : string
    {
        $id = $this->request->getPost('id');
        // Delete deduction file if any
        $this->deleteDeductionFile($id);
        if($this->invoiceDeductionModel->delete($id)) {
            // Update deductions in invoice table
            $this->calculateInvoiceDeductions($this->request->getPost('invoice_id'));
                return alert_success('Deduction record deleted successfully!');
            }
            else {
                return alert_danger('Error in deleting data!');
            }
    }

    /**
     * Delete deduction file
     */
    public function deleteDeductionFile($id)
    {
        $mod_file = $this->invoiceDeductionModel->select('deduction_file')->find($id);
        if(file_exists(DOCUMENTROOT . 'files/deduction/' . $mod_file['deduction_file']) AND !is_dir(DOCUMENTROOT . 'files/deduction/' . $mod_file['deduction_file'])) {
            unlink(DOCUMENTROOT . 'files/deduction/' . $mod_file['deduction_file']);
        }
        // Update file column
        $this->invoiceDeductionModel->update($id, ['deduction_file' => null]);
    }

    /**
     * View invoice credits
     */
    public function viewCredits() : string
    {
        $invoice_id = $this->request->getGet('invoice_id');
        $data['invoice_credits'] = $this->invoiceCreditModel->where(['inv_id' => $invoice_id])->findAll();

        return view('invoice_tracking/invoice/view_invoice_credits', $data);
    }

    /**
     * Add invoice credit
     */
    public function addCredit() : string
    {
        $data['invoice_id'] = $this->request->getGet('invoice_id');

        return view('invoice_tracking/invoice/add_invoice_credit', $data);
    }

    /**
     * Save invoice credit
     */
    public function saveCredit() : string
    {
        // Data validation
        $rules = [
            'invoice_id' => 'required',
            'cre_type' => 'required',
            'amount' => 'required|numeric',
        ];
        if($this->validate($rules) == TRUE) {
            $insert_data = array(
                'inv_id' => $this->request->getPost('invoice_id'),
                'type' => $this->request->getPost('cre_type'),
                'amount' => $this->request->getPost('amount'),
                'note' => $this->request->getPost('note'),
                'created_by' => $this->session->get('user')['id'],
            );
            if($this->invoiceCreditModel->insert($insert_data)) {
                // Update credit in invoice table
                $this->calculateInvoiceCredits($this->request->getPost('invoice_id'));
                return alert_success('Credit / Debit note created successfully!');
            }
            else {
                return alert_danger('Error in saving data');
            }
        }
        else {
            $data['invoice_id'] = $this->request->getPost('invoice_id');

            return view('invoice_tracking/invoice/add_invoice_credit', $data);
        }
    }

    /**
     * Edit invoice credit
     */
    public function editCredit() : string
    {
        $id = $this->request->getGet('id');
        $data['credit_data'] = $this->invoiceCreditModel->find($id);

        return view('invoice_tracking/invoice/edit_invoice_credit', $data);
    }

    /**
     * Update invoice credit
     */
    public function updateCredit() : string
    {
        // Data validation rules
        $rules = [
            'cre_type' => 'required',
            'amount' => 'required|numeric',
        ];
        if($this->validate($rules) == TRUE) {
            $id = $this->request->getPost('id');
            $update_data = array(
                'type' => $this->request->getPost('cre_type'),
                'amount' => $this->request->getPost('amount'),
                'note' => $this->request->getPost('note'),
            );
            if($this->invoiceCreditModel->update($id, $update_data)) {
                // Update Credit in invoice table
                $this->calculateInvoiceCredits($this->request->getPost('invoice_id'));
                return alert_success('Credit / Dedit record updated successfully!');
            }
            else {
                return alert_danger('Error in updating data!');
            }
        }
        else {
            $id = $this->request->getPost('id');
            $data['credit_data'] = $this->invoiceCreditModel->find($id);

            return view('invoice_tracking/invoice/edit_invoice_credit', $data);
        }
    }

    /**
     * Delete invoice credit
     */
    public function deleteCredit() : string
    {
        $id = $this->request->getPost('id');
        // Delete Credit file if any
        $this->deleteCreditFile($id);
        if($this->invoiceCreditModel->delete($id)) {
            // Update credit in invoice table
            $this->calculateInvoiceCredits($this->request->getPost('invoice_id'));
                return alert_success('Credit / Debit record deleted successfully!');
            }
            else {
                return alert_danger('Error in deleting data!');
            }
    }

    /**
     * Delete credit file
     */
    public function deleteCreditFile($id)
    {
        $mod_file = $this->invoiceCreditModel->select('credit_file')->find($id);
        if(file_exists(DOCUMENTROOT . 'files/credit/' . $mod_file['credit_file']) AND !is_dir(DOCUMENTROOT . 'files/credit/' . $mod_file['credit_file'])) {
            unlink(DOCUMENTROOT . 'files/credit/' . $mod_file['credit_file']);
        }
        // Update file column
        $this->invoiceCreditModel->update($id, ['credit_file' => null]);
    }

    /**
     * View payments
     */
    public function viewPayments() : string
    {
        $invoice_id = $this->request->getGet('invoice_id');
        $data['invoice_payments'] = $this->invoicePaymentModel->getInvoicePayments($invoice_id);

        return view('invoice_tracking/invoice/view_invoice_payments', $data);
    }

    /**
     * Add invoice payment
     */
    public function addPayment() : string
    {
        $data['invoice_id'] = $this->request->getGet('invoice_id');
        $data['payment_types'] = $this->paymentTypeModel->findAll();

        return view('invoice_tracking/invoice/add_invoice_payment', $data);
    }

    /**
     * Save invoice payment
     */
    public function savePayment() : string
    {
        // Data validation rules
        $rules = [
            'invoice_id' => 'required',
            'payment_date' => 'required',
            'payment_type' => 'required',
            'amount' => 'required|numeric',
        ];
        if($this->validate($rules) == TRUE) {
            $insert_data = array(
                'inv_id' => $this->request->getPost('invoice_id'),
                'payment_date' => date('Y-m-d', strtotime($this->request->getPost('payment_date'))),
                'payment_type' => $this->request->getPost('payment_type'),
                'amount' => $this->request->getPost('amount'),
                'ref_number' => $this->request->getPost('ref_number'),
                'note' => $this->request->getPost('note'),
                'created_by' => $this->session->get('user')['id'],
            );
            if($this->invoicePaymentModel->insert($insert_data)) {
                // Update payments in invoice table
                $this->calculateInvoicePayments($this->request->getPost('invoice_id'));
                return alert_success('Payment record added successfully!');
            }
            else {
                return alert_danger('Error in saving data!');
            }
        }
        else {
            $data['invoice_id'] = $this->request->getPost('invoice_id');
            $data['payment_types'] = $this->paymentTypeModel->findAll();

            return view('invoice_tracking/invoice/add_invoice_payment', $data);
        }
    }

    /**
     * Edit invoice payment
     */
    public function editPayment() : string
    {
        $id = $this->request->getGet('id');
        $data['payment_data'] = $this->invoicePaymentModel->find($id);
        $data['payment_types'] = $this->paymentTypeModel->findAll();

        return view('invoice_tracking/invoice/edit_invoice_payment', $data);
    }

    /**
     * Update invoice payment
     */
    public function updatePayment() : string
    {
        // Data validation rules
        $rules = [
            'payment_date' => 'required',
            'payment_type' => 'required',
            'amount' => 'required|numeric',
        ];
        if($this->validate($rules) == TRUE) {
            $id = $this->request->getPost('id');
            $update_data = array(
                'payment_date' => date('Y-m-d', strtotime($this->request->getPost('payment_date'))),
                'payment_type' => $this->request->getPost('payment_type'),
                'amount' => $this->request->getPost('amount'),
                'ref_number' => $this->request->getPost('ref_number'),
                'note' => $this->request->getPost('note'),
                'updated_by' => $this->session->get('user')['id'],
            );
            if($this->invoicePaymentModel->update($id, $update_data)) {
                // Update payments in invoice table
                $this->calculateInvoicePayments($this->request->getPost('invoice_id'));
                return alert_success('Payment record updated successfully!');
            }
            else {
                return alert_danger('Error in updating data!');
            }
        }
        else {
            $id = $this->request->getPost('id');
            $data['payment_data'] = $this->invoicePaymentModel->find($id);
            $data['payment_types'] = $this->paymentTypeModel->findAll();

            return view('invoice_tracking/invoice/edit_invoice_payment', $data);
        }
    }

    /**
     * Delete invoice Payment
     */
    public function deletePayment() : string
    {
        $id = $this->request->getPost('id');
        // Delete invoice file
        $this->deletePaymentFile($id); 
        if($this->invoicePaymentModel->delete($id)) {
            // Update payments in invoice table
            $this->calculateInvoicePayments($this->request->getPost('invoice_id'));
            return alert_success('Payment record deleted successfully!');
        }
        else {
            return alert_danger('Error in deleting data!');
        }
    }

    /**
     * Delete payment file
     */
    public function deletePaymentFile($id)
    {
        $mod_file = $this->invoicePaymentModel->select('payment_file')->find($id);
        if(file_exists(DOCUMENTROOT . 'files/payment/' . $mod_file['payment_file']) AND !is_dir(DOCUMENTROOT . 'files/payment/' . $mod_file['payment_file'])) {
            unlink(DOCUMENTROOT . 'files/payment/' . $mod_file['payment_file']);
        }
        // Update file column
        $this->invoicePaymentModel->update($id, ['payment_file' => null]);
    }

    /**
     * Calculate invoice deductions
     */
    public function calculateInvoiceDeductions($invoice_id) : bool
    {
        $deductions = $this->invoiceDeductionModel->select('SUM(amount) as ded_total')->where('inv_id', $invoice_id)->find();
        $deductions_total = $deductions[0]['ded_total'];
        if($this->invoiceModel->update($invoice_id, ['other_deductions' => $deductions_total])) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Calculate invoice credit
     */
    public function calculateInvoiceCredits($invoice_id) : bool
    {
        $credit_data = $this->invoiceCreditModel->select('SUM(amount) as total')->where(['inv_id' => $invoice_id, 'type' => 1])->find();
        $debit_data = $this->invoiceCreditModel->select('SUM(amount) as total')->where(['inv_id' => $invoice_id, 'type' => 2])->find();
        $credit = isset($credit_data[0]['total']) ? -$credit_data[0]['total'] : 0;
        $debit = isset($debit_data[0]['total']) ? $debit_data[0]['total'] : 0;
        $credits_total = $credit + $debit;
        // Update invoice table
        if($this->invoiceModel->update($invoice_id, ['credit' => $credits_total])) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Calculate invoice payments
     */
    public function calculateInvoicePayments($invoice_id) : bool
    {
        $payments = $this->invoicePaymentModel->select('SUM(amount) as pay_total')->where('inv_id', $invoice_id)->find();
        $payments_total = $payments[0]['pay_total'];
        if($this->invoiceModel->update($invoice_id, ['total_received' => $payments_total])) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Invoice module add file
     */
    public function addModFile() : string
    {
        $data['id'] = $this->request->getGet('id');
        $data['inv_mod'] = $this->request->getGet('inv_mod');

        return view('invoice_tracking/invoice/add_invoice_mod_file', $data);
    }

    /**
     * Invoice module save file
     */
    public function saveModFile()
    {
        $id = $this->request->getPost('id');
        $inv_mod = $this->request->getPost('inv_mod');
        $file_upload_msg = '';
        $rules = array(
            'inv_file' =>'uploaded[inv_file]|ext_in[inv_file,jpg,png,pdf]|max_size[inv_file,20480]',
        );
        $check = $this->validate($rules);
        if($check == TRUE) {
            $fileUpload = $this->request->getFile('inv_file');
            if($fileUpload->isValid()) {
                $uploadedFile = $fileUpload->getRandomName(); // Get randon name with file extension
                switch($inv_mod) {
                    case 'inv':
                        if($fileUpload->move(DOCUMENTROOT . 'files/invoice/', $uploadedFile)) {
                            // Update file column
                            $this->invoiceModel->update($id, ['inv_file' => $uploadedFile]);
                        }
                    break;
                    case 'ded':
                        if($fileUpload->move(DOCUMENTROOT . 'files/deduction/', $uploadedFile)) {
                            // Update file column
                            $this->invoiceDeductionModel->update($id, ['deduction_file' => $uploadedFile]);
                        }
                    break;
                    case 'cre':
                        if($fileUpload->move(DOCUMENTROOT . 'files/credit/', $uploadedFile)) {
                            // Update file column
                            $this->invoiceCreditModel->update($id, ['credit_file' => $uploadedFile]);
                        }
                    break;
                    case 'pay':
                        if($fileUpload->move(DOCUMENTROOT . 'files/payment/', $uploadedFile)) {
                            // Update file column
                            $this->invoicePaymentModel->update($id, ['payment_file' => $uploadedFile]);
                        }
                    break;
                }
                return alert_success('File uploaded successfully!');
            }
        }
        else {
            return alert_danger('Failed to upload file!');
        }
    }

    /**
     * Invoice module delete file
     */
    public function deleteModFile()
    {
        $id = $this->request->getPost('id');
        $inv_mod = $this->request->getPost('inv_mod');
        switch($inv_mod) {
            case 'inv':
                $mod_file = $this->invoiceModel->select('inv_file')->find($id);
                if(file_exists(DOCUMENTROOT . 'files/invoice/' . $mod_file['inv_file']) AND !is_dir(DOCUMENTROOT . 'files/invoice/' . $mod_file['inv_file'])) {
                    unlink(DOCUMENTROOT . 'files/invoice/' . $mod_file['inv_file']);
                }
                // Update file column
                $this->invoiceModel->update($id, ['inv_file' => null]);
            break;
            case 'ded':
                $this->deleteDeductionFile($id);
            break;
            case 'cre':
                $this->deleteCreditFile($id);
            break;
            case 'pay':
                $this->deletePaymentFile($id);
            break;
        }
        return alert_success('File uploaded successfully!');
    }

    public function createFile()
    {
        $data['id'] = $id =  $this->request->getPost('invoice_id');
        $data['params'] = $this->request->getPost();
        $rules = array(
            'file_type' => 'required',
            'invoice_file' =>'uploaded[invoice_file]|ext_in[invoice_file,jpg,png,pdf]|max_size[invoice_file,20480]',
        );
        $check = $this->validate($rules);
        if ($check == TRUE) {
            $fileUpload = $this->request->getFile('invoice_file');
            if($fileUpload->isValid()) {
                $uploadedFile = $fileUpload->getRandomName(); // Get randon name with file extension
                if($fileUpload->move(DOCUMENTROOT . 'files/invoice/', $uploadedFile)) {
                    // Insert file
                    $invFile = array(
                        'invoice_id' => $id,
                        'file_type' => $this->request->getPost('file_type'),
                        'file' => $uploadedFile,
                        'created_by' => $this->session->get('user')['id'],
                        'created_at' => date('Y-m-d H:i:s'),
                    );
                    $this->invoiceFileModel->insert($invFile);
                    $data['response'] = array('color' => 'success', 'msg' => "File uploaded successfully!");
                    // set file type to default after success.
                    $data['params']['file_type'] = "";

                }
                else {
                    $data['response'] = array('color' => 'danger', 'msg' => "Failed to upload file..");
                }
            }
            else {
                $data['response'] = array('color' => 'danger', 'msg' => "Invalid File..");
            }
        }
        $data['file_types'] = $this->fileTypeModel->findAll();
        $data['invoice_documents'] = $this->invoiceFileModel->getInvoiceFiles($id);
        return view('invoice_tracking/invoice/view_invoice_documents', $data);
    }

    public function deleteFile()
    {
        $data['id'] = $id =  $this->request->getPost('id');
        $invoice_id = $this->request->getPost('invoice_id');
        $invFile = $this->invoiceFileModel->find($id);

        if(file_exists(DOCUMENTROOT . 'files/invoice/' . $invFile['file']) AND !is_dir(DOCUMENTROOT . 'files/invoice/' . $invFile['file'])) {
            unlink(DOCUMENTROOT . 'files/invoice/' . $invFile['file']);
        }
        // Delete File
        $this->invoiceFileModel->delete(['id' => $id]);

        $data['file_types'] = $this->fileTypeModel->findAll();
        $data['invoice_documents'] = $this->invoiceFileModel->getInvoiceFiles($invoice_id);
        return view('invoice_tracking/invoice/view_invoice_documents', $data);
    }

    /**
     * Export Invoices to Excel
     */
    public function InvoicesExportsXls()
    {
        header("Content-type: application/vnd.ms-excel;");
        header("Content-Disposition: attachment;filename=InvoiceDetails_" . time() . ".xls");
        $data['params'] = $this->request->getGet();
        $invoices = $this->invoiceModel->getInvoiceExportData($data['params']);
        $inv_categories = $this->invoiceModel->getCategories();

        $excel_data = "<table><thead><tr>";

        // Adding default headers for the columns
        $excel_data .= '<th>Invoice Number</th>';
        $excel_data .= '<th>Date</th>';
        $excel_data .= '<th>Project</th>';
        $excel_data .= '<th>Client</th>';
        $excel_data .= '<th>Type</th>';
        $excel_data .= '<th>Basic</th>';
        $excel_data .= '<th>SGST</th>';
        $excel_data .= '<th>CGST</th>';
        $excel_data .= '<th>Total With GST</th>';
        $excel_data .= '<th>TDS</th>';
        $excel_data .= '<th>TDS-SGST</th>';
        $excel_data .= '<th>TDS-CGST</th>';
        $excel_data .= '<th>Labour Cess</th>';
        $excel_data .= '<th>Others</th>';
        $excel_data .= '<th>Total Deductions</th>';
        $excel_data .= '<th>Total</th>';
        $excel_data .= '<th>Received</th>';
        $excel_data .= '<th>Balance</th>'; 
        $excel_data .= '<th>Payment Status</th>'; 
        $excel_data .= "</tr></thead><tbody>";

        // Fetching the invoice data
        if (!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $inv_credit = (isset($invoice['credit']) and !empty($invoice['credit'])) ? $invoice['credit'] : 0;
                $total_deductions = $invoice['tds'] + $invoice['tds_sgst'] + $invoice['tds_cgst'] + $invoice['labour_cess'] + $invoice['other_deductions'];
                $total = $invoice['total'] - $total_deductions;
                $balance = $total - $invoice['total_received'] + $inv_credit;
                
                if($invoice['total_received'] == 0) {
                    $payment_status = "No Payment";
                }
                else if(round($balance) <= MIN_INV_BALANCE) {
                    $payment_status = "Paid";
                }
                else {
                    $payment_status = "Partial Paid";
                }
                            

                $excel_data .= "<tr>";
                $excel_data .= "<td>" . $invoice['inv_number'] . "</td>";
                $excel_data .= "<td>" . $invoice['inv_date'] . "</td>";
                $excel_data .= "<td>" . $invoice['project_name'] . "</td>";
                $excel_data .= "<td>" . $invoice['client_name'] . "</td>";
                $excel_data .= "<td>" . ($inv_categories[$invoice['inv_category']] ?? 'N/A') . "</td>";
                $excel_data .= "<td>" . $invoice['basic'] . "</td>";
                $excel_data .= "<td>" . $invoice['sgst'] . "</td>";
                $excel_data .= "<td>" . $invoice['cgst'] . "</td>";
                $excel_data .= "<td>" . $invoice['total'] . "</td>";
                $excel_data .= "<td>" . $invoice['tds'] . "</td>";
                $excel_data .= "<td>" . $invoice['tds_sgst'] . "</td>";
                $excel_data .= "<td>" . $invoice['tds_cgst'] . "</td>";
                $excel_data .= "<td>" . $invoice['labour_cess'] . "</td>";
                $excel_data .= "<td>" . $invoice['other_deductions'] . "</td>";
                $excel_data .= "<td>" . $total_deductions . "</td>";
                $excel_data .= "<td>" . $total . "</td>";
                $excel_data .= "<td>" . $invoice['total_received'] . "</td>";
                $excel_data .= "<td>" . $balance . "</td>";
                $excel_data .= "<td>" . $payment_status . "</td>";
                $excel_data .= "</tr>";
            }
        }
        $excel_data .= "</tbody></table>";
        print $excel_data;
    }
}