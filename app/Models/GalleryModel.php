<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'description', 'image_url', 'category', 
        'location', 'is_featured', 'display_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[100]',
        'image_url' => 'required',
        'category' => 'required|in_list[nature,diving,culture,resort]'
    ];
    
    protected $validationMessages = [
        'title' => [
            'required' => 'Gallery title is required',
            'min_length' => 'Title must be at least 3 characters'
        ],
        'image_url' => [
            'required' => 'Please upload an image'
        ]
    ];
    
    public function getFeaturedGalleries($limit = 6)
    {
        return $this->where('is_featured', 1)
                   ->orderBy('display_order', 'ASC')
                   ->limit($limit)
                   ->find();
    }
}