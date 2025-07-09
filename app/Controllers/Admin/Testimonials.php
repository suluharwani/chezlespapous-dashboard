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
        if (!$this->validate($this->testimonialModel->validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $photo = $this->request->getFile('photo');
        $photoName = $photo->getRandomName();
        $photo->move('uploads/testimonials', $photoName);
        
        $this->testimonialModel->save([
            'visitor_name' => $this->request->getPost('visitor_name'),
            'origin_country' => $this->request->getPost('origin_country'),
            'testimonial' => $this->request->getPost('testimonial'),
            'rating' => $this->request->getPost('rating'),
            'visit_date' => $this->request->getPost('visit_date'),
            'photo_url' => 'uploads/testimonials/' . $photoName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ]);
        
        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial added successfully');
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
        $rules['photo'] = 'max_size[photo,2048]|is_image[photo]';
        
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
        if ($photo->isValid() && !$photo->hasMoved()) {
            if ($testimonial['photo_url'] && file_exists($testimonial['photo_url'])) {
                unlink($testimonial['photo_url']);
            }
            
            $photoName = $photo->getRandomName();
            $photo->move('uploads/testimonials', $photoName);
            $data['photo_url'] = 'uploads/testimonials/' . $photoName;
        }
        
        $this->testimonialModel->update($id, $data);
        
        return redirect()->to('/admin/testimonials')
            ->with('success', 'Testimonial updated successfully');
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