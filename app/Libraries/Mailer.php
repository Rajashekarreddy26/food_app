<?php

namespace App\Libraries;

/**
 * Mailer Library
 */
class Mailer
{
    /**
     * Send email
     * With Codeigniter 4 email library
     */
    public function send($params)
    {
        // Configure email
        $email = \Config\Services::email();
        // Mail settings
        $config['protocol'] = 'smtp';
        $config['SMTPHost'] = 'mn-ssl.de';
        $config['SMTPUser'] = 'shabbeersk@highgoweb.com';
        $config['SMTPPass'] = 'MiekDibomonfix1';
        $config['SMTPPort'] = 465;
        $config['SMTPCrypto'] = 'STARTTLS';
        $config['mailType'] = 'html';
        $config['charset']  = 'utf-8';

        $email->initialize($config);
        $email->setFrom('shabbeersk@highgoweb.com', 'Shabbeek SK');

        // Emails
        if(isset($params['to'])) {
            foreach($params['to'] as $email_address) {
                $email->setTo($email_address);
            }
        }

        $email->setSubject($params['subject']);
        $email->setMessage($params['body']);

        if($email->send()) {
            return true;
        }
        else {
            // Output debug data
            if($params['debug']) {
                echo $email->printDebugger();
            }
            return false;
        }
    }
}