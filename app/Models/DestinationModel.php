<?php namespace App\Models;

use CodeIgniter\Model;

class DestinationModel extends Model
{
    protected $table = 'destinations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'location', 'category',
        'price_range', 'best_season', 'image_url'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'required',
        'location' => 'required',
        'category' => 'required|in_list[diving,beach,island,viewpoint,cultural]',
        'price_range' => 'permit_empty|decimal',
        'best_season' => 'permit_empty|max_length[100]',
        'image_url' => 'permit_empty'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Destination name is required',
            'min_length' => 'Name must be at least 3 characters'
        ],
        'category' => [
            'in_list' => 'Please select a valid category'
        ]
    ];
    
    public function getByCategory($category)
    {
        return $this->where('category', $category)
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }
}