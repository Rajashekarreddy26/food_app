<?php
namespace App\Models\User;

use CodeIgniter\Model;

/**
 * Users Model
 */ 
class UserModel extends Model
{
	protected $table = 'user';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType = 'array';
	protected $useSoftDeletes = true;
	protected $allowedFields = array(
		'user_type',
		'fname',
		'lname',
		'username',
		'password',
		'emp_id',
		'email',
		'mobile',
		'location',
		'district',
		'state',
		'client_id',
		'vendor_id',
		'status',
		'role',
		'created_by',
		'updated_by',
		'deleted_by',
	);
	protected $useTimestamps = true;
	protected $dateFormat = 'datetime';
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
	protected $allowCallbacks = true;
	protected $db;
	public function __construct()
	{
		parent::__construct();
		$this->db = db_connect();
	}

	/**
	 * To Get All User Details
	 */ 
	public function getUsers($params)
	{
		$builder = $this->db->table('user');
		$builder->select('*');
		if(isset($params['keywords']) and $params['keywords'] != '') {
			$builder->groupStart();
			$builder->like('fname', $params['keywords']);
			$builder->orLike('lname', $params['keywords']);
			$builder->orLike('username', $params['keywords']);
			$builder->orLike('emp_id', $params['keywords']);
			$builder->orLike('email', $params['keywords']);
			$builder->orLike('mobile', $params['keywords']);
			$builder->groupEnd();
		}
		$builder->where('deleted_at', NULL);
		$builder->orderBy($params['sort_by'],$params['sort_order']);
		$builder->limit($params['rows'],($params['pageno']-1)*$params['rows']);
		return $builder->get()->getResultArray();
	}

	/**
	 * To Count the User Records
	 */ 
	public function getUsersNum($params)
	{
		$builder = $this->db->table('user');
		$builder->select('count(id) as trecords');
		if(isset($params['keywords']) and $params['keywords'] != '') {
			$builder->groupStart();
			$builder->like('fname', $params['keywords']);
			$builder->orLike('lname', $params['keywords']);
			$builder->orLike('username', $params['keywords']);
			$builder->orLike('emp_id', $params['keywords']);
			$builder->orLike('email', $params['keywords']);
			$builder->orLike('mobile', $params['keywords']);
			$builder->groupEnd();
		}
		$builder->where('deleted_at', NULL);
		return $builder->get()->getRowArray()['trecords'];
	}

	/**
	 * To Check User Login
	 */ 
	public function getUserLoginDetails($username,$password)
	{
		$builder = $this->db->table('user u');
		$builder->select('u.*, r.rights');
		$builder->join('role r', 'r.id=u.role', 'left');
		$builder->where('u.status', 1);
		$builder->where('u.username', $username);
		$builder->where('u.password', $password);
		$builder->where('u.deleted_at', NULL);
		return $builder->get()->getRowArray();
	}
}
