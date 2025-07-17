<?php 
namespace App\Controllers\User;
use App\Controllers\BaseController;
/**
 * Roles 
 */
class Roles extends BaseController
{
	protected $roleModel;
	protected $moduleModel;
	public function __construct()
	{
		$this->roleModel = model('App\Models\User\RolesModel');
		$this->moduleModel = model('App\Models\Settings\ModulesModel');
	}

	/**
	 * To get the Total Records
	 */ 
	public function index()
	{
		$data['roles'] = $this->roleModel->orderBy('id','asc')->findAll();
		$data['tRecords'] = $this->roleModel->countAllResults();
		$data['page'] = array(
            'title' => 'Roles',
            'page_title' => 'Roles',
            'js' => ['role'],
        );
		return view('user/roles/roles', $data);
	}

	/**
	 * Add Role
	 */ 
	public function addRole()
	{
		return view('user/roles/roles_add');
	}

	/**
	 * Insert Role
	 */ 
	public function insertRole()
	{
		if($this->request->getPost(csrf_token()) === csrf_hash()){
			$rules = ['name' => ['label' => 'Name', 'rules' => 'required']];
			$check = $this->validate($rules);
			if($check == TRUE){
				$add_role = array(
					'name' => $this->request->getPost('name'),
					'created_at' => date('Y-m-d H:i'),
				);
				if($this->roleModel->insert($add_role)) {
            		$alert = array('color' => 'success', 'msg' => "Role Inserted Successfully");
				}else {
            		$alert = array('color' => 'danger', 'msg' => "Error in Inserting!");
				}
			}
			else
			{
				return view('user/roles/roles_add');
			}
		}
		else
		{
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * Managage Rights for the Role
	 */ 
	public function editRole()
	{
		$id = $this->request->getGet('id');
		$data['roles_details'] = $this->roleModel->find($id);
		$data['modules'] = $this->moduleModel->findAll();
		return view('user/roles/roles_edit', $data);
	}

	/**
	 * Updating Manage Rights
	 */ 
	public function updateRoleRights()
	{
		if($this->request->getPost(csrf_token()) === csrf_hash()) {
			$id = $this->request->getPost('id');
			$rights = "";
			if($this->request->getPost('rights') != ''){
				$rights = implode(",", $this->request->getPost('rights'));
			}
			$rules = ['name' => ['label' => 'Name', 'rules' => 'required']];
			$check = $this->validate($rules);
			if($check == TRUE) {
				$update_rights = array(
					'name' => $this->request->getPost('name'),
					'rights' => $rights,
					'updated_at' => date('Y-m-d H:i'),
				);
				if($this->roleModel->update($id, $update_rights)){
	            	$alert = array('color' => 'success', 'msg' => "Role Updated Successfully");
				}else {
	            	$alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
				}
			}
			else 
			{
				$data['modules'] = $this->moduleModel->findAll();
				return view('user/roles/roles_edit',$data);
			}
		}
		else
		{
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * Delete Role
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->roleModel->delete($id)) {
            $alert = array('color' => 'success', 'msg' => "Role Deleted Successfully");
		}else {
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
		}
		return view('template/alert_modal', $alert);
	}
}