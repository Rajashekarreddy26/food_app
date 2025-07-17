<?php
/**
 * Bank Guarantee model
 */

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

class BankGuaranteeModel extends Model
{
    protected $table            = 'project_bg';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'project_id',
        'type',
        'name',
        'bg_number',
        'bg_bank',
        'bg_amount',
        'issue_date',
        'valid_date',
        'claim_date',
        'bg_file',
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
        $this->builder = $this->db->table($this->table);
    }

    public function getBankGuaranteesNum($params)
    {   
        $this->builder->join('project p', 'p.id = project_bg.project_id', 'left');
        if (isset($params['keywords']) and !empty($params['keywords'])) {
            $this->builder->groupStart();
            $this->builder->like('project_bg.name', $params['keywords']);
            $this->builder->orLike('project_bg.bg_number', $params['keywords']);
            $this->builder->orLike('project_bg.bg_bank', $params['keywords']);
            $this->builder->groupEnd();
        }
        if(isset($params['exp_status']) and trim($params['exp_status'] != '')){
            if($params['exp_status'] == 1) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            } elseif ($params['exp_status'] == 2) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 30 DAY),"%Y-%m-%d")');
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY),"%Y-%m-%d")');
            } elseif ($params['exp_status'] == 3) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY),"%Y-%m-%d")');
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            } elseif ( $params['exp_status'] == 4) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            } elseif ( $params['exp_status'] == 5) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            }
        }
        $this->builder->where('project_bg.deleted_at IS NULL');
        $qry = $this->builder->countAllResults();
        // print $this->db->getLastQuery();
        return $qry;
    }
    public function getBankGuarantees($params)
    {
        $this->builder->select('project_bg.*, p.name as project_name, p.code as project_code, bt.name as bg_type')
            ->join('project p', 'p.id = project_bg.project_id', 'left')
            ->join('bg_type bt', 'bt.id = project_bg.type', 'left');
        if (isset($params['keywords']) and !empty($params['keywords'])) {
            $this->builder->groupStart();
            $this->builder->like('project_bg.name', $params['keywords']);
            $this->builder->orLike('project_bg.bg_number', $params['keywords']);
            $this->builder->orLike('project_bg.bg_bank', $params['keywords']);
            $this->builder->groupEnd();
        }
        if(isset($params['exp_status']) and trim($params['exp_status'] != '')){
            if($params['exp_status'] == 1) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            } elseif ($params['exp_status'] == 2) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 30 DAY),"%Y-%m-%d")');
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY),"%Y-%m-%d")');
            } elseif ($params['exp_status'] == 3) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 10 DAY),"%Y-%m-%d")');
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            } elseif ( $params['exp_status'] == 4) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            } elseif ( $params['exp_status'] == 5) {
                $this->builder->where('DATE_FORMAT(project_bg.valid_date,"%Y-%m-%d") < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 0 DAY),"%Y-%m-%d")');
            }
        }
        $this->builder->where('project_bg.deleted_at IS NULL');
        $this->builder->limit($params['rows'], ($params['pageno'] - 1)*$params['rows']);
        $this->builder->orderBy($params['sortby'], $params['sort_order']);
        $qry = $this->builder->get()->getResultArray();

        return $qry;
    }

    public function getBgById($id) 
    {
        return $this->builder->select('project_bg.*, p.name as project_name, p.code as project_code, bt.name as bg_type')
                        ->join('project p', 'p.id = project_bg.project_id', 'left')
                        ->join('bg_type bt', 'bt.id = project_bg.type', 'left')
                        ->where('project_bg.id', $id)
                        ->get()->getRowArray();
    }
}
