<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
/**
 * Profile Controller
 */
class Profile extends BaseController
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
	 * User Profile Details
	 */ 
	public function index()
	{
		$id = $this->session->get('user')['id'];
        $data['user_details'] = $this->userModel->find($id);
		$roles = $this->roleModel->find();
		foreach($roles as $rid => $role){
			$data['roles'][$role['id']] = $role;
		}
        $data['page'] = array(
            'title' => 'Profile',
            'page_title' => 'Profile',
        );
        return view('user/profile/profile', $data);
	}

	/**
	 * User Change Password
	 */ 
	public function changePassword()
	{
        $user_id = $this->session->get('user')['id'];       
        $data['user'] = $this->userModel->find($user_id);
        $data['page'] = array(
        	'title' => "Change Password",
        	'page_title' => "Change Password"
        );
        return view('user/profile/user_change_password', $data);
	}

	/**
     * Update User Password
     */
    public function updatePassword()
    {
        // check form validations
        $id = $this->request->getPost('id');
        $user_verify = $this->userModel->find($id);
        $rules = array(
        	'oldpassword' => ['label' => 'Old Password', 'rules' => 'required'],
        	'password' => ['label' => 'New Password', 'rules' => 'required|min_length[8]'],
        	'passconf' => ['label' => 'Confirm Password', 'rules' => 'required|matches[password]'],
        );
        if(isset($user_verify['password']) and $user_verify['password'] == md5($this->request->getPost('oldpassword')) and $this->request->getPost('oldpassword') !== $this->request->getPost('password')) {
	    	$check = $this->validate($rules);
	        if($check == TRUE) {
	        	$edit_password = array(
	        		'password' =>md5($this->request->getPost('password')),
	        		'updated_at' => date('Y-m-d H:i'),
	        	);
	        	if($this->userModel->update($id,$edit_password)) {
	        		session()->setFlashdata('status','Password Updated Successfully');
	        	} else {
	        		session()->setFlashdata('error','Error in Updating Password');	        		
	        	}
	        	return redirect()->to('profile/changePassword');
	        }else {
	        	$user_id = $this->session->get('user')['id'];       
	        	$data['user'] = $this->userModel->find($user_id);
	        	$data['page'] = array(
	        		'title' => "Change Password",
	        		'page_title' => "Change Password"
	        	);
	        	return view('user/profile/user_change_password',$data);
	        }
        }else {
	        $data['user'] = $this->userModel->find($this->session->get('user')['id']);
	        $data['page'] = array(
	        		'title' => "Change Password",
	        		'page_title' => "Change Password"
	        	);
        	$data['message'] = 'The Old Password is required and should match to the database';
        	$data['conf_message'] = 'The Current Password should not match to the Old Password';
        	return view('user/profile/user_change_password',$data);
        }
    }
}