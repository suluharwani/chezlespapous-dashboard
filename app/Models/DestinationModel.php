<?php namespace App\Models;

use CodeIgniter\Model;

class DestinationModel extends Model
{
    protected $table = 'destinations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'location', 'category', 
        'price_range', 'best_season', 'image_url', 'created_at'
    ];
    protected $useTimestamps = false;
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'required',
        'location' => 'required',
        'category' => 'required|in_list[diving,beach,island,viewpoint,cultural]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Destination name is required',
            'min_length' => 'Destination name must be at least 3 characters',
            'max_length' => 'Destination name cannot exceed 100 characters'
        ],
        'description' => [
            'required' => 'Description is required'
        ],
        'location' => [
            'required' => 'Location is required'
        ],
        'category' => [
            'required' => 'Category is required',
            'in_list' => 'Please select a valid category'
        ]
    ];
}