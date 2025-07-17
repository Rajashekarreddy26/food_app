<?php

namespace App\Controllers\InvoiceTracking\Cli;

use App\Controllers\BaseController;
use App\Libraries\Mailer;

/**
 * Bg controller
 */
class Bg extends BaseController
{
    protected $bankGuaranteeModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Load modals
        $this->bankGuaranteeModel = model('App\Models\InvoiceTracking\BankGuaranteeModel');
    }

    /**
     * Index method
     */
    public function index()
    {
        //
    }

    /**
     * Check and send reminder
     * Expires before 1 month
     */
    public function reminder1()
    {
        $reminder_date = date('Y-m-d', strtotime('+ 8 days'));
        $data['bg_data'] = $this->bankGuaranteeModel->where(['valid_date' => $reminder_date])->findAll();
        if ($data['bg_data']) {
            // Prepare mail body
            $mail_body = view('invoice_tracking/cli/bg/reminder_mail_body', $data);
            // Mailer library
            $mailer = new Mailer();
            $mail_data = array(
                'subject' => '',
                'body' => $mail_body,
                'to' => ['rama@highgoweb.com', 'ramakrishna@medianet-home.de'],
                'debug' => 1,
            );
            // Send email
            if($mailer->send($mail_data)) {
                echo '[' . date('Y:m:d H:i:s') . '] Email sent successfully!';
            }
            else {
                echo '[' . date('Y:m:d H:i:s') . '] Failed to send email!';
            }
        }
        else {
            echo 'No records!';
        }
    }
}