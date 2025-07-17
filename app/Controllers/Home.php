<?php

namespace App\Controllers;

/**
 * Home controller
 */
class Home extends BaseController
{
    protected $clientModel;
    protected $projectModel;
    protected $invoiceModel;
    protected $bankGuaranteeModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Load modals
        // $this->clientModel = model('App\Models\InvoiceTracking\ClientModel');
        // $this->projectModel = model('App\Models\InvoiceTracking\ProjectModel');
        // $this->invoiceModel = model('App\Models\InvoiceTracking\InvoiceModel');
        // $this->bankGuaranteeModel = model('App\Models\InvoiceTracking\BankGuaranteeModel');
    }

    /**
     * Index method
     * Dashboard data
     */
    public function index(): string
    {
        $data['page'] = array(
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'js' => ['client', 'freeze-table'],
            'layout' => 1,
        );        
        return view('invoice_tracking/dashboard/dashboard', $data);
    }
    public function index_body(): string
    {
        // Set template parameters
        $data['page'] = array(
            'title' => 'Dashboard',
            'page_title' => 'Dashboard',
            'js' => ['client', 'freeze-table'],
            'layout' => 1,
        );        
        return view('invoice_tracking/dashboard/dashboard', $data);
    }

    /**
     * Dashbard
     * Financial data
     */
    /*public function financialData() : string
    {
        // $data['fy'] = $this->request->getGet('fy');
        // $data['financial_totals'] = $this->invoiceModel->getFinancialTotals($data['fy']);

        // return view('invoice_tracking/dashboard/financial_data', $data);
    }*/
}