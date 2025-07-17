<?php

namespace App\Libraries;

/**
 * Authentication library
 */
class Authentication
{
    private $session;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Load CI data
        $this->session = \Config\Services::session();
    }

    /**
     * Check user logged in or not
     */
    public function isUser()
    {
        return ($this->session->has('user')) ? true : false;
    }

    /**
     * Check Super admin role
     */
    public function isSuperAdmin() : bool
    {
        return ($this->session->get('user')['role'] == 1) ? true : false;
    }

    /**
     * Check Admin role
     */
    public function isAdmin() : bool
    {
        return ($this->session->get('user')['role'] == 2) ? true : false;
    }

    /**
     * Check module access
     */
    public function checkModuleAccess() : bool
    {
        $moduleId = $this->getModuleId();
        if($this->isSuperAdmin() OR $this->isAdmin() OR in_array($moduleId, $this->session->get('user')['rights'])) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Get Module Id with URL
     */
    public function getModuleId() : int
    {
        $moduleModel = model('App\Models\Settings\ModulesModel');
        // Load URI library
        $uri = service('uri');
        $segment1 = !empty($uri->getSegment(1)) ? $uri->getSegment(1) : 'home';
        // echo uri_string();
        $module_data = $moduleModel->select('id')->where(['url' => $segment1, 'status' => 1])->first();
        return ($module_data) ? $module_data['id'] : 0;
    }
}