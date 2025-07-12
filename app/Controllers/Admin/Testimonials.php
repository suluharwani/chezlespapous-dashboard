<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;
use Config\Services;

class Testimonials extends BaseController
{
    protected $testimonialModel;
    protected $validation;
    
    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
        $this->validation = Services::validation();
        helper(['form', 'url', 'date']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Testimonials',
            'testimonials' => $this->testimonialModel->orderBy('visit_date', 'DESC')->findAll(),
            'pager' => $this->testimonialModel->pager
        ];
        
        return view('admin/testimonials/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Testimonial',
            'validation' => $this->validation
        ];
        
        return view('admin/testimonials/create', $data);
    }
    
public function create()
{
    // Tambahkan validasi untuk file upload
    $rules = $this->testimonialModel->validationRules;
    $rules['photo'] = 'uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]';
    
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }
    
    $photo = $this->request->getFile('photo');
    $photoName = null;
    
    try {
        // Validasi tambahan untuk foto
        if (!$photo->isValid()) {
            throw new \RuntimeException($photo->getErrorString());
        }
        
        if ($photo->hasMoved()) {
            throw new \RuntimeException('The photo file has already been moved.');
        }
        
        $photoName = $photo->getRandomName();
        if (!$photo->move('uploads/testimonials', $photoName)) {
            throw new \RuntimeException('Failed to upload testimonial photo');
        }
        
        $data = [
            'visitor_name' => $this->request->getPost('visitor_name'),
            'origin_country' => $this->request->getPost('origin_country'),
            'testimonial' => $this->request->getPost('testimonial'),
            'rating' => $this->request->getPost('rating'),
            'visit_date' => $this->request->getPost('visit_date'),
            'photo_url' => base_url().'uploads/testimonials/' . $photoName, // Simpan path relatif saja
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];
        
        // Validasi rating antara 1-5
        if ($data['rating'] < 1 || $data['rating'] > 5) {
            throw new \RuntimeException('Rating must be between 1 and 5');
        }
        
        // Debug data sebelum disimpan
        // log_message('debug', 'Creating testimonial with data: ' . print_r($data, true));
        
        $saveResult = $this->testimonialModel->save($data);
        
        if (!$saveResult) {
            $dbError = $this->testimonialModel->errors();
            log_message('error', 'Database error: ' . print_r($dbError, true));
            throw new \RuntimeException('Failed to save testimonial to database');
        }
        
        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial added successfully');
            
    } catch (\Exception $e) {
        // Cleanup: Hapus foto yang sudah diupload jika ada error
        if ($photoName && file_exists('uploads/testimonials/' . $photoName)) {
            @unlink('uploads/testimonials/' . $photoName);
        }
        
        // Log error untuk debugging
        log_message('error', 'Error creating testimonial: ' . $e->getMessage());
        log_message('error', $e->getTraceAsString());
        
        // Dapatkan error database jika ada
        $dbError = $this->testimonialModel->errors();
        $errorMessage = 'Failed to create testimonial: ' . $e->getMessage();
        
        if ($dbError) {
            $errorMessage .= ' | Database error: ' . implode(', ', $dbError);
        }
        
        return redirect()->back()
            ->withInput()
            ->with('error', $errorMessage);
    }
}
    public function edit($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')
                ->with('error', 'Testimonial not found');
        }
        
        $data = [
            'title' => 'Edit Testimonial',
            'testimonial' => $testimonial,
            'validation' => $this->validation
        ];
        
        return view('admin/testimonials/edit', $data);
    }
    
    public function update($id)
{
    $testimonial = $this->testimonialModel->find($id);
    
    if (!$testimonial) {
        return redirect()->to('/admin/testimonials')
            ->with('error', 'Testimonial not found');
    }
    
    $rules = $this->testimonialModel->validationRules;
    $rules['photo'] = 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]';
    $rules['rating'] = 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[5]';
    
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }
    
    $data = [
        'visitor_name' => $this->request->getPost('visitor_name'),
        'origin_country' => $this->request->getPost('origin_country'),
        'testimonial' => $this->request->getPost('testimonial'),
        'rating' => $this->request->getPost('rating'),
        'visit_date' => $this->request->getPost('visit_date'),
        'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
    ];
    
    $photo = $this->request->getFile('photo');
    $newPhotoName = null;
    
    try {
        if ($photo->isValid() && !$photo->hasMoved()) {
            // Validasi tambahan untuk foto
            if (!$photo->isValid()) {
                throw new \RuntimeException($photo->getErrorString());
            }
            
            $newPhotoName = $photo->getRandomName();
            
            // Hapus foto lama jika ada
            if ($testimonial['photo_url'] && file_exists($testimonial['photo_url'])) {
                if (!unlink($testimonial['photo_url'])) {
                    throw new \RuntimeException('Failed to delete old photo');
                }
            }
            
            if (!$photo->move('uploads/testimonials', $newPhotoName)) {
                throw new \RuntimeException('Failed to upload new photo');
            }
            
            $data['photo_url'] = base_url().'uploads/testimonials/' . $newPhotoName; // Simpan path relatif
        }

        // Validasi rating
        if ($data['rating'] < 1 || $data['rating'] > 5) {
            throw new \RuntimeException('Rating must be between 1 and 5');
        }
        
        // Debug data sebelum update
        // log_message('debug', 'Updating testimonial with data: '.print_r($data, true));
        
        $updateResult = $this->testimonialModel->update($id, $data);
        
        if (!$updateResult) {
            $dbError = $this->testimonialModel->errors();
            log_message('error', 'Database error: '.print_r($dbError, true));
            throw new \RuntimeException('Failed to update testimonial in database');
        }
        
        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial updated successfully');
            
    } catch (\Exception $e) {
        // Cleanup: Hapus foto baru jika sudah diupload tapi operasi gagal
        if ($newPhotoName && file_exists('uploads/testimonials/'.$newPhotoName)) {
            @unlink('uploads/testimonials/'.$newPhotoName);
        }
        
        // Log error untuk debugging
        log_message('error', 'Error updating testimonial: '.$e->getMessage());
        log_message('error', $e->getTraceAsString());
        
        // Dapatkan error database jika ada
        $dbError = $this->testimonialModel->errors();
        $errorMessage = 'Failed to update testimonial: '.$e->getMessage();
        
        if ($dbError) {
            $errorMessage .= ' | Database error: '.implode(', ', $dbError);
        }
        
        return redirect()->back()
            ->withInput()
            ->with('error', $errorMessage);
    }
}
    
    public function delete($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')
                ->with('error', 'Testimonial not found');
        }
        
        if ($testimonial['photo_url'] && file_exists($testimonial['photo_url'])) {
            unlink($testimonial['photo_url']);
        }
        
        $this->testimonialModel->delete($id);
        
        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial deleted successfully');
    }
}