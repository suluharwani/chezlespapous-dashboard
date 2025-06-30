<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use Config\Services;

class Auth extends BaseController
{
    protected $adminModel;
    
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['form', 'url']);
    }
    
public function login()
{
    // Redirect if already logged in
    if (session()->get('isLoggedIn')) {
        return redirect()->to('/admin/dashboard');
    }
    
    $data = [
        'title' => 'Admin Login',
        'config' => config('Auth'),
        'showRegisterLink' => ($this->adminModel->countAll() == 0) // Add this line
    ];
    
    return view('admin/auth/login', $data);
}
    
    public function attemptLogin()
    {
        // Validate
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[4]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // Get credentials
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') == 1;
        
        // Find user
        $admin = $this->adminModel->where('email', $email)->first();
        
        if (!$admin) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }
        
        // Verify password
        if (!password_verify($password, $admin['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }
        
        // Check if active
        if (!$admin['is_active']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Account is inactive');
        }
        
        // Set session
        $sessionData = [
            'isLoggedIn' => true,
            'adminId' => $admin['id'],
            'adminName' => $admin['full_name'],
            'adminEmail' => $admin['email'],
            'adminUsername' => $admin['username'],
            'adminProfilePic' => $admin['profile_picture']
        ];
        
        session()->set($sessionData);
        
        // Remember me
        if ($remember) {
            $this->setRememberMe($admin['id']);
        }
        
        // Update last login
        $this->adminModel->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);
        
        return redirect()->to('/admin/dashboard')
            ->with('success', 'Welcome back, ' . $admin['full_name']);
    }
    
    public function register()
    {
        // Only allow registration if no admins exist
        if ($this->adminModel->countAllResults() > 0) {
            return redirect()->to('/admin/login')
                ->with('error', 'Registration is closed');
        }
        
        $data = [
            'title' => 'Register Admin Account',
            'config' => config('Auth')
        ];
        
        return view('admin/auth/register', $data);
    }
    
    public function attemptRegister()
    {
        // Only allow registration if no admins exist
        if ($this->adminModel->countAllResults() > 0) {
            return redirect()->to('/admin/login')
                ->with('error', 'Registration is closed');
        }
        
        // Validate
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[admins.username]',
            'email' => 'required|valid_email|is_unique[admins.email]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'full_name' => 'required|min_length[3]|max_length[255]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // Create admin
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->adminModel->insert($data);
        
        return redirect()->to('/admin/login')
            ->with('success', 'Registration successful. Please login.');
    }
    
    public function logout()
    {
        // Destroy session
        session()->destroy();
        
        // Delete remember me cookie if exists
        if (isset($_COOKIE['remember_me'])) {
            $this->deleteRememberMe();
        }
        
        return redirect()->to('/admin/login');
    }
    
    public function forgotPassword()
    {
        $data = [
            'title' => 'Forgot Password',
            'config' => config('Auth')
        ];
        
        return view('admin/auth/forgot_password', $data);
    }
    
    protected function setRememberMe($adminId)
    {
        $token = bin2hex(random_bytes(32));
        
        // Store token in database
        $this->adminModel->update($adminId, [
            'remember_token' => $token,
            'remember_expires' => date('Y-m-d H:i:s', strtotime('+30 days'))
        ]);
        
        // Set cookie
        setcookie(
            'remember_me',
            $token,
            time() + (30 * 24 * 60 * 60),
            '/',
            '',
            false,
            true // HttpOnly
        );
    }
    
    protected function deleteRememberMe()
    {
        // Get token from cookie
        $token = $_COOKIE['remember_me'];
        
        // Find admin with this token
        $admin = $this->adminModel->where('remember_token', $token)->first();
        
        if ($admin) {
            // Clear token in database
            $this->adminModel->update($admin['id'], [
                'remember_token' => null,
                'remember_expires' => null
            ]);
        }
        
        // Delete cookie
        setcookie(
            'remember_me',
            '',
            time() - 3600,
            '/',
            '',
            false,
            true
        );
    }
    public function attemptForgotPassword()
{
    $email = $this->request->getPost('email');
    
    $admin = $this->adminModel->where('email', $email)->first();
    
    if (!$admin) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Email not found in our system');
    }
    
    // Generate reset token
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Save token to database
    $this->adminModel->update($admin['id'], [
        'reset_token' => $token,
        'reset_expires' => $expires
    ]);
    
    // Send email (you need to implement this)
    $this->sendResetEmail($admin['email'], $token);
    
    return redirect()->to('/admin/forgot-password')
        ->with('success', 'Password reset link has been sent to your email');
}

public function resetPassword($token)
{
    $admin = $this->adminModel->where('reset_token', $token)
                              ->where('reset_expires >', date('Y-m-d H:i:s'))
                              ->first();
    
    if (!$admin) {
        return redirect()->to('/admin/forgot-password')
            ->with('error', 'Invalid or expired reset token');
    }
    
    $data = [
        'title' => 'Reset Password',
        'token' => $token
    ];
    
    return view('admin/auth/reset_password', $data);
}

public function attemptResetPassword($token)
{
    $admin = $this->adminModel->where('reset_token', $token)
                              ->where('reset_expires >', date('Y-m-d H:i:s'))
                              ->first();
    
    if (!$admin) {
        return redirect()->to('/admin/forgot-password')
            ->with('error', 'Invalid or expired reset token');
    }
    
    $rules = [
        'password' => 'required|min_length[8]',
        'confirm_password' => 'required|matches[password]'
    ];
    
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }
    
    // Update password
    $this->adminModel->update($admin['id'], [
        'password' => $this->request->getPost('password'),
        'reset_token' => null,
        'reset_expires' => null
    ]);
    
    return redirect()->to('/admin/login')
        ->with('success', 'Password has been reset successfully');
}

protected function sendResetEmail($email, $token)
{
    $emailService = \Config\Services::email();
    
    $emailService->setTo($email);
    $emailService->setSubject('Password Reset Request');
    
    $data = [
        'token' => $token,
        'expires' => '1 hour'
    ];
    
    $message = view('admin/emails/reset_password', $data);
    $emailService->setMessage($message);
    
    $emailService->send();
}
}