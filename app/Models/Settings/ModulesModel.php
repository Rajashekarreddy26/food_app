<?php
namespace App\Models\Settings;

use CodeIgniter\Model;

/**
 * Users Model
 */ 
class ModulesModel extends Model
{
	protected $table = 'module';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType = 'array';
	protected $useSoftDeletes = true;
	protected $allowedFields = array(
		'name','url','status','parent_id','position','url2',
	);
	protected $useTimestamps = true;
	protected $dateFormat = 'datetime';
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	/**
	 * Constructor method
	 */ 
	protected $db;
	public function __construct()
	{
		parent::__construct();
		$this->db = db_connect();
	}

	/**
	 * Get the Postion of the modules
	 */ 
	public function getModulePosition($params)
	{
		$builder = $this->db->table('module');
		$builder->selectMax('position')->where('parent_id', $params['parent'])->where('position', $params['position']);
		return $builder->get()->getRowArray();
		/*$parent = isset($qry['parent_id']) ? $qry['parent_id']+1 : 1;
		$position = isset($qry['position']) ? $qry['position']+1 : 1;*/
	}
}

