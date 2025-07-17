<?php
/**
 * Project Bank Guarantee History model
 */

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

class ProjectBgHistoryModel extends Model
{
    protected $table            = 'project_bg_history';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'bg_id',
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
}