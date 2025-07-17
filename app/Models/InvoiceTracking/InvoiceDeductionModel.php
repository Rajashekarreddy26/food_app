<?php
/**
 * Invoice deduction model
 */

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

class InvoiceDeductionModel extends Model
{
    protected $table            = 'invoice_deduction';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'inv_id',
        'deduction_id',
        'amount',
        'note',
        'deduction_file',
        'created_by',
    ];

    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    // Query Builder 
    protected $db;
    protected $builder;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        // Initiate database and query builder object
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table($this->table);
    }

    /**
     * Get invoices
     * @param invoice_id int
     */
    public function getInvoiceDeductions($invoice_id) : array
    {
        return $this->builder->select('invoice_deduction.*, d.name as deduction_name')
            ->join('deduction d', 'd.id = invoice_deduction.deduction_id', 'left')
            ->where('invoice_deduction.inv_id', $invoice_id)
            ->where('invoice_deduction.deleted_at IS NULL')
            ->get()->getResultArray();
    }

    /**
     * Get Total Invoice Deductions 
     */ 
    public function getTotalInvoiceDeductions($params)
    {
        $this->builder->select('invoice_deduction.*,i.id as invoice_id,i.inv_number,p.name as project_name,p.code as project_code,c.name as client_name,d.name as deduct_name');
        $this->builder->join('invoice i', 'i.id=invoice_deduction.inv_id', 'LEFT');
        $this->builder->join('project p', 'p.id=i.project_id', 'LEFT');
        $this->builder->join('client c', 'c.id=p.client', 'LEFT');
        $this->builder->join('deduction d', 'd.id=invoice_deduction.deduction_id', 'LEFT');
        $this->builder->where('invoice_deduction.deleted_at',NULL);
        $this->invoiceQryProcess($params);
        $this->builder->orderBy($params['sort_by'], $params['sort_order']);
        $this->builder->limit($params['rows'], ($params['page_no']-1)*$params['rows']);
        return $this->builder->get()->getResultArray();
    }

    /**
     * Get Total Invoice Deductions Count
     */ 
    public function getTotalInvoiceDeductionsNum($params)
    {
        $this->builder->select('count(invoice_deduction.id) as trecords');
        $this->builder->join('invoice i', 'i.id=invoice_deduction.inv_id', 'LEFT');
        $this->builder->join('project p', 'p.id=i.project_id', 'LEFT');
        $this->builder->join('client c', 'c.id=p.client', 'LEFT');
        $this->builder->join('deduction d', 'd.id=invoice_deduction.deduction_id', 'LEFT');
        $this->builder->where('invoice_deduction.deleted_at',NULL);
        $this->invoiceQryProcess($params);
        return $this->builder->get()->getRowArray()['trecords'];
    }

    /**
     * Get Total Invoice Deduction Sum
     */ 
    public function getTotalInvoiceDeductionsSum($params)
    {
        $this->builder->select('SUM(invoice_deduction.amount) as total_amt');
        $this->builder->join('invoice i', 'i.id=invoice_deduction.inv_id', 'LEFT');
        $this->builder->join('project p', 'p.id=i.project_id', 'LEFT');
        $this->builder->join('client c', 'c.id=p.client', 'LEFT');
        $this->builder->join('deduction d', 'd.id=invoice_deduction.deduction_id', 'LEFT');
        $this->builder->where('invoice_deduction.deleted_at',NULL);
        $this->invoiceQryProcess($params);
        return $this->builder->get()->getRowArray()['total_amt'];
    }

    /**
     * Invoice Search Query Process
     */ 
    public function invoiceQryProcess($params)
    {
        if(isset($params['keywords']) and $params['keywords'] != '') {
            $this->builder->like('invoice_deduction.amount', $params['keywords']);
            $this->builder->orLike('i.inv_number', $params['keywords']);
        }
        if(isset($params['project_ext']) and $params['project_ext'] != '') {
            $this->builder->where('i.project_id', $params['project_ext']);
        }
        if(isset($params['client_ext']) and $params['client_ext'] != '') {
            $this->builder->where('p.client', $params['client_ext']);
        }
        if(isset($params['invoice_number']) and $params['invoice_number'] != '') {
            $this->builder->like('i.inv_number', $params['invoice_number']);
        }
        if(isset($params['ded_type_ext']) and $params['ded_type_ext'] != '') {
            $this->builder->where('invoice_deduction.deduction_id', $params['ded_type_ext']);
        } 
        if(isset($params['file_payment']) and $params['file_payment'] == "2") {
            $this->builder->where('invoice_deduction.deduction_file', NULL);
        }
        if(isset($params['file_payment']) and $params['file_payment'] == "1") {
            $this->builder->where('invoice_deduction.deduction_file IS NOT NULL');
        }
    }
}