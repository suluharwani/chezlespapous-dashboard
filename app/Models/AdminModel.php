<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'full_name', 'profile_picture', 'is_active', 'last_login'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function verifyLogin($username, $password)
    {
        $admin = $this->where('username', $username)->orWhere('email', $username)->first();

        if (!$admin) {
            return false;
        }

        if (password_verify($password, $admin['password'])) {
            if (password_needs_rehash($admin['password'], PASSWORD_DEFAULT)) {
                $this->update($admin['id'], ['password' => $password]);
            }
            return $admin;
        }

        return false;
    }
}