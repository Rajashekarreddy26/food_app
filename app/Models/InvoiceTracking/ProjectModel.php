<?php

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;
// use App\Config\Database;

/**
 * Projects Model
 */
class ProjectModel extends Model
{
	protected $table            = 'project';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
    protected $useSoftDeletes = true;
	protected $allowedFields    = [
	    'code',
	    'name',
	    'type',
	    'location',
	    'client',
	    'pm_c',
	    'de_c',
	    'noa',
	    'completion_date',
	    'extension_date',
	    'contract_value_inr',
	    'contract_value',
	    'currency',
	    'ex_rate',
	    'note',
	    'mobilization_adv',
	    'mobilization_adv_available',
	    'mobilization_per',
	    'created_by',
	    'updated_by',
	    'deleted_by',
	];

	protected $useTimestamps    = true;
	protected $dateFormat       = 'datetime';
	protected $createdField     = 'created_at';
	protected $updatedField     = 'updated_at';
	protected $deletedField     = 'deleted_at';
	protected $db;
	public function __construct() 
	{
		parent::__construct();
        $this->db = \Config\Database::connect();
	}

	/**
	 * To get the All Details of the Project
	 */ 
	public function getAllProjects($params)
	{
		$builder = $this->db->table('project p');
		$builder->select('p.*, l.name as location, c.name as client');
		$builder->join('location l', 'l.id=p.location', 'left');
		$builder->join('client c', 'c.id=p.client', 'left');
		$builder->where('p.deleted_at', NULL);
		$this->getQryProcess($builder,$params);
		$builder->orderBy($params['sortby'],$params['sort_order']);
		$builder->limit($params['rows'],($params['pageno']-1)*$params['rows']);
		return $builder->get()->getResultArray();
	}

	/**
	 * To get Project List Number
	 */ 
	public function getAllProjectsNum($params)
	{
		$builder = $this->db->table('project p');
		$builder->select('count(p.id) as trecords');
		$builder->join('location l', 'l.id=p.location', 'left');
		$builder->join('client c', 'c.id=p.client', 'left');
		$builder->where('p.deleted_at', NULL);
		$this->getQryProcess($builder,$params);
		return $builder->get()->getRowArray()['trecords'];
	}
	/**
	 * To get the Filtered Data of the Project
	 */ 
	public function getQryProcess($builder,$params)
	{
		if(isset($params['keywords']) and $params['keywords'] != '') {
			$builder->groupStart();
			$builder->like('p.code', $params['keywords']);
			$builder->orLike('p.name', $params['keywords']);
			$builder->groupEnd();
		}
		if(isset($params['loc_ext']) and $params['loc_ext'] != '') {
			$builder->where('p.location', $params['loc_ext']);
		}
		if(isset($params['client_ext']) and $params['client_ext'] != '') {
			$builder->where('p.client', $params['client_ext']);
		}
		if(isset($params['complete_date']) and $params['complete_date'] != '') {
			$builder->like('p.completion_date', date('Y-m-d',strtotime($params['complete_date'])));
		}
		if(isset($params['extens_date']) and $params['extens_date'] != '') {
			$builder->like('p.extension_date', date('Y-m-d',strtotime($params['extens_date'])));
		}
		if(isset($params['code_ext']) and $params['code_ext'] != '') {
			$builder->like('p.code', $params['code_ext']);
		}
	}

	/**
	 * Get Currencies Dropdown
	 */ 
	public function getCurrencies()
	{
		$currencies = array(
			1 => array('id' => 1, 'name' => 'INR', 'symbol' => '&#8377;'),
			2 => array('id' => 2, 'name' => 'USD', 'symbol' => '&#36;'),
			3 => array('id' => 3, 'name' => 'POUND', 'symbol' => '&#163;'),
			4 => array('id' => 4, 'name' => 'EUR', 'symbol' => '&#8364;'),
		);
		return $currencies;
	}

	public function getProjectExportData($params)
	{
	    $builder = $this->db->table('project p');
	    $builder->select('p.code, p.name, l.name as location, c.name as client, p.pm_c, p.de_c, p.noa, p.completion_date, p.extension_date, p.contract_value_inr, p.contract_value, p.ex_rate');

	    $builder->join('client c', 'c.id = p.client AND c.deleted_at IS NULL', 'left');
	    $builder->join('location l', 'l.id = p.location AND l.deleted_at IS NULL', 'left');
	    $builder->where('p.deleted_at IS NULL');

	    $this->getQryProcess($builder, $params);
	    $builder->orderBy($params['sort_by'],$params['sort_order']);
	    $qry = $builder->get();
	    return $qry->getResultArray();
	}
}