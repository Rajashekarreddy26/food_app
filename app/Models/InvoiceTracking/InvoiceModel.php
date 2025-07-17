<?php

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

/**
 * Invoice model
 */
class InvoiceModel extends Model
{
    protected $table            = 'invoice';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'project_id',
        'inv_category',
        'inv_number',
        'inv_date',
        'duedate',
        'site_ref_no',
        'ra_bill_no',
        'fx_invoice_amount',
        'currency',
        'ex_rate',
        'invoice_amount',
        'mobilization_per',
        'mobilization_amount',
        'basic',
        'tax_type',
        'sgst',
        'cgst',
        'total',
        'tds',
        'tds_sgst',
        'tds_cgst',
        'labour_cess',
        'other_deductions',
        'credit',
        'total_received',
        'inv_file',
        'status',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
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
        $this->builder = $this->db->table('invoice');
    }

    /**
     * Get invoices count
     * @param params array
     */
    public function getInvoicesCount($params = null) : int
    {
        $this->builder->join('project p', 'p.id = invoice.project_id', 'left')
            ->join('client c', 'c.id = p.client', 'left');
        $this->invoicesQryFilter($params);
        return $this->builder->countAllResults();
    }

    /**
     * Get invoices
     * @param params array
     */
    public function getInvoices($params = null) : array
    {
        // $this->builder->select('invoice.*, p.code as project_name, c.name as client_name, (SELECT invoice_id from invoice_file where invoice.id = invoice_file.invoice_id limit 1) as file_id')
        $this->builder->select('invoice.*, p.code as project_name, c.name as client_name, COUNT(f.id) as file_count')
            // ->selectSubquery('select a from invoice_file limit 1', 'newv')
            ->join('invoice_file f', 'invoice.id = f.invoice_id', 'left')
            ->join('project p', 'p.id = invoice.project_id', 'left')
            ->join('client c', 'c.id = p.client', 'left');
        $this->invoicesQryFilter($params);
        $this->builder->groupBy('invoice.id');
        return $this->builder->orderBy($params['sort_column'], $params['sort_order'])
            ->limit($params['rows'], $params['offset'])->get()->getResultArray();
    }

    /**
     * Filter method
     */
    public function invoicesQryFilter($params)
    {
        if(!empty($params['key'])) {
            $this->builder->groupStart()
                ->like('invoice.inv_number', $params['key'])
                ->orLike('invoice.site_ref_no', $params['key'])
                ->orLike('invoice.ra_bill_no', $params['key'])
                ->orLike('p.code', $params['key'])
                ->orLike('p.name', $params['key'])
                ->orLike('p.type', $params['key'])
                ->orLike('c.name', $params['key'])
            ->groupEnd();
        }
        if(!empty($params['inv_proj'])) {
            $this->builder->where('invoice.project_id', $params['inv_proj']);
        }
        if(!empty($params['inv_client'])) {
            $this->builder->where('p.client', $params['inv_client']);
        }
        if(!empty($params['inv_type'])) {
            $this->builder->where('invoice.inv_category', $params['inv_type']);
        }
        if (isset($params['payment_status']) and !empty($params['payment_status'])) {
            switch ($params['payment_status']) {
                case 1:
                    $this->builder->where('(ifnull(invoice.total,0)- ifnull(invoice.tds,0)- ifnull(invoice.tds_sgst,0)- ifnull(invoice.tds_cgst,0)- ifnull(invoice.labour_cess,0)- ifnull(invoice.other_deductions,0)+ ifnull(invoice.credit,0)- ifnull(invoice.total_received,0)) < '.MIN_INV_BALANCE);
                    break;
                case 2:
                    $this->builder->where('(ifnull(invoice.total,0)- ifnull(invoice.tds,0)- ifnull(invoice.tds_sgst,0)- ifnull(invoice.tds_cgst,0)- ifnull(invoice.labour_cess,0)- ifnull(invoice.other_deductions,0)+ ifnull(invoice.credit,0)- ifnull(invoice.total_received,0)) >= '.MIN_INV_BALANCE.' AND invoice.total_received > 0');
                    break;
                case 3:
                    $this->builder->where('ifnull(invoice.total_received,0) <= 0');
                    break;
                
                default:
                    // code...
                    break;
            }
        }
    }

    /**
     * Get invoice totals
     */
    public function getInvoiceTotals($params) : array
    {
        $this->builder->select('SUM(invoice.basic) as basic_sum, SUM(invoice.sgst) as sgst_sum, SUM(invoice.cgst) as cgst_sum, SUM(invoice.tds) as tds_sum, SUM(invoice.tds_sgst) as tds_sgst_sum, SUM(invoice.tds_cgst) as tds_cgst_sum, SUM(invoice.labour_cess) as labour_cess_sum, SUM(invoice.other_deductions) as other_deductions_sum, SUM(invoice.total_received) as received_sum')
            ->join('project p', 'p.id = invoice.project_id', 'left')
            ->join('client c', 'c.id = p.client', 'left');
        $this->invoicesQryFilter($params);
        return $this->builder->get()->getRowArray();
    }

    /**
     * Get invoice details
     */
    public function getInvoiceDetails($id) : array
    {
        return $this->builder->select('invoice.*, p.name as project_name, p.code as project_code, c.name as client_name')
            ->join('project p', 'p.id = invoice.project_id', 'left')
            ->join('client c', 'c.id = p.client', 'left')
            ->where('invoice.id', $id)
            ->get()->getRowArray();
    }

    /**
     * Invoice Categories / types
     */
    public function getCategories() : array
    {
        return [
            1 => 'ENG',
            2 => 'PRO',
            3 => 'CON',
        ];
    }

    /**
     * Get project based invoice totals dashboard
     */
    public function getProjectInvoiceTotals($year = null) : array
    {
        return $this->builder->select('project_id, SUM(total) as invoice_value, SUM(tds + tds_sgst + tds_cgst + labour_cess) as deductions, SUM(other_deductions) as other_deductions, SUM(total_received) as received')
            ->where('deleted_at', NULL)->groupBy('project_id')->get()->getResultArray();
    }

    /**
     * Get financial turnover counts dashboard
     */
    public function getFinancialTotals($year = null) : array
    {
        $this->builder->select('SUM(basic) as basic_value, SUM(total) as invoice_value');
        if($year > 0) {
            $this->builder->groupStart()
                    ->where('DATE(inv_date) >= \'' . $year . '-04-01\'')
                    ->where('DATE(inv_date) <= \'' . ($year + 1) . '-03-31\'')
                ->groupEnd();
        }
        return $this->builder->where('deleted_at', NULL)->get()->getRowArray();
    }

    public function getInvoicesByClient($client)
    {
        $this->builder = $this->db->table('invoice i');
        $qry = $this->builder->select('i.*, p.id as p_id, p.name as project_name, c.id as c_id, c.name as client_name')
                ->join('project p', 'p.id = i.project_id', 'left')
                ->join('client c', 'c.id = p.client', 'left')
                ->where('c.id', $client)
                ->where('i.deleted_at IS NULL')
                ->get()->getResultArray();
        return $qry;
    }

    public function getSumsByClient($client)
    {
        $this->builder = $this->db->table('invoice i');
        $qry = $this->builder->select('i.inv_category, SUM(COALESCE(tds,0)+COALESCE(tds_cgst,0)+COALESCE(tds_sgst,0)+COALESCE(labour_cess,0)+COALESCE(other_deductions,0)) as deductions, SUM(total) as base_total, SUM(total_received) as paid_total, p.id as p_id, c.id as c_id')
                ->join('project p', 'p.id = i.project_id', 'left')
                ->join('client c', 'c.id = p.client', 'left')
                ->where('c.id', $client)
                ->where('i.deleted_at IS NULL')
                ->groupBy(['i.inv_category', 'i.project_id'])
                ->get()->getResultArray();
        return $qry;
    }

    public function getInvoicesByProject($params) 
    {
        $this->builder = $this->db->table('invoice i');
        $this->builder->select('i.*, p.id as p_id, p.name as project_name');
        $this->builder->join('project p', 'p.id = i.project_id', 'left');
        $this->builder->where('i.project_id', $params['project_id']);
        if (isset($params['inv_category']) and $params['inv_category'] != "") {
            $this->builder->where('i.inv_category', $params['inv_category']);
        }
        $this->builder->where('i.deleted_at IS NULL');
        return $this->builder->get()->getResultArray();
         
    }

    public function getMobilizationDetails($projectId)
    {
        $this->builder = $this->db->table('project');
        $this->builder->select('mobilization_adv, mobilization_adv_available, mobilization_per');
        $this->builder->where('id', $projectId);
        $result = $this->builder->get()->getRowArray();

        return $result ? $result : null;
    }

    public function getMobilizationDetailsView($id)
    {
        $this->builder = $this->db->table('project');
        $this->builder->select('mobilization_adv, mobilization_adv_available');
        $this->builder->where('id', $id);
        $result = $this->builder->get()->getRowArray();

        return $result ? $result : null;
    }

    public function updateMobilizationAdvAvailable($projectId, $data)
    {
        $this->builder = $this->db->table('project');
        return $this->builder->where('id', $projectId)->update($data);
    }

    public function getMobilizationAdvance($projectId)
    {
        $builder = $this->db->table('project');
        $query = $builder->select('mobilization_adv_available')->where('id', $projectId)->get();
        return $query->getRowArray();
    }

    public function updateMobilizationAdvance($projectId, $data)
    {
        $this->builder = $this->db->table('project');
        return $this->builder->where('id', $projectId)->update($data);
    }

    public function getProjectTotals()
    {
        $this->builder->select('SUM(invoice_amount) as basic_amount, SUM(total) as invoice_amount, project_id')->where('deleted_at IS NULL');
        return $this->builder->groupBy('project_id')->get()->getResultArray();
    }

    public function getInvoiceExportData($params)
    {
        $this->builder->select('invoice.inv_number, invoice.inv_date, p.code as project_name, c.name as client_name, invoice.inv_category, invoice.basic, invoice.sgst, invoice.cgst, invoice.total, invoice.tds, invoice.tds_sgst, invoice.tds_cgst, invoice.labour_cess, invoice.other_deductions, invoice.total_received, invoice.credit');
        
        $this->builder->join('project p', 'p.id = invoice.project_id AND p.deleted_at IS NULL', 'left');
        $this->builder->join('client c', 'c.id = p.client AND c.deleted_at IS NULL', 'left');
        $this->builder->where('invoice.deleted_at IS NULL');

        $this->invoicesQryFilter($params);
        $this->builder->orderBy($params['sort_column'], $params['sort_order']);
        $qry = $this->builder->get();
        return $qry->getResultArray();
    }
}