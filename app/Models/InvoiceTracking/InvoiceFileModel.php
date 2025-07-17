<?php
/**
 * Invoice credit model
 */

namespace App\Models\InvoiceTracking;

use CodeIgniter\Model;

class InvoiceFileModel extends Model
{
    protected $table            = 'invoice_file';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'invoice_id',
        'file_type',
        'file',
        'created_at',
        'created_by',
    ];

    protected $useTimestamps    = false;
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

    public function getInvoiceFiles($invoice_id)
    {
        $this->builder->select('invoice_file.*, f.name as file_name, u.name as user_name');
        $this->builder->join('file_type f', 'f.id = invoice_file.file_type', 'left');
        $this->builder->join('user u', 'u.id = invoice_file.created_by', 'left');
        $this->builder->where('invoice_file.invoice_id', $invoice_id);
        $qry = $this->builder->get();

        return $qry->getResultArray();
    }
}