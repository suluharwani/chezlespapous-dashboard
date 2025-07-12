<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'description', 'image_url', 'category',
        'location', 'is_featured', 'display_order', 'slug'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[100]',
        'description' => 'permit_empty|max_length[500]',
        'category' => 'required|in_list[nature,diving,culture,resort]',
        'location' => 'permit_empty|max_length[100]',
    ];
    
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title'])) {
            $data['data']['slug'] = url_title($data['data']['title'], '-', true);
        }
        return $data;
    }

    public function getFeaturedGalleries($limit = 6)
    {
        return $this->where('is_featured', 1)
                   ->orderBy('display_order', 'ASC')
                   ->limit($limit)
                   ->find();
    }

    public function getByCategory($category)
    {
        return $this->where('category', $category)
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
}