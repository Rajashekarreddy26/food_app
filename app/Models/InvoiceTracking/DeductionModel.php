<?php
namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

/**
 * Locations Model
 */ 
class DeductionModel extends Model
{
	protected $table = 'deduction';
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
