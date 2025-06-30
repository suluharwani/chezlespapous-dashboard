<?php namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 'full_name', 'profile_picture',
        'is_active', 'last_login', 'remember_token', 'remember_expires',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[admins.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[admins.email,id,{id}]',
        'password' => 'required|min_length[8]',
        'full_name' => 'required|min_length[3]|max_length[255]'
    ];
    
    protected $validationMessages = [
        'username' => [
            'is_unique' => 'This username is already taken'
        ],
        'email' => [
            'is_unique' => 'This email is already registered'
        ]
    ];
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    
    public function checkRememberMe()
    {
        if (!isset($_COOKIE['remember_me'])) {
            return false;
        }
        
        $token = $_COOKIE['remember_me'];
        $admin = $this->where('remember_token', $token)
                      ->where('remember_expires >', date('Y-m-d H:i:s'))
                      ->first();
        
        if ($admin) {
            // Log in the user
            $sessionData = [
                'isLoggedIn' => true,
                'adminId' => $admin['id'],
                'adminName' => $admin['full_name'],
                'adminEmail' => $admin['email'],
                'adminUsername' => $admin['username'],
                'adminProfilePic' => $admin['profile_picture']
            ];
            
            session()->set($sessionData);
            
            // Update last login
            $this->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);
            
            return true;
        }
        
        return false;
    }
}