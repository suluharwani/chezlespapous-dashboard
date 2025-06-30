<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\AdminModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $adminModel = new AdminModel();
        
        // Cek apakah sudah ada admin
        if ($adminModel->countAll() === 0) {
            $data = [
                'username' => 'admin',
                'email' => 'admin@rajaampat.com',
                'password' => 'rajaampat123', // Password akan di-hash oleh model
                'full_name' => 'Administrator',
                'is_active' => 1
            ];
            
            $adminModel->save($data);
            
            echo "Admin default berhasil dibuat!\n";
            echo "Username: admin\n";
            echo "Password: rajaampat123\n";
        } else {
            echo "Sudah ada admin di database, tidak membuat admin default.\n";
        }
    }
}
