<?php 
namespace App\Controllers\Settings;
use App\Controllers\BaseController;
/**
 * Modules 
 */
class Configuration extends BaseController
{
	/**
	 * To get Constant Details
	 */ 
	public function index()
	{
		$data['page'] = array(
            'title' => 'Configuration Details',
            'page_title' => 'Configuration Details',
        );
        echo view('template/template_admin',$data);
	}
}