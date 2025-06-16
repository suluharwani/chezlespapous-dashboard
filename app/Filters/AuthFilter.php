<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('auth');
        
        // Check if user is logged in
        if (!$auth->isLoggedIn()) {
            return redirect()->to('/admin/login')->with('error', 'Please login first');
        }

        // Check for specific roles if provided
        if ($arguments) {
            $userRole = $auth->user()->role ?? null;
            if (!in_array($userRole, $arguments)) {
                return redirect()->back()->with('error', 'You do not have permission to access this page');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
    }
}