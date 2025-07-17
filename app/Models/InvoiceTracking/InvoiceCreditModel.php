<?php
/**
 * Invoice credit model
 */

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

class InvoiceCreditModel extends Model
{
    protected $table            = 'invoice_credit';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'inv_id',
        'type',
        'amount',
        'note',
        'credit_file',
        'created_by',
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