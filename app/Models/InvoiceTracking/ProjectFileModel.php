<?php
namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

/**
 * Locations Model
 */ 
class ProjectFileModel extends Model
{
	protected $table = 'project_file';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType = 'array';
	protected $useSoftDeletes = false;
	protected $allowedFields = array(
		'project_id',
		'file_type',
		'file',
	);
	protected $useTimestamps = true;
	protected $dateFormat = 'datetime';
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';
}
