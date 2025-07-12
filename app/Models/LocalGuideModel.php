<?php namespace App\Models;

use CodeIgniter\Model;

class LocalGuideModel extends Model
{
    protected $table = 'local_guides';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id',
        'full_name', 'email', 'phone', 'address', 'experience', 
        'languages', 'specialization', 'price_per_day', 'photo_url',
        'rating', 'is_verified', 'years_experience'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'full_name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email',
        'phone' => 'required|max_length[20]',
        'address' => 'required',
        'experience' => 'required',
        'languages' => 'required',
        'specialization' => 'required|in_list[diving,snorkeling,photography,cultural,adventure]',
        'price_per_day' => 'required|decimal',
        'years_experience' => 'required|numeric'
    ];
    
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already registered for another guide'
        ],
        'photo_url' => [
            'uploaded' => 'Please upload a valid photo',
            'is_image' => 'The uploaded file must be an image'
        ]
    ];
}