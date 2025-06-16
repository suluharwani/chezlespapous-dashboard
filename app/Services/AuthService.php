<?php

namespace App\Services;

class AuthService
{
    protected $session;
    protected $adminModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->adminModel = new \App\Models\AdminModel();
    }

    public function isLoggedIn()
    {
        return $this->session->has('admin_logged_in') && $this->session->get('admin_logged_in') === true;
    }

    public function user()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        return [
            'id' => $this->session->get('admin_id'),
            'username' => $this->session->get('admin_username'),
            'email' => $this->session->get('admin_email'),
            'full_name' => $this->session->get('admin_full_name'),
            'profile_picture' => $this->session->get('admin_profile_picture'),
        ];
    }

    public function attemptLogin($username, $password)
    {
        $admin = $this->adminModel->verifyLogin($username, $password);

        if ($admin) {
            $this->login($admin);
            return true;
        }

        return false;
    }

    public function login($admin)
    {
        $sessionData = [
            'admin_id' => $admin['id'],
            'admin_username' => $admin['username'],
            'admin_email' => $admin['email'],
            'admin_full_name' => $admin['full_name'],
            'admin_profile_picture' => $admin['profile_picture'],
            'admin_logged_in' => true,
        ];

        $this->session->set($sessionData);
    }

    public function logout()
    {
        $this->session->destroy();
    }
}