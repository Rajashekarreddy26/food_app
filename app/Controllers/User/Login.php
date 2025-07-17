<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
/**
 * Login controller
 */
class Login extends BaseController
{
    /**
     * Constructor
     */
    protected $userModel;
    public function __construct()
    {
        $this->userModel = model('App\Models\User\UserModel');
    }

    /**
     * Login form
     */
    public function index() : string
    {
        return view('user/login/login');
    }

    /**
     * Login submit
     */
    public function loginSubmit()
    {
        if($this->request->getPost(csrf_token()) === csrf_hash()) {
            // Set form validation rules
            $rules = [
                'username' => 'required|min_length[5]|is_not_unique[user.username]',
                'password' => 'required|min_length[8]',
            ];
            if($this->validate($rules) == TRUE) {
                // Check in database
                $username = $this->request->getPost('username');
                $password = md5($this->request->getPost('password'));
                $user_login = $this->userModel->getUserLoginDetails($username, $password);
                if($user_login) {
                    // $update_login_details = array(
                    //     'last_login_at' => date('Y-m-d H:i'),
                    // );
                    // $this->userModel->update($user_login['id'], $update_login_details);
                    $rights = explode(",", $user_login['rights']);
                    $user_data = array(
                        'id' => $user_login['id'],
                        'username' => $user_login['username'],
                        'fname' => $user_login['fname'],
                        'lname' => $user_login['lname'],
                        'email' => $user_login['email'],
                        'mobile' => $user_login['mobile'],
                        'role' => $user_login['role'],
                        'rights' => $rights,
                    ); 
                    $this->session->set('user', $user_data);
                    return redirect()->to('/');
                }else {
                    $data['message'] = 'Invalid username or password!';
                    return view('user/login/login', $data);
                }
            }
            else {
                return view('user/login/login');
            }
        }
        else {
            $data['message'] = "Session Timeout!Please try again";
            return view('user/login/login', $data);
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->remove('user');
        return redirect()->to('login');
    }

    /**
     * Page Access Denied
     */ 
    public function accessDenied()
    {
        $data['page'] = array(
            'page_title' => 'Page Access Denied',
            'title' => 'Page Access Denied',
        );
        return view('user/login/access_block', $data);
    }
}