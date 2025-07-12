<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GalleryModel;
use Config\Services;

class Galleries extends BaseController
{
    protected $galleryModel;
    protected $validation;
    
    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
        $this->validation = Services::validation();
        helper(['form', 'url', 'text']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Gallery',
            'galleries' => $this->galleryModel->orderBy('created_at', 'DESC')->findAll(),
            'categories' => ['nature', 'diving', 'culture', 'resort'],
            'pager' => $this->galleryModel->pager
        ];
        
        return view('admin/galleries/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Gallery Item',
            'categories' => ['nature', 'diving', 'culture', 'resort'],
            'validation' => $this->validation
        ];
        
        return view('admin/galleries/create', $data);
    }
    
public function create()
{
    // Tambahkan validasi untuk file upload
    $rules = $this->galleryModel->validationRules;
    $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
    
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
            throw new \RuntimeException('The file has already been moved.');
        }
        
        $imageName = $image->getRandomName();
        if (!$image->move('uploads/galleries', $imageName)) {
            throw new \RuntimeException('Failed to upload image');
        }
        
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'location' => $this->request->getPost('location'),
            'image_url' => base_url().'uploads/galleries/' . $imageName, // Simpan path relatif saja
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'display_order' => $this->request->getPost('display_order') ?? 0
        ];
        
        // Debug data sebelum disimpan
        // log_message('debug', 'Creating gallery item with data: ' . print_r($data, true));
        
        $saveResult = $this->galleryModel->save($data);
        
        if (!$saveResult) {
            $dbError = $this->galleryModel->errors();
            log_message('error', 'Database error: ' . print_r($dbError, true));
            throw new \RuntimeException('Failed to save to database');
        }
        
        return redirect()->to('/admin/galleries')
            ->with('success', 'Gallery item added successfully');
            
    } catch (\Exception $e) {
        // Cleanup: Hapus gambar yang sudah diupload jika ada error
        if ($imageName && file_exists('uploads/galleries/' . $imageName)) {
            @unlink('uploads/galleries/' . $imageName);
        }
        
        // Log error untuk debugging
        log_message('error', 'Error creating gallery item: ' . $e->getMessage());
        log_message('error', $e->getTraceAsString());
        
        // Dapatkan error database jika ada
        $dbError = $this->galleryModel->errors();
        $errorMessage = 'Failed to create gallery item: ' . $e->getMessage();
        
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
        $gallery = $this->galleryModel->find($id);
        
        if (!$gallery) {
            return redirect()->to('/admin/galleries')
                ->with('error', 'Gallery item not found');
        }
        
        $data = [
            'title' => 'Edit Gallery Item',
            'gallery' => $gallery,
            'categories' => ['nature', 'diving', 'culture', 'resort'],
            'validation' => $this->validation
        ];
        
        return view('admin/galleries/edit', $data);
    }
    
    public function update($id)
    {
        $gallery = $this->galleryModel->find($id);
        
        if (!$gallery) {
            return redirect()->to('/admin/galleries')
                ->with('error', 'Gallery item not found');
        }
        
        $rules = $this->galleryModel->validationRules;
        $rules['title'] = "required|min_length[3]|max_length[100]";
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'location' => $this->request->getPost('location'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'display_order' => $this->request->getPost('display_order') ?? 0
        ];
        
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            if ($gallery['image_url'] && file_exists($gallery['image_url'])) {
                unlink($gallery['image_url']);
            }
            
            $imageName = $image->getRandomName();
            $image->move('uploads/galleries', $imageName);
            $data['image_url'] = base_url().'uploads/galleries/' . $imageName;
        }
        
        $this->galleryModel->update($id, $data);
        
        return redirect()->to('/admin/galleries')
            ->with('success', 'Gallery item updated successfully');
    }
    
    public function delete($id)
    {
        $gallery = $this->galleryModel->find($id);
        
        if (!$gallery) {
            return redirect()->to('/admin/galleries')
                ->with('error', 'Gallery item not found');
        }
        
        if ($gallery['image_url'] && file_exists($gallery['image_url'])) {
            unlink($gallery['image_url']);
        }
        
        $this->galleryModel->delete($id);
        
        return redirect()->to('/admin/galleries')
            ->with('success', 'Gallery item deleted successfully');
    }
}