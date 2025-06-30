<?php namespace App\Models;

use CodeIgniter\Model;

class ResortModel extends Model
{
    protected $table = 'resorts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'location', 'price_range',
        'facilities', 'contact_phone', 'contact_email',
        'website', 'image_url'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'required',
        'location' => 'required',
        'price_range' => 'required',
        'facilities' => 'required'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Resort name is required',
            'min_length' => 'Resort name must be at least 3 characters'
        ],
        'image_url' => [
            'uploaded' => 'Please upload a valid resort image'
        ]
    ];
    
    public function getFeaturedResorts($limit = 3)
    {
        return $this->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }
}