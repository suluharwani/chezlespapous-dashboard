<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Auth extends BaseController
{
    protected $auth;
    protected $adminModel;

    public function __construct()
    {
         $this->auth = service('auth');
        $this->adminModel = new AdminModel();
    }

      public function login()
    {
        if ($this->auth->isLoggedIn()) {
            return redirect()->to('/admin/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => 'required',
                'password' => 'required|min_length[6]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if ($this->auth->attemptLogin($username, $password)) {
                return redirect()->to('/admin/dashboard')->with('success', 'Welcome back!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid username or password');
            }
        }

        return view('admin/auth/login');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect()->to('/admin/login')->with('success', 'You have been logged out');
    }
}