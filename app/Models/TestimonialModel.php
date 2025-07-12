<?php namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'visitor_name', 'origin_country', 'testimonial',
        'rating', 'visit_date', 'photo_url', 'is_featured'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'visitor_name' => 'required|min_length[3]|max_length[100]',
        'origin_country' => 'required|max_length[100]',
        'testimonial' => 'required|min_length[10]',
        'rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'visit_date' => 'required|valid_date',
        
    ];
    
    protected $validationMessages = [
        'rating' => [
            'less_than_equal_to' => 'Rating must be between 1-5'
        ]
    ];

    public function getFeaturedTestimonials($limit = 4)
    {
        return $this->where('is_featured', 1)
                   ->orderBy('visit_date', 'DESC')
                   ->limit($limit)
                   ->find();
    }

    public function getRecentTestimonials($limit = 5)
    {
        return $this->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }
}