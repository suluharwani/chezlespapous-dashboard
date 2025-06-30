<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $adminModel = new AdminModel();
        
        // Check remember me cookie first
        if (!$adminModel->checkRememberMe()) {
            // If not logged in and no remember me, redirect to login
            if (!session()->get('isLoggedIn')) {
                return redirect()->to('/admin/login');
            }
        }
        
        // Check if account still exists
        if (session()->get('isLoggedIn')) {
            $admin = $adminModel->find(session()->get('adminId'));
            if (!$admin) {
                session()->destroy();
                return redirect()->to('/admin/login')
                    ->with('error', 'Your account no longer exists');
            }
            
            // Check if account is active
            if (!$admin['is_active']) {
                session()->destroy();
                return redirect()->to('/admin/login')
                    ->with('error', 'Your account has been deactivated');
            }
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
    }
}