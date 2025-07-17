<?php
/**
 * Invoice payment model
 */

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

class InvoicePaymentModel extends Model
{
    protected $table            = 'invoice_payment';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'inv_id',
        'payment_date',
        'amount',
        'payment_type',
        'ref_number',
        'payment_file',
        'note',
        'created_by',
        'updated_by',
        'deleted_by'
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
     * Get invoice payments
     * @param invoice_id int
     */
    public function getInvoicePayments($invoice_id) : array
    {
        return $this->builder->select('invoice_payment.*, p.name as payment_name')
            ->join('payment_type p', 'p.id = invoice_payment.payment_type', 'left')
            ->where('invoice_payment.inv_id', $invoice_id)
            ->where('invoice_payment.deleted_at IS NULL')
            ->get()->getResultArray();
    }

    /**
     * Get Total Invoice Payments
     */ 
    public function getTotalInvoicePayment($params)
    {
        $this->builder->select('invoice_payment.*,p.name as project_name,p.code as project_code,c.name as client_name,i.id as invoice_id,i.inv_number,pt.name as pay_type');
        $this->builder->join('invoice i', 'i.id=invoice_payment.inv_id', 'LEFT');
        $this->builder->join('project p', 'p.id=i.project_id', 'LEFT');
        $this->builder->join('client c', 'c.id=p.client', 'LEFT');
        $this->builder->join('payment_type pt', 'pt.id=invoice_payment.payment_type', 'LEFT');
        $this->builder->where('invoice_payment.deleted_at',NULL);
        $this->getPaymentQryProcess($params);
        $this->builder->orderBy($params['sort_by'], $params['sort_order']);
        $this->builder->limit($params['rows'], ($params['page_no']-1)*$params['rows']);
        return $this->builder->get()->getResultArray();
    }

    /**
     * Get Total Invoice Payments COUNT
     */ 
    public function getTotalInvoicePaymentNum($params)
    {
        $this->builder->select('count(invoice_payment.id) as trecords');
        $this->builder->join('invoice i', 'i.id=invoice_payment.inv_id', 'LEFT');
        $this->builder->join('project p', 'p.id=i.project_id', 'LEFT');
        $this->builder->join('client c', 'c.id=p.client', 'LEFT');
        $this->builder->join('payment_type pt', 'pt.id=invoice_payment.payment_type', 'LEFT');
        $this->builder->where('invoice_payment.deleted_at',NULL);
        $this->getPaymentQryProcess($params);
        return $this->builder->get()->getRowArray()['trecords'];
    }

    /**
     * Get Total Invoice Payments Sum
     */ 
    public function getTotalInvoicePaymentSum($params)
    {
        $this->builder->select('SUM(invoice_payment.amount) as total_amt');
        $this->builder->join('invoice i', 'i.id=invoice_payment.inv_id', 'LEFT');
        $this->builder->join('project p', 'p.id=i.project_id', 'LEFT');
        $this->builder->join('client c', 'c.id=p.client', 'LEFT');
        $this->builder->join('payment_type pt', 'pt.id=invoice_payment.payment_type', 'LEFT');
        $this->builder->where('invoice_payment.deleted_at',NULL);
        $this->getPaymentQryProcess($params);
        return $this->builder->get()->getRowArray()['total_amt'];
    }

    /**
     * Payment Query  Filter Process
     */ 
    public function getPaymentQryProcess($params)
    {
        if(isset($params['keywords']) and $params['keywords'] != '') {
            $this->builder->groupStart();
            $this->builder->like('invoice_payment.amount', $params['keywords']);
            $this->builder->orLike('i.inv_number', $params['keywords']);
            $this->builder->orLike('invoice_payment.ref_number', $params['keywords']);
            $this->builder->groupEnd();
        }
        if(isset($params['project_ext']) and $params['project_ext'] != '') {
            $this->builder->where('i.project_id', $params['project_ext']);
        }
        if(isset($params['client_ext']) and $params['client_ext'] != '') {
            $this->builder->where('p.client', $params['client_ext']);
        }
        if(isset($params['pay_type_ext']) and $params['pay_type_ext'] != '') {
            $this->builder->where('invoice_payment.payment_type', $params['pay_type_ext']);
        }
        if(isset($params['invoice_number']) and $params['invoice_number'] != '') {
            $this->builder->like('i.inv_number', $params['invoice_number']);
        }
        if(isset($params['file_payment']) and $params['file_payment'] == "2") {
            $this->builder->where('invoice_payment.payment_file', NULL);
        }
        if(isset($params['file_payment']) and $params['file_payment'] == "1") {
            $this->builder->where('invoice_payment.payment_file IS NOT NULL');
        }
    }
}