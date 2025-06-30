<?php namespace App\Models;

use CodeIgniter\Model;

class DiveSpotModel extends Model
{
    protected $table = 'dive_spots';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'location', 'depth_range',
        'current_level', 'marine_life', 'best_time', 'image_url'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'required',
        'location' => 'required',
        'depth_range' => 'required',
        'current_level' => 'required|in_list[low,medium,high]'
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Dive spot name is required'
        ],
        'current_level' => [
            'in_list' => 'Please select a valid current level'
        ]
    ];
}