<?php namespace App\Models;

use CodeIgniter\Model;

class ResortModel extends Model
{
    protected $table = 'resorts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'location', 'price_range',
        'facilities', 'contact_phone', 'contact_email',
        'website', 'image_url', 'is_featured', 'slug'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'description' => 'required|min_length[10]',
        'location' => 'required',
        'price_range' => 'required',
        'facilities' => 'required',
        'contact_phone' => 'required',
        'contact_email' => 'required|valid_email',
        'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]'
    ];
    
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['name'])) {
            $data['data']['slug'] = url_title($data['data']['name'], '-', true);
        }
        return $data;
    }

    public function getFeaturedResorts($limit = 3)
    {
        return $this->where('is_featured', 1)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }
}