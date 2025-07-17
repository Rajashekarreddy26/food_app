<?php

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

/**
 * BG Type Model
 */ 
class BGTypeModel extends Model
{
	protected $table = 'bg_type';
	
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	
	protected $returnType = 'array';
	
	protected $useSoftDeletes = true;
	
	protected $allowedFields = array(
		'name',
	);
	
	protected $useTimestamps = true;
	protected $dateFormat = 'datetime';

	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
}