<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;

/**
 * Users Controller
 */
class User extends BaseController
{
	protected $userModel;
	protected $roleModel;
	public function __construct()
	{
		// Load models
		$this->userModel = model('App\Models\User\UserModel');
		$this->roleModel = model('App\Models\User\RolesModel');
	}

	/**
	 * User Index Function
	 */ 
	public function index()
	{
		$data['params'] = array(
			'keywords' => '',
			'rows' => 10,
			'pageno' => 1,
			'sort_by' => 'id',
			'sort_order' => 'desc',
		);
		$data['users'] = $this->userModel->getUsers($data['params']);
		$roles_ext = $this->roleModel->find();
		foreach ($roles_ext as $key => $value) {
			$data['roles'][$value['id']] = $value;
		}
		$data['tRecords'] = $this->userModel->getUsersNum($data['params']);
		$data['page'] = array(
            'title' => 'Users',
            'page_title' => 'Users',
            'js' => ['users'],
        );
		return view('user/users/users', $data);
	}
	
	/**
	 * User Index Body
	 */ 
	public function indexBody()
	{
		$data['params'] = $this->request->getPost();
		$roles_ext = $this->roleModel->find();
		foreach ($roles_ext as $key => $value) {
			$data['roles'][$value['id']] = $value;
		}
		$data['users'] = $this->userModel->getUsers($data['params']);
		$data['tRecords'] = $this->userModel->getUsersNum($data['params']);
		return view('user/users/users_body', $data);
	}

	/**
	 * To Add User
	 */ 
	public function add()
	{
		$data['roles'] = $this->roleModel->find();
		return view('user/users/user_add', $data);
	}

	/**
	 * To Insert User
	 */ 
	public function create()
	{
		if($this->request->getPost(csrf_token()) === csrf_hash())
		{
			$rules = array(
				'username' => ['label' => 'UserName', 'rules' => 'required|min_length[5]|is_unique[user.username]|alpha_dash'],
				'password' => ['label' => 'password', 'rules' => 'required|min_length[8]'],
				'c_password' => ['label' => 'Confirm Password', 'rules' => 'required|matches[password]'],
				'name' => ['label' => 'Name', 'rules' => 'required|alpha_space'],
				'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
				'phone' => ['label' => 'Phone', 'rules' => 'required|min_length[10]|numeric'],
				'role' => ['label' => 'Role', 'rules' => 'required'],
			);
			$check = $this->validate($rules);
			if($check == TRUE)
			{
				$add_user = array(
					'username' => $this->request->getPost('username'),
					'password' => md5($this->request->getPost('password')),
					'name' => $this->request->getPost('name'),
					'email' => $this->request->getPost('email'),
					'phone' => $this->request->getPost('phone'),
					'role' => $this->request->getPost('role'),
					'status' => 1,
					'created_by' => $this->session->get('user')['id'],
					'created_at' => date('Y-m-d H:i'),
				);
				// print "<pre>"; print_r($add_user); print "</pre>";exit;
				$this->userModel->insert($add_user);
				$insert_user = $this->userModel->getInsertID();
				$user_code = "U".str_pad($insert_user,4,"0",STR_PAD_LEFT);
				$insert_user_code = array(
					'id' => $insert_user,
					'user_code' => $user_code,
				);
				$this->userModel->update($insert_user, $insert_user_code);
				if($insert_user) {
					$alert = array('color' => 'success', 'msg' => 'Successfully Inserted');
				}else {
					$alert = array('color' => 'danger', 'msg' => 'Error in Inserting');
				}
			}
			else 
			{
				$data['roles'] = $this->roleModel->find();
				return view('user/users/user_add', $data);
			}
		}
		else 
		{
            $alert = array('color' => 'danger', 'msg' => "Error in Inserting!!Please Try Again");
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * To Edit User
	 */ 
	public function edit()
	{
		$id = $this->request->getGet('id');
		$data['roles'] = $this->roleModel->find();
		$data['user_details'] = $this->userModel->find($id);
		return view('user/users/users_edit', $data);
	}

	/**
	 * To Update User
	 */ 
	public function update()
	{
		if($this->request->getPost(csrf_token()) === csrf_hash())
		{
			$id = $this->request->getPost('id');
			$rules = array(
				'name' => ['label' => 'Name', 'rules' => 'required|alpha_space'],
				'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
				'phone' => ['label' => 'Phone', 'rules' => 'required|min_length[10]|numeric'],
				'role' => ['label' => 'Role', 'rules' => 'required'],
			);
			$check = $this->validate($rules);
			if($check == TRUE)
			{
				$edit_user = array(
					'name' => $this->request->getPost('name'),
					'email' => $this->request->getPost('email'),
					'phone' => $this->request->getPost('phone'),
					'role' => $this->request->getPost('role'),
					'status' => 1,
					'updated_by' => $this->session->get('user')['id'],
					'updated_at' => date('Y-m-d H:i'),
				);
				$update_user = $this->userModel->update($id,$edit_user);
				if($update_user) {
					$alert = array('color' => 'success', 'msg' => 'Successfully Updated');
				}else {
					$alert = array('color' => 'danger', 'msg' => 'Error in Updating');
				}
			}
			else 
			{
				$data['roles'] = $this->roleModel->find();
				return view('user/users/users_edit', $data);
			}
		}
		else
		{
			$alert = array('color' => 'danger', 'msg' => 'Error in Updating!Please Try Again');
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * Delete User 
	 */ 
	public function delete()
	{
		$id = $this->request->getPost('id');
		if($this->userModel->delete(['id' => $id])) {
			$alert = array('color' => 'success', 'msg' => 'Successfully Deleted');
		}
		else {
			$alert = array('color' => 'danger', 'msg' => 'Error in Deleting');			
		}
		return view('template/alert_modal', $alert);
	}

	/**
	 * Reset User Password
	 */ 
	public function resetUserPassword()
	{
		$id = $this->request->getPost('id');
		$update_user = array(
			'password' => md5(12345678),
			'updated_at' =>date('Y-m-d H:i'),
		);
		if($this->userModel->update($id, $update_user)){
			$alert = array('color' => 'success', 'msg' => 'Password changed successfully');
		}else {
			$alert = array('color' => 'danger', 'msg' => 'Error in Updating Password!');
		}
		return view('template/alert_modal', $alert);
	}
}