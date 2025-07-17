<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Authentication; // Custom libray

/**
 * Module Authentication filter
 */
class ModuleAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Load Authentication library
        $authentication = new Authentication();
        
        // Check user loggedin
        if(!$authentication->isUser()) {
            return redirect()->to('login');
        }
        
        // Check current module accessable
        /*if(!$authentication->checkModuleAccess()) {
            return redirect()->to('login/accessDenied');
        }*/
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // echo 'Auth::after';
    }
}