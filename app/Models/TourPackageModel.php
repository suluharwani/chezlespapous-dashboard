<?php namespace App\Models;

use CodeIgniter\Model;

class TourPackageModel extends Model
{
    protected $table = 'tour_packages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'duration', 'price',
        'includes', 'itinerary', 'image_url'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[5]|max_length[100]',
        'description' => 'required',
        'duration' => 'required',
        'price' => 'required|numeric',
        'includes' => 'required'
    ];
    
    protected $validationMessages = [
        'price' => [
            'numeric' => 'Price must be a valid number'
        ],
        'duration' => [
            'required' => 'Package duration is required'
        ]
    ];
    
    public function getPopularPackages($limit = 4)
    {
        return $this->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }
    
    public function formatPrice($price)
    {
        return 'Rp' . number_format($price, 2, ',', '.');
    }
}