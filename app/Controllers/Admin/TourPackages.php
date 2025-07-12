<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TourPackageModel;
use Config\Services;

class TourPackages extends BaseController
{
    protected $tourPackageModel;
    protected $validation;
    
    public function __construct()
    {
        $this->tourPackageModel = new TourPackageModel();
        $this->validation = Services::validation();
        helper(['form', 'url', 'text']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Tour Packages',
            'packages' => $this->tourPackageModel->findAll(),
            'pager' => $this->tourPackageModel->pager
        ];
        
        return view('admin/tour_packages/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Tour Package',
            'validation' => $this->validation
        ];
        
        return view('admin/tour_packages/create', $data);
    }
    
    public function create()
{
    $rules = $this->tourPackageModel->validationRules;
    $rules['image'] = 'uploaded[image]|is_image[image]';
    
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
        if (!$image->move('uploads/tour_packages', $imageName)) {
            throw new \RuntimeException('Failed to upload image');
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'duration' => $this->request->getPost('duration'),
            'price' => $this->request->getPost('price'),
            'discount' => $this->request->getPost('discount') ?? 0,
            'includes' => $this->request->getPost('includes'),
            'itinerary' => $this->request->getPost('itinerary'),
            'image_url' => base_url().'uploads/tour_packages/' . $imageName, // Simpan path relatif saja
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];
        
        // Debug data sebelum disimpan
        // log_message('debug', 'Creating package with data: ' . print_r($data, true));
        
        $saveResult = $this->tourPackageModel->save($data);
        
        if (!$saveResult) {
            $dbError = $this->tourPackageModel->errors();
            log_message('error', 'Database error: ' . print_r($dbError, true));
            throw new \RuntimeException('Failed to save to database');
        }
        
        return redirect()->to('/admin/tour-packages')
            ->with('success', 'Tour package added successfully');
            
    } catch (\Exception $e) {
        // Cleanup: Hapus gambar yang sudah diupload jika ada error
        if ($imageName && file_exists('uploads/tour_packages/' . $imageName)) {
            unlink('uploads/tour_packages/' . $imageName);
        }
        
        // Log error untuk debugging
        log_message('error', 'Error creating tour package: ' . $e->getMessage());
        log_message('error', $e->getTraceAsString());
        
        // Dapatkan error database jika ada
        $dbError = $this->tourPackageModel->errors();
        $errorMessage = 'Failed to create package: ' . $e->getMessage();
        
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
        $package = $this->tourPackageModel->find($id);
        
        if (!$package) {
            return redirect()->to('/admin/tour-packages')
                ->with('error', 'Package not found');
        }
        
        $data = [
            'title' => 'Edit Tour Package',
            'package' => $package,
            'validation' => $this->validation
        ];
        
        return view('admin/tour_packages/edit', $data);
    }
    
public function update($id)
{
    $package = $this->tourPackageModel->find($id);
    
    if (!$package) {
        return redirect()->to('/admin/tour-packages')
            ->with('error', 'Package not found');
    }


    $data = [
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'duration' => $this->request->getPost('duration'),
        'price' => $this->request->getPost('price'),
        'discount' => $this->request->getPost('discount') ?? 0,
        'includes' => $this->request->getPost('includes'),
        'itinerary' => $this->request->getPost('itinerary'),
        'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
    ];

    $image = $this->request->getFile('image');
    $newImageName = null;
    
    try {
        if ($image->isValid() && !$image->hasMoved()) {
            // Validasi tambahan untuk gambar
            if (!$image->isValid()) {
                throw new \RuntimeException($image->getErrorString());
            }
            
            // Cek tipe file
            if (!in_array($image->getClientMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                throw new \RuntimeException('Invalid image format. Only JPEG, PNG, and WEBP are allowed.');
            }
            
            // Hapus gambar lama
            if ($package['image_url'] && file_exists($package['image_url'])) {
                if (!unlink($package['image_url'])) {
                    throw new \RuntimeException('Failed to delete old image');
                }
            }
            
            $newImageName = $image->getRandomName();
            if (!$image->move('uploads/tour_packages', $newImageName)) {
                throw new \RuntimeException('Failed to upload new image');
            }
            $data['image_url'] = base_url().'uploads/tour_packages/' . $newImageName;
        }

        // Debug: Tampilkan data sebelum update
        // log_message('debug', 'Updating package data: '.print_r($data, true));
        
        $updateResult = $this->tourPackageModel->update($id, $data);
        
        if (!$updateResult) {
            $dbError = $this->tourPackageModel->errors();
            log_message('error', 'Database error: '.print_r($dbError, true));
            throw new \RuntimeException('Failed to update database record');
        }
        
        return redirect()->to('/admin/tour-packages')
            ->with('success', 'Tour package updated successfully');
            
    } catch (\Exception $e) {
        // Cleanup: Hapus gambar baru jika upload berhasil tapi operasi lain gagal
        if ($newImageName && file_exists('uploads/tour_packages/'.$newImageName)) {
            unlink('uploads/tour_packages/'.$newImageName);
        }
        
        // Log error untuk debugging
        log_message('error', 'Error updating tour package: '.$e->getMessage());
        log_message('error', $e->getTraceAsString());
        
        // Dapatkan error database jika ada
        $dbError = $this->tourPackageModel->errors();
        $errorMessage = 'Failed to update package: '.$e->getMessage();
        
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
        $package = $this->tourPackageModel->find($id);
        
        if (!$package) {
            return redirect()->to('/admin/tour-packages')
                ->with('error', 'Package not found');
        }
        
        if ($package['image_url'] && file_exists($package['image_url'])) {
            unlink($package['image_url']);
        }
        
        $this->tourPackageModel->delete($id);
        
        return redirect()->to('/admin/tour-packages')
            ->with('success', 'Tour package deleted successfully');
    }
}