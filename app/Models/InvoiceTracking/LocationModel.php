<?php
namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

/**
 * Locations Model
 */ 
class LocationModel extends Model
{
	protected $table = 'location';
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
