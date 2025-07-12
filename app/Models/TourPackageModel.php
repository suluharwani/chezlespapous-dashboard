<?php namespace App\Models;

use CodeIgniter\Model;

class TourPackageModel extends Model
{
    protected $table = 'tour_packages';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'duration', 'price',
        'includes', 'itinerary', 'image_url', 'slug',
        'is_featured', 'discount'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[5]|max_length[100]',
        'description' => 'required|min_length[20]',
        'duration' => 'required',
        'price' => 'required|numeric',
        'includes' => 'required',
        'itinerary' => 'required'
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

    public function getFeaturedPackages($limit = 4)
    {
        return $this->where('is_featured', 1)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }

    public function formatPrice($price)
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
}