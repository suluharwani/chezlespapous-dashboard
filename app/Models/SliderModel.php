<?php namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'subtitle', 'image_url', 'button_text',
        'button_link', 'is_active', 'display_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[100]',
        'subtitle' => 'permit_empty|max_length[255]',
        'button_text' => 'permit_empty|max_length[50]',
        'button_link' => 'permit_empty|valid_url',
        'display_order' => 'permit_empty|integer'
    ];

    public function getActiveSliders()
    {
        return $this->where('is_active', 1)
                   ->orderBy('display_order', 'ASC')
                   ->findAll();
    }

    public function getMaxDisplayOrder()
    {
        return $this->selectMax('display_order')
                   ->get()
                   ->getRow()
                   ->display_order ?? 0;
    }
}