<?php

namespace App\Controllers\InvoiceTracking;

use App\Controllers\BaseController;

/**
 * Reports Controller
 */ 
class Reports extends BaseController
{
	private $invoiceDeductionModel;
	private $projectsModel;
	private $clientModel;
	private $deductionModel;
	private $paymentTypeModel;
	private $invoicePaymentModel;

	public function __construct()
	{
		$this->invoiceDeductionModel = model('App\Models\InvoiceTracking\InvoiceDeductionModel');
		$this->projectsModel = model('App\Models\InvoiceTracking\ProjectModel');
		$this->clientModel = model('App\Models\InvoiceTracking\ClientModel');
		$this->deductionModel = model('App\Models\InvoiceTracking\DeductionModel');
		$this->paymentTypeModel = model('App\Models\InvoiceTracking\PaymentTypeModel');
		$this->invoicePaymentModel = model('App\Models\InvoiceTracking\InvoicePaymentModel');
	}

	/**
	 * Index method
	 */
	public function index() : string
	{
		$data['page'] = array(
			'page_title' => 'Reports',
			'title' => 'Reports',
		);
		return view('invoice_tracking/reports/reports', $data);
	}

	/**
	 * Invoice deductions report
	 */ 
	public function invoiceDeductions()
	{
		$data['params'] = array(
			'rows' => 20,
			'page_no' => 1,
			'sort_by' => 'invoice_deduction.created_at',
			'sort_order' => 'desc',
			'keywords' => ''
		);
		$data['invoice_deduction'] = $this->invoiceDeductionModel->getTotalInvoiceDeductions($data['params']);
		$data['tRecords'] = $this->invoiceDeductionModel->getTotalInvoiceDeductionsNum($data['params']);
		$data['total_amt'] = $this->invoiceDeductionModel->getTotalInvoiceDeductionsSum($data['params']);
		
		$data['projects'] = $this->projectsModel->orderBy('code', 'ASC')->find();
		$data['clients'] = $this->clientModel->find();
		$data['deduction_types'] = $this->deductionModel->find();
		
		$data['page'] = array(
			'page_title' => 'Invoice Deduction Report',
			'title' => 'Invoice Deduction Report',
			'breadcrumb' => [['name' => 'Reports', 'url' => 'reports']],
			'js' => ['reports','invoice', 'freeze-table'],
		);
		return view('invoice_tracking/reports/deductions_report', $data);
	}

	/**
	 * Invoice deductions report body
	 */ 
	public function invoiceDeductionsBody()
	{
		$data['params'] = $this->request->getPost();
		$data['invoice_deduction'] = $this->invoiceDeductionModel->getTotalInvoiceDeductions($data['params']);
		$data['tRecords'] = $this->invoiceDeductionModel->getTotalInvoiceDeductionsNum($data['params']);
		$data['total_amt'] = $this->invoiceDeductionModel->getTotalInvoiceDeductionsSum($data['params']);
		
		$data['clients'] = $this->clientModel->find();
		$data['deduction_types'] = $this->deductionModel->find();
		$data['projects'] = $this->projectsModel->orderBy('code', 'ASC')->find();
		
		return view('invoice_tracking/reports/deductions_report_body', $data);
	}

	/**
	 * Payments Report Function
	 */ 
	public function invoicePayments()
	{
		$data['params'] = array(
			'rows' => 20,
			'page_no' => 1,
			'sort_by' => 'invoice_payment.created_at',
			'sort_order' => 'desc',
			'keywords' => ''
		);
		$data['invoice_payments'] = $this->invoicePaymentModel->getTotalInvoicePayment($data['params']);
		$data['tRecords'] = $this->invoicePaymentModel->getTotalInvoicePaymentNum($data['params']);
		$data['total_amt'] = $this->invoicePaymentModel->getTotalInvoicePaymentSum($data['params']);

		$data['projects'] = $this->projectsModel->orderBy('code', 'ASC')->find();
		$data['clients'] = $this->clientModel->find();
		$data['payment_types'] = $this->paymentTypeModel->find();
		
		$data['page'] = array(
			'page_title' => 'Invoice Payment Report',
			'title' => 'Invoice Payment Report',
			'breadcrumb' => [['name' => 'Reports', 'url' => 'reports']],
			'js' => ['reports','invoice', 'freeze-table'],
		);
		return view('invoice_tracking/reports/payment_report', $data);
	}

	/**
	 * Invoice Payments Report Body Function
	 */ 
	public function invoicePaymentsBody()
	{
		$data['params'] = $this->request->getPost();
		$data['invoice_payments'] = $this->invoicePaymentModel->getTotalInvoicePayment($data['params']);
		$data['tRecords'] = $this->invoicePaymentModel->getTotalInvoicePaymentNum($data['params']);
		$data['total_amt'] = $this->invoicePaymentModel->getTotalInvoicePaymentSum($data['params']);

		$data['clients'] = $this->clientModel->find();
		$data['payment_types'] = $this->paymentTypeModel->find();
		$data['projects'] = $this->projectsModel->orderBy('code', 'ASC')->find();

		return view('invoice_tracking/reports/payment_report_body', $data);
	}
}