<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;
use Config\Services;

class Sliders extends BaseController
{
    protected $sliderModel;
    protected $validation;
    
    public function __construct()
    {
        $this->sliderModel = new SliderModel();
        $this->validation = Services::validation();
        helper(['form', 'url']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Sliders',
            'sliders' => $this->sliderModel->orderBy('display_order', 'ASC')->findAll(),
            'pager' => $this->sliderModel->pager
        ];
        
        return view('admin/sliders/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Slider',
            'next_display_order' => $this->sliderModel->getMaxDisplayOrder() + 1,
            'validation' => $this->validation
        ];
        
        return view('admin/sliders/create', $data);
    }
    
public function create()
{
    // Tambahkan validasi untuk file upload
    $rules = $this->sliderModel->validationRules;
    $rules['image'] = 'uploaded[image]|max_size[image,5120]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
    
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }
    
    $image = $this->request->getFile('image');
    $imageName = null;
    
    try {
        // Validasi tambahan untuk gambar
        if (!$image->isValid()) {
            throw new \RuntimeException($image->getErrorString());
        }
        
        if ($image->hasMoved()) {
            throw new \RuntimeException('The image file has already been moved.');
        }
        
        // Validasi ukuran gambar (minimal dimensi)
        $imageInfo = getimagesize($image->getTempName());
        if ($imageInfo[0] < 1200 || $imageInfo[1] < 600) {
            throw new \RuntimeException('Image dimensions must be at least 1200x600 pixels');
        }
        
        $imageName = $image->getRandomName();
        if (!$image->move('uploads/sliders', $imageName)) {
            throw new \RuntimeException('Failed to upload slider image');
        }
        
        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'image_url' => base_url().'uploads/sliders/' . $imageName,
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'display_order' => $this->request->getPost('display_order') ?? 0
        ];
        
        // Debug data sebelum disimpan
        // log_message('debug', 'Creating slider with data: ' . print_r($data, true));
        
        $saveResult = $this->sliderModel->save($data);
        
        if (!$saveResult) {
            $dbError = $this->sliderModel->errors();
            log_message('error', 'Database error: ' . print_r($dbError, true));
            throw new \RuntimeException('Failed to save slider to database');
        }
        
        return redirect()->to('/admin/sliders')
            ->with('success', 'Slider added successfully');
            
    } catch (\Exception $e) {
        // Cleanup: Hapus gambar yang sudah diupload jika ada error
        if ($imageName && file_exists('uploads/sliders/' . $imageName)) {
            @unlink('uploads/sliders/' . $imageName);
        }
        
        // Log error untuk debugging
        log_message('error', 'Error creating slider: ' . $e->getMessage());
        log_message('error', $e->getTraceAsString());
        
        // Dapatkan error database jika ada
        $dbError = $this->sliderModel->errors();
        $errorMessage = 'Failed to create slider: ' . $e->getMessage();
        
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
        $slider = $this->sliderModel->find($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')
                ->with('error', 'Slider not found');
        }
        
        $data = [
            'title' => 'Edit Slider',
            'slider' => $slider,
            'validation' => $this->validation
        ];
        
        return view('admin/sliders/edit', $data);
    }
    
public function update($id)
{
    $slider = $this->sliderModel->find($id);
    
    if (!$slider) {
        return redirect()->to('/admin/sliders')
            ->with('error', 'Slider not found');
    }
    
    // Tambahkan validasi untuk file upload
    $rules = $this->sliderModel->validationRules;
    $rules['image'] = 'max_size[image,5120]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
    
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }
    
    $data = [
        'title' => $this->request->getPost('title'),
        'subtitle' => $this->request->getPost('subtitle'),
        'button_text' => $this->request->getPost('button_text'),
        'button_link' => $this->request->getPost('button_link'),
        'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        'display_order' => $this->request->getPost('display_order') ?? $slider['display_order']
    ];
    
    $image = $this->request->getFile('image');
    $newImageName = null;
    
    try {
        if ($image->isValid() && !$image->hasMoved()) {
            // Validasi tambahan untuk gambar
            if (!$image->isValid()) {
                throw new \RuntimeException($image->getErrorString());
            }
            
            // Validasi dimensi gambar (minimal 1200x600)
            $imageInfo = getimagesize($image->getTempName());
            if ($imageInfo[0] < 1200 || $imageInfo[1] < 600) {
                throw new \RuntimeException('Image dimensions must be at least 1200x600 pixels');
            }
            
            $newImageName = $image->getRandomName();
            
            // Hapus gambar lama jika ada
            if ($slider['image_url'] && file_exists($slider['image_url'])) {
                if (!unlink($slider['image_url'])) {
                    throw new \RuntimeException('Failed to delete old slider image');
                }
            }
            
            if (!$image->move('uploads/sliders', $newImageName)) {
                throw new \RuntimeException('Failed to upload new slider image');
            }
            
            $data['image_url'] = base_url().'uploads/sliders/' . $newImageName;
        }

        // Debug data sebelum update
        // log_message('debug', 'Updating slider with data: '.print_r($data, true));
        
        $updateResult = $this->sliderModel->update($id, $data);
        
        if (!$updateResult) {
            $dbError = $this->sliderModel->errors();
            log_message('error', 'Database error: '.print_r($dbError, true));
            throw new \RuntimeException('Failed to update slider in database');
        }
        
        return redirect()->to('/admin/sliders')
            ->with('success', 'Slider updated successfully');
            
    } catch (\Exception $e) {
        // Cleanup: Hapus gambar baru jika sudah diupload tapi operasi gagal
        if ($newImageName && file_exists('uploads/sliders/'.$newImageName)) {
            @unlink('uploads/sliders/'.$newImageName);
        }
        
        // Log error untuk debugging
        log_message('error', 'Error updating slider: '.$e->getMessage());
        log_message('error', $e->getTraceAsString());
        
        // Dapatkan error database jika ada
        $dbError = $this->sliderModel->errors();
        $errorMessage = 'Failed to update slider: '.$e->getMessage();
        
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
        $slider = $this->sliderModel->find($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')
                ->with('error', 'Slider not found');
        }
        
        if ($slider['image_url'] && file_exists($slider['image_url'])) {
            unlink($slider['image_url']);
        }
        
        $this->sliderModel->delete($id);
        
        return redirect()->to('/admin/sliders')
            ->with('success', 'Slider deleted successfully');
    }
    
    public function updateOrder()
    {
        $order = $this->request->getPost('order');
        
        foreach ($order as $i => $id) {
            $this->sliderModel->update($id, ['display_order' => $i + 1]);
        }
        
        return $this->response->setJSON(['success' => true]);
    }
}